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
            url: " " + base_url + "/modelo/getmodel",
            dataSrc: "",
        },
        columns: [
            { data: "model" },
            { data: "nombre" },
            { data: "edad" },           
            { data: "fecha_inicio" },
            { data: "fecha_creacion" },
            { data: "nivel_ingles" },
            { data: "consultas" },           
            { data: "options" },
        ],
    });

    let formModelo = document.querySelector("#formModelo");
    formModelo.onsubmit = function(e) {
        e.preventDefault();

        let nacimiento = document.querySelector("#nacimiento").value;
        let antiguedad = document.querySelector("#antiguedad").value;
        let ingles = document.querySelector("#ingles").value;
        console.log(ingles);
      

        if (
            nacimiento == "" ||
            antiguedad == "" 
        ) {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        if (ingles ==0) {
            Swal.fire("Atención", "Obligatorio campo de ingles", "error");
            return false;
        }

        divLoading.style.display = "flex";
        let request = window.XMLHttpRequest ?
            new XMLHttpRequest() :
            new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/modelo/setModelo";
        let formData = new FormData(formModelo);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    document.querySelector("#titleModal").innerHTML =
                        "Actualizar usuario";
                    document.querySelector("#btnmodelo").innerHTML =
                        "Actualizar usaurio";
                    document
                        .querySelector("#btnmodelo")
                        .classList.replace("btn-primary", "btn-warning");


              
                    Swal.fire("", objData.msg, "success");

                    tableModelos.api().ajax.reload();
                    cerrarModal();
                    // $('#modalFormUsuario').modal("hide");
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            }
            divLoading.style.display = "none";
            return false;
        };
    };

})



function cerrarModal() {
    tableModelos.api().ajax.reload();
    document.querySelector("#formModelo").reset();
    $("#modalFormModelo").modal("hide");
}

function fntEditInfo(element, idmodelo) {
    
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector("#btnmodelo").innerHTML = "Actualizar modelo";
    document.querySelector("#titleModal").innerHTML = "Actualizar modelo";

    document
        .querySelector("#btnmodelo")
        .classList.replace("btn-primary", "btn-warning");

    let request = window.XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/modelo/getModelo/" + idmodelo;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
               
                let objmodelo = objData.modelo;            
             

                document.querySelector("#formModelo").reset();
                document.querySelector("#idemodelo").value = objmodelo.idusuariobot;

                // tableSeguridadSocialDatos(objusaurio.idusuario);

                document.querySelector("#modelo").value = objmodelo.nombre;
                var nacimiento = "\"" + objmodelo.edad+"\"" ;
                console.log(nacimiento);
                 

                document.querySelector("#nacimiento").value = objmodelo.edad;
                //document.getElementById("nacimiento").valueAsDate = 
                //document.getElementById("nacimiento").valueAsDate  =  "\"2021-10-17\"";;

              

                document.querySelector("#antiguedad").value = objmodelo.fecha_inicio;

                document.querySelector("#ingles").value = objmodelo.nivel_ingles;

             

                var idSetTimeout;
                idSetTimeout = setTimeout(
                    function() {
                        $("#ingles").change();
                    },
                    500,
                    $(this)
                );

                $("#modalFormModelo").modal("show");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    };
}