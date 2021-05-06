<?php

namespace App\Http\Controllers;

use App\Loja;
use App\Servicos\Nfe\NfePdfServico;
use App\Servicos\Nfe\NfeServico;
use App\VServicosNfe;
use App\Servico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NfeController extends Controller
{
    protected $servico = null;
    protected $pdf_servico = null;

    public function __construct(NfeServico $servico, NfePdfServico $pdf_servico)
    {
        $this->servico = $servico;
        $this->pdf_servico = $pdf_servico;
    }

    public function index()
    {
        $servicos = VServicosNfe::where('data', Carbon::today())
            ->orderBy('renavam')
            ->get();

        $data = Carbon::today();
        $lojas = Loja::all();

        return view('nfe.index', compact('servicos', 'data', 'lojas'));
    }

    public function centraAcoes(Request $request)
    {
        $dados = $request->all();
        if(!$dados){
            return redirect()->route('nota-fiscal.index');
        }
        if(isset($dados['nfe'])){
            if($dados['nfe']['acao']=='gerar'){
                $ids = explode(',', $dados['nfe']['ids']);
                $return = $this->gerar($ids);
                $request->session()->flash($return['tipo'], $return['mensagem']);
            } else if($dados['nfe']['acao']=='baixar'){
                $this->baixar($dados['nfe']['ids']);
            }

        }
        $result = $this->filtrar($dados);
        return view('nfe.index', $result);
    }

    private function gerar($servicos_ids)
    {
        $servicos_ids = (array) $servicos_ids;
        $v_servicos_nfe_dados = VServicosNfe::whereIn('id',$servicos_ids)->get();

        // GERAR
        if($v_servicos_nfe_dados->count()){
            $nfe_dados = $v_servicos_nfe_dados->toArray();

            $tomadores_notas = $this->servico->agruparNotas($nfe_dados);
            $tomadores_notas = $this->servico->prepararDados($tomadores_notas);
            foreach ($tomadores_notas as $tomador_id => $notas) {
                $servicos_ids = collect($notas)->pluck('id')->toArray();
                $nfe_dados = $notas;
                $nfe_xml = $this->servico->gerar($nfe_dados);
                if($nfe_xml){
                    // ASSINAR
                    $nfe_assinado = $this->servico->assinar($nfe_xml);
                    if($nfe_assinado){
                        // TRANSMITIR
                        $nfe_transmitido = $this->servico->transmitir($nfe_assinado);
                        $nfe_transmitido_array = $this->servico->xml2array($nfe_transmitido);

                        $transmitir_erro = $this->servico->pegarErroRetornoWs($nfe_transmitido_array);

                        dd($transmitir_erro);
                        if( ! $transmitir_erro){
                            $lote = $this->servico->consultarNotasPorLote($nfe_transmitido_array['Protocolo']);
                            $lote_array = $this->servico->xml2array($lote);
                            $num_nota_fiscal = $lote_array['ListaNfse']['CompNfse']['Nfse']['InfNfse']['Numero'];

                            // GRAVAR XML NO DB
                            DB::beginTransaction();
                            $nfe = $this->servico->gravarNoBD($nfe_transmitido_array, $num_nota_fiscal, $nfe_assinado);
                            $nota_com_servico = null;
                            if($nfe){
                                $nota_com_servico = Servico::whereIn('id', $servicos_ids)->update([
                                    'nfe_id' => $num_nota_fiscal
                                ]);

                                if ($nota_com_servico) {
                                   DB::commit();
                                } else {
                                    DB::rollback();
                                    $erro = 1;
                                    $mensagem = 'Ocorreu algum problema ao registrar a nota ao serviço no banco';
                                }
                            }
                            else {
                                $erro = 1;
                                $mensagem = 'Ocorreu algum problema ao guardar o XML no banco';
                            }
                        }
                        else {
                            $erro = 1;
                            $mensagem = "Erro ao transmitir a NFS-e: {$transmitir_erro[0]['Mensagem']} | {$transmitir_erro[0]['Correcao']}";
                        }
                    }
                    else {
                        $erro = 1;
                        $mensagem = 'Ocorreu algum problema ao assinar a NFS-e';
                    }
                }
                else {
                    $erro = 1;
                    $mensagem = 'Ocorreu algum problema ao gerar a NFS-e';
                }
            }
        }
        else {
            $erro = 1;
            $mensagem = 'Não há notas para serem geradas';
        }



        if($erro??0){
            $mensagens = [
                'tipo' => 'error',
                'mensagem' => $mensagem,
            ];
        }
        else {
            $mensagens = [
                'tipo' => 'success',
                'mensagem' => 'Nota(s) fiscal(is) gerada(s) com sucesso',
            ];
        }

        return $mensagens;

    }

    public function baixar($ids)
    {
        $ids = explode(',',$ids);
        $nfe_ids = Servico::whereIn('id',$ids)->get()->pluck('nfe_id');

        $notas = $this->servico->model->whereIn('numero',$nfe_ids)->get();
        $pdfs = $this->pdf_servico->gerar($notas->toArray());

        $pdf = implode('',$pdfs);

        // dd($pdf);
        $html = "<!DOCTYPE html>
        <html>

        <head>
          <style>
            body{
              font-size: 12px;
              font-family: Arial, Helvetica, sans-serif;
            }
            p {
              height: 7px;
            }
            #tabela-nfe td {
              height: 20px;
              width: 80px;
            }
          </style>
        </head>

        <body>
        $pdf
        </body>
        </html>
        ";
        return \PDF::loadHTML($html)->stream();
    }

    private function filtrar($dados)
    {
        switch ($dados['servico']) {
            //caso USADOS
            case 'U':
                $servicos = VServicosNfe::where('servico', 'U')
                    ->where('loja_id', 'LIKE', $dados['loja_id'])
                    ->whereBetween(DB::raw('DATE(data)'), array($dados['dataInicio'], $dados['dataFim']))
                    ->orderBy('data', 'DESC')
                    ->get();
                break;

            //caso EMPLACAMENTOS
            case 'E':
                $servicos = VServicosNfe::where('servico', 'E')
                    ->where('loja_id', 'LIKE', $dados['loja_id'])
                    ->whereBetween(DB::raw('DATE(data)'), array($dados['dataInicio'], $dados['dataFim']))
                    ->orderBy('data', 'DESC')
                    ->get();
                break;

            //caso pagamento PAGOS
            case '%':
                $servicos = VServicosNfe::whereBetween(DB::raw('DATE(data)'), array($dados['dataInicio'], $dados['dataFim']))
                    ->where('loja_id', 'LIKE', $dados['loja_id'])
                    ->orderBy('data', 'DESC')
                    ->get();
                break;

            default:

                break;
        }

        // dd($servicos);

        $tiposervico = $dados['servico'];

        $dataInicio = $dados['dataInicio'];

        $dataFim = $dados['dataFim'];

        $loja = Loja::find($dados['loja_id']);

        $lojas = Loja::all();

        return compact('servicos', 'tiposervico', 'dataInicio', 'dataFim', 'loja', 'lojas');


    }

}
