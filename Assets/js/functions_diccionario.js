$(document).ready(function() {

    $("#fotoRegistro").on("change", function() {
        var uploadFoto = document.getElementById("fotoRegistro").value;
        var foto = document.getElementById("fotoRegistro").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById("form_alertfoto");
        if (uploadFoto != "") {
            var type = foto[0].type;
            var name = foto[0].name;
            if (type != "image/jpeg" && type != "image/jpg" && type != "image/png") {
                contactAlert.innerHTML =
                    '<p class="errorArchivo">El archivo no es válido.</p>';
                if (document.querySelector("#imgregistro")) {
                    document.querySelector("#imgregistro").remove();
                }
                $(".delFotoRegistro").addClass("notBlock");
                $("#prevRegistro").val("");
                return false;
            } else {
                contactAlert.innerHTML = "";
                $("#imgregistro").remove();
                $(".delFotoRegistro").removeClass("notBlock");
                var objeto_url = nav.createObjectURL(this.files[0]);
                document.querySelector(".prevRegistro div").innerHTML =
                    "<img id='imgregistro' src=" + objeto_url + ">";
                $("#imgregistro").addClass("img-profile");
                $(".upimg label").remove();
            }
        } else {
            alert("No selecciono foto");
        }
    });

    $(".delFotoRegistro").click(function() {
        $("#fotoRegistro").val("");
        $(".delFotoRegistro").addClass("notBlock");
        if (document.querySelector("#imgregistro")) {
            document.querySelector("#imgregistro").remove();
        }
        $("#image_remove").val(1);
    });


});

var tableDiccionario;
let rowTable = "";

document.addEventListener("DOMContentLoaded", function() {

    tableDiccionario = $("#tableDiccionario").dataTable({
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
            url: " " + base_url + "/diccionario/getDiccionario",
            dataSrc: "",
        },
        columns: [
            { data: "iddiccionario" },
            { data: "imagen" },
            { data: "palabra" },
            { data: "significado_en" },
            { data: "traduccion_es" },
            { data: "significado_es" },
            { data: "options" },
        ],
    });



      //NUEVA PALABRA
      let formDiccionario = document.querySelector("#formDiccionario");
      formDiccionario.onsubmit = function(e) {
          e.preventDefault();
        
  
          divLoading.style.display = "flex";
          let request = window.XMLHttpRequest ?
              new XMLHttpRequest() :
              new ActiveXObject("Microsoft.XMLHTTP");
          let ajaxUrl = base_url + "/diccionario/setPalabra";
          let formData = new FormData(formDiccionario);
          request.open("POST", ajaxUrl, true);
          request.send(formData);
          request.onreadystatechange = function() {
              if (request.readyState == 4 && request.status == 200) {
                  let objData = JSON.parse(request.responseText);
                  if (objData.status) {
                      document.querySelector("#titleModal").innerHTML =
                          "Actualizar palabra";
                      document.querySelector("#btnDiccionario").innerHTML =
                          "Actualizar palaba";
                      document
                          .querySelector("#btnDiccionario")
                          .classList.replace("btn-primary", "btn-warning");

                      document.querySelector("#iddiccionario").value = objData.iddiccionario;

                      document.querySelector("#image_actual").value = objData.image;
                      document.querySelector("#image_remove").value =0;


                      if(rowTable == ""){
                        tableDiccionario.api().ajax.reload();
                    }else{
                        
                        $url ="<img src='https://devstec.digital/Assets/images/uploads/diccionario/"+objData.image+"' class='rounded-circle  rounded' width='50px' height='50px' alt=''>";
                        
                        
                        rowTable.cells[0].textContent = objData.iddiccionario;
                        rowTable.cells[1].innerHTML =  $url
                        rowTable.cells[2].textContent = objData.palabra;
                        rowTable.cells[3].textContent = objData.significado_en;
                        rowTable.cells[4].innerHTML = objData.traduccion_es;
                        rowTable.cells[5].innerHTML = objData.significado_es;
                        rowTable = ""; 
                    }
  
                      Swal.fire("", objData.msg, "success");
  
                      
                      $("#modalDiccionario").modal("hide");
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
});


function openModal() {
    tableDiccionario = "";
  

    document
    .querySelector("#btnDiccionario")
    .classList.replace("btn-warning", "btn-primary");
document.querySelector("#btnDiccionario").innerHTML = "Crear palabra";
document.querySelector("#titleModal").innerHTML = "Nuevo palabra";
document.querySelector("#formDiccionario").reset();


document.querySelector("#image_remove").value =0;
document.querySelector("#image_actual").value ="";
document.querySelector("#iddiccionario").value ="";

removePhotos();

    $("#modalDiccionario").modal("show");
}

function cerrarModal() {
    //tableDiccionario.api().ajax.reload();
    document.querySelector("#image_remove").value ="0";
    document.querySelector("#image_actual").value ="";
    document.querySelector("#iddiccionario").value ="";
    document.querySelector("#formDiccionario").reset();
    $("#modalDiccionario").modal("hide");
   
}


function fntEditInfo(element, iddiccionario) {
 
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector("#btnDiccionario").innerHTML = "Actualizar palabra";
    document.querySelector("#titleModal").innerHTML = "Actualizar palabra";
    document
        .querySelector("#btnDiccionario")
        .classList.replace("btn-primary", "btn-warning");

    let request = window.XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/diccionario/getPalabra/" + iddiccionario;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let htmlImage = "";
                let objpalabra = objData.palabra;

                removePhotos();
                document.querySelector("#formDiccionario").reset();
             

                document.querySelector("#iddiccionario").value = objpalabra.iddiccionario;
               
                // tableSeguridadSocialDatos(objusaurio.idusuario);

                document.querySelector("#palabra").value =objpalabra.palabra;
                document.querySelector("#significado_en").value =objpalabra.significado_en;
                document.querySelector("#traduccion_es").value =objpalabra.traduccion_es;
                document.querySelector("#significado_es").value =objpalabra.significado_es;
             

                ///foto avatar
                if (objpalabra.image_exite) {
                    document.querySelector("#image_actual").value =
                    objpalabra.image;
                    document.querySelector("#image_remove").value = 0;

                    if (document.querySelector("#imgregistro")) {
                        document.querySelector("#imgregistro").remove();
                    }

                    document.querySelector(".prevRegistro div").innerHTML =
                        "<img id='imgregistro' src=" + objpalabra.url_image + ">";
                    document
                        .querySelector(".delFotoRegistro")
                        .classList.remove("notBlock");
                } else {
                    document.querySelector(".delFotoRegistro").classList.add("notBlock");
                }

               
                $("#modalDiccionario").modal("show");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    };
}

function removePhotos() {
       // foto conductor
       $("#fotoRegistro").val("");
       $(".delFotoRegistro").addClass("notBlock");
       if (document.querySelector("#imgregistro")) {
           document.querySelector("#imgregistro").remove();
       }
       $("#image_remove").val(1);
}


function fntDelInfo(iddiccionario){

    Swal.fire({
        title: "Eliminar Palabra",
        text: "¿Realmente quiere eliminar la palabra?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/diccionario/delPalanbra';
            let strData = "iddiccionario="+iddiccionario;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Eliminar!", objData.msg, "success");
                       
                        tableDiccionario.api().ajax.reload();
                    }else{
                        Swal.fire("Atención!", objData.msg, "success");
                        
                    }
                }
            }
        } 
      })


 
}