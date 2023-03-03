 var tableModelos;
let rowTable = "";


document.addEventListener("DOMContentLoaded", function() {

    tableModelos = $("#table_modelos").dataTable({
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
            url: " " + base_url + "/analisis/getmodel",
            dataSrc: "",
        },
        columns: [
            { data: "nombre" },
            { data: "consultas" },           
            { data: "options" },
        ],
    });

})

window.addEventListener(
    "load",
    function() {
        if (document.querySelector("#graphDiv")){
            loadgrap();
            loadgrapMIN();
            loadgrapbANDEJA();
        }

        if (document.querySelector("#graphDivmodelo")){
            let modelo = document.querySelector("#idmodelo").value;
            loadgrapModelo(modelo);
            loadgrapMINModelo(modelo);
          
        }
      
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
              title: 'Consultas vr tiempo general consulta por horas',
              uirevision:'true',
              xaxis: {autorange: true},
              yaxis: {autorange: true}
            };
        
            var data = [data2, data3];
            Plotly.newPlot(graphDiv, data, layout);
        }
    };
}




}

function loadgrapMIN() {
    if (document.querySelector("#graphDivmin")) {
        let ajaxUrl2 = base_url + "/analisis/getdatamin";
        let request2 = window.XMLHttpRequest ?
            new XMLHttpRequest() :
            new ActiveXObject("Microsoft.XMLHTTP");
        request2.open("GET", ajaxUrl2, true);
        request2.send();
        request2.onreadystatechange = function() {
            if (request2.readyState == 4 && request2.status == 200) {
                let objData = JSON.parse(request2.responseText);           
               
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
                  title: 'Consultas vr tiempo consulta por minutos',
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
   
function loadgrapbANDEJA() {
        if (document.querySelector("#graphDivBandeja")) {
            let ajaxUrl = base_url + "/analisis/getdatDefault";
            let request = window.XMLHttpRequest ?
                new XMLHttpRequest() :
                new ActiveXObject("Microsoft.XMLHTTP");
            request.open("GET", ajaxUrl, true);
            request.send();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);           
                    let general = objData.general;
                    let bandeja =  objData.bandeja;
                    var datesmsj = new Array();
                    var datesbandeja = new Array();
                    var bandejamsj = new Array();
                    var msj =  new Array();
                    general.forEach(function(element) {
                        datesmsj.push(element.INI_GENERAL);              
                        msj.push(element.COUNT_GENERAL)
                      });
        
                      bandeja.forEach(function(element) {
                        datesbandeja.push(element.INI_BANDEJA);              
                        bandejamsj.push(element.COUNT_BANDEJA)
                      });
        
                  var data2 = {
                        x: datesmsj,
                        y: msj,
                        type: 'scatter',       
                        name:'General',
                      };
        
                    
        
                      var data3 = {
                        x: datesbandeja,
                        y: bandejamsj,
                        type: 'scatter',
                        name: 'Bandeja'
                      };
                    
                
                    var layout = {
                      title: 'Consultas vr tiempo mesanjes general y mensajes default',
                      uirevision:'true',
                      xaxis: {autorange: true},
                      yaxis: {autorange: true}
                    };
                    var myPlot = document.getElementById('graphDivBandeja');
                    var data = [data2, data3];
                    Plotly.newPlot(myPlot, data, layout);
                }
            };
        }
}

function loadgrapModelo(modelo) {
            if (document.querySelector("#graphDivmodelo")) {
            let ajaxUrl = base_url + "/analisis/getdataModelo/"+modelo;
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
                      title: 'Consultas vr tiempo general consulta por horas',
                      uirevision:'true',
                      xaxis: {autorange: true},
                      yaxis: {autorange: true}
                    };
                    var myPlot = document.getElementById('graphDivmodelo');
                    var data = [data2, data3];
                    Plotly.newPlot(myPlot, data, layout);
                }
            };
        }
        
        
        
        
}
        
function loadgrapMINModelo(modelo) {
            if (document.querySelector("#graphDivminmodelo")) {
                let ajaxUrl2 = base_url + "/analisis/getdataminmodelo/"+modelo;
                let request2 = window.XMLHttpRequest ?
                    new XMLHttpRequest() :
                    new ActiveXObject("Microsoft.XMLHTTP");
                request2.open("GET", ajaxUrl2, true);
                request2.send();
                request2.onreadystatechange = function() {
                    if (request2.readyState == 4 && request2.status == 200) {
                        let objData = JSON.parse(request2.responseText);           
                       
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
                          title: 'Consultas vr tiempo consulta por minutos',
                          uirevision:'true',
                          xaxis: {autorange: true},
                          yaxis: {autorange: true}
                        };
                        var myPlot = document.getElementById('graphDivminmodelo');
                        var data = [data2, data3];
                        Plotly.newPlot(myPlot, data, layout);
                    }
                };
            }
}
           
