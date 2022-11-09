 var tableEmocion;
let rowTable = "";

document.addEventListener("DOMContentLoaded", function() {

    tableEmocion = $("#table_consultas").dataTable({
        bProcessing: true,
        bStateSave: true,
        resonsieve: true,
        bDestroy: true,
        select: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ],
        dom: "lBSQfrtip",
        //dom: '<"top"Blif>rt<"bottom"p><"clear">',
        dom: '<"top"lBfi>rt<"bottom"p><"clear" i>',
        //  dom: '<"wrapper"flipt>',
        lengthMenu: [
            [10, 20, 30, 50, -1],
            ["10", "20", "30", "50 ", "Ver todo"],
        ],
        buttons: [{
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'></i> Excel",
                titleAttr: "Esportar a Excel",
                className: "btn btn-success",
            },
            {
                extend: "pdfHtml5",
                text: "<i class='fas fa-file-pdf'></i> PDF",
                titleAttr: "Esportar a PDF",
                className: "btn btn-danger",
            },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        ajax: {
            url: " " + base_url + "/analisis/getdata",
            dataSrc: "",
        },
        columns: [
            { data: "INI_BOT" },
            { data: "COUNT_MENS" },
            { data: "COUNT_BOT" }
           
        ],
    });
}
);
  
   