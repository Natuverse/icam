 var tableEmocion;
let rowTable = "";

document.addEventListener("DOMContentLoaded", function() {
    if (document.querySelector("#table_consultas")) {
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

if (document.querySelector("#table_consultas_min")) {
    tableEmocion = $("#table_consultas_min").dataTable({
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
            url: " " + base_url + "/analisis/getdatamin",
            dataSrc: "",
        },
        columns: [
            { data: "INI_BOT" },
            { data: "COUNT_MENS" },
            { data: "COUNT_BOT" }
           
        ],
    });
}
}
);

window.addEventListener(
    "load",
    function() {
       loadgrap();
    },
    false
);

function loadgrap() {
    if (document.querySelector("#graphDiv")) {
    let ajaxUrl = base_url + "/analisis/getdata";
    let request = window.XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);           
           
            var dates = new Array();
            var bot = new Array();
            var msj =  new Array();
            objData.forEach(function(element) {
                dates.push(element.INI_BOT);
                bot.push(element.COUNT_BOT);
                msj.push(element.COUNT_MENS)
              });

            var data2 = {
                x: dates,
                y: bot,
                type: 'scatter',       
                name:'icam',
              };
              var data3 = {
                x: dates,
                y: msj,
                type: 'scatter',
                name: 'mjs'
              };
            
        
            var layout = {
              title: 'Consultas vr tiempo',
              uirevision:'true',
              xaxis: {autorange: true},
              yaxis: {autorange: true}
            };
        
            var data = [data2, data3];
            Plotly.newPlot(graphDiv, data, layout);
        }
    };
}

if (document.querySelector("#graphDivmin")) {
    let ajaxUrl = base_url + "/analisis/getdatamin";
    let request = window.XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);           
           
            var dates = new Array();
            var bot = new Array();
            var msj =  new Array();
            objData.forEach(function(element) {
                dates.push(element.INI_BOT);
                bot.push(element.COUNT_BOT);
                msj.push(element.COUNT_MENS)
              });

            var data2 = {
                x: dates,
                y: bot,
                type: 'scatter',       
                name:'icam',
              };
              var data3 = {
                x: dates,
                y: msj,
                type: 'scatter',
                name: 'mjs'
              };
            
        
            var layout = {
              title: 'Consultas vr tiempo',
              uirevision:'true',
              xaxis: {autorange: true},
              yaxis: {autorange: true}
            };
            var myPlot = document.getElementById('graphDivmin');
            var data = [data2, data3];
            Plotly.newPlot(myPlot, data, layout);
        }
    };
}


}
   