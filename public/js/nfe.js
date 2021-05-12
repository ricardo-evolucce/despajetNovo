
let notas_selecionadas = [];

let ativarDataTableCheckboxes = function () {
    let dt = $("#table").DataTable();

    $(".selectAll").click(function (e) {
        if ($(this).is(":checked")) {
            dt.rows().select();
            exibirOcultarBotoes(dt.rows(".selected"));
        } else {
            dt.rows().deselect();
            exibirOcultarBotoes(dt.rows(".selected"));
        }
    });
    $("#table tbody tr")
        .find("td:first")
        .on("click", function () {
            $(this).parents("tr").toggleClass("selected");
            exibirOcultarBotoes(dt.rows(".selected"));
        });
};

let exibirOcultarBotoes = function (rows) {
    notas_selecionadas = rows
    let dt = $("#table").DataTable();
    let tem_notas_pra_gerar = dt.rows('.selected').nodes().to$().find('.gerar-nfe').length > 0
    let tem_notas_pra_baixar = dt.rows('.selected').nodes().to$().find('.baixar-nfe').length > 0
    if (tem_notas_pra_gerar) {
        dt.buttons().container().find('#btn-nfe-gerar').removeClass("hide");
    } else {
        dt.buttons().container().find('#btn-nfe-gerar').addClass("hide");
    }
    if (tem_notas_pra_baixar) {
        dt.buttons().container().find('#btn-nfe-baixar').removeClass("hide");
    } else {
        dt.buttons().container().find('#btn-nfe-baixar').addClass("hide");
    }
};

let gerar = function(notas_ids){
    $('#nfe_acao').val('gerar')
    $('#nfe_ids').val(notas_ids.join(','))
    $('form').submit()
}

let baixar = function(notas_ids){
    let notas_str = notas_ids.join(',')

    $('body').prepend(`
        <a href="/nota-fiscal/baixar/${notas_str}" target="_blank" class="btn btn-info baixar-gruponfe" name="baixarnfe" data-id="${notas_str}" >
            <i class="fas fa-file-download"></i>
        </a>
    `);
    $('a.baixar-gruponfe')[0].click();
    $('a.baixar-gruponfe').remove()
}

$(document).ready(function () {

    $("#table").DataTable({
        rowId: "id",
        order: [[1, "desc"]],
        dom: "Bfrtip",
        buttons: [
            "copy",
            "csv",
            "excel",
            "print",
            {
                text: "Gerar notas fiscais",
                attr: {
                    class: "btn btn-info hide",
                    id: "btn-nfe-gerar",
                },
                action: function (e, dt, button, config) {
                    let notas_ids = notas_selecionadas.ids().toArray();
                    gerar(notas_ids)
                },
            },
            {
                text: "Baixar notas fiscais",
                attr: {
                    class: "btn btn-info hide",
                    id: "btn-nfe-baixar",
                },
                action: function (e, dt, button, config) {
                    let notas_ids = notas_selecionadas.ids().toArray();
                    baixar(notas_ids)
                },
            },
        ],

        language: {
            url:
                "http://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json",
        },
        "paging": false,
        columns: [
            { data: "---" },
            { data: "id" },
            { data: "data" },
            { data: "pedido" },
            { data: "cliente" },
            { data: "placa" },
            { data: "renavam" },
            { data: "loja" },
            {
                data: "guia",
                render: $.fn.dataTable.render.number(".", ",", 2, ""),
            },
            {
                data: "ipva",
                render: $.fn.dataTable.render.number(".", ",", 2, ""),
            },
            {
                data: "provisorio",
                render: $.fn.dataTable.render.number(".", ",", 2, ""),
            },
            {
                data: "placa esp",
                render: $.fn.dataTable.render.number(".", ",", 2, ""),
            },
            {
                data: "outros",
                render: $.fn.dataTable.render.number(".", ",", 2, ""),
            },
            {
                data: "valor",
                render: $.fn.dataTable.render.number(".", ",", 2, ""),
            },
            {
                data: "nota",
                render: function (nfe_id, type, row) {
                    let button = `
                            <button type="button" class="btn btn-success gerar-nfe" name="gerarnfe" data-servico-id="${row.id}" >
                                Gerar
                            </button>
                    `;
                    if (nfe_id) {
                        button = `
                            <a href="/nota-fiscal/baixar/${row.id}" target="_blank" class="btn btn-info baixar-nfe" name="baixarnfe" data-id="${row.id}" >
                                <i class="fas fa-file-download"></i>
                            </a>
                        `;
                    }
                    return button;
                },
            },
           
        ],
        columnDefs: [
            {
                orderable: false,
                targets: 0,
                className: "select-checkbox",
            },
        ],
        select: {
            style: "multi+shift",
            selector: "td:first-child",
        },
        // createdRow: function (nRow, aData, iDataIndex) {
        //     $(nRow).attr("id", aData['id']);
        //     // ativarDataTableCheckboxes();
        // },
        fnDrawCallback: function (oSettings) {
            ativarDataTableCheckboxes();
        },

        footerCallback: function (row, data, start, end, display) {
            let col_total = 13;
            var api = this.api(),
                data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };

            // Total over all pages
            total = api
                .column(col_total)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(col_total, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var numFormat = $.fn.dataTable.render.number( '.', ',', 2 ).display;

            // Update footer
            $(api.column(col_total).footer()).html(
                numFormat(pageTotal));
        },
    });


    $('.gerar-nfe').click(function(e) {
        let id = $(this).data('servico-id');
        let notas_ids = [];
        notas_ids.push(id)
        gerar(notas_ids)
    })

});
