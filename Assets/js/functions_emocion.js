$(document).ready(function() {

    $("#fotoRegistro").on("change", function() {
        var uploadFoto = document.getElementById("fotoRegistro").value;
        var foto = document.getElementById("fotoRegistro").files;
        console.log(foto);
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById("form_alertfoto");
        if (uploadFoto != "") {
            var type = foto[0].type;
            var name = foto[0].name;
            
            if (type != "image/jpeg" && type != "image/jpg" && type != "image/png" && type != "image/gif") {
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
                    "<img id='imgregistro' name='imgregistro' src=" + objeto_url + ">";
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

var tableEmocion;
let rowTable = "";

document.addEventListener("DOMContentLoaded", function() {

    tableEmocion = $("#tableEmocion").dataTable({
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
            url: " " + base_url + "/emocion/getEmociones",
            dataSrc: "",
        },
        columns: [
            { data: "idemocion_image" },
            { data: "imagen" },
            { data: "emocion" },
            { data: "descripcion" },
            { data: "options" },
        ],
    });

    
      //NUEVA EMOCION
      let formEmocion = document.querySelector("#formEmocion");
      formEmocion.onsubmit = function(e) {
          e.preventDefault();
        
  
          divLoading.style.display = "flex";
          let request = window.XMLHttpRequest ?
              new XMLHttpRequest() :
              new ActiveXObject("Microsoft.XMLHTTP");
          let ajaxUrl = base_url + "/emocion/setEmocion";
          let formData = new FormData(formEmocion);
          request.open("POST", ajaxUrl, true);
          request.send(formData);
          request.onreadystatechange = function() {
              if (request.readyState == 4 && request.status == 200) {
                  let objData = JSON.parse(request.responseText);
                  if (objData.status) {
                      document.querySelector("#titleModal").innerHTML =
                          "Actualizar emocion";
                      document.querySelector("#btnEmocion").innerHTML =
                          "Actualizar emocion";
                      document
                          .querySelector("#btnEmocion")
                          .classList.replace("btn-primary", "btn-warning");

                      document.querySelector("#idemocion").value = objData.iddiccionario;

                      document.querySelector("#image_actual").value = objData.image;
                      document.querySelector("#image_remove").value =0;


                      if(rowTable == ""){
                        tableEmocion.api().ajax.reload();
                    }else{
                        
                        $url ="<img src='"+base_url+"/Assets/images/uploads/emocion/"+ objData.image +"' class='rounded-circle  rounded' width='50px' height='50px' alt=''>";
                        
                        
                        rowTable.cells[0].textContent = objData.idemocion_image;
                        rowTable.cells[1].innerHTML =  $url;
                        rowTable.cells[2].textContent = objData.emocion;
                        rowTable.cells[3].textContent = objData.descripcion;
                        rowTable = ""; 
                    }
  
                      Swal.fire("", objData.msg, "success");
  
                      
                      //$("#modalEmocion").modal("hide");
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

  

    document
    .querySelector("#btnEmocion")
    .classList.replace("btn-warning", "btn-primary");
document.querySelector("#btnEmocion").innerHTML = "Crear Emocion";
document.querySelector("#titleModal").innerHTML = "Nuevo emocion";
document.querySelector("#formEmocion").reset();


document.querySelector("#image_remove").value =0;
document.querySelector("#image_actual").value ="";
document.querySelector("#idemocion").value ="";

removePhotos();

    $("#modalEmocion").modal("show");
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

function cerrarModal() {
    //tableDiccionario.api().ajax.reload();
    document.querySelector("#image_remove").value ="0";
    document.querySelector("#image_actual").value ="";
    document.querySelector("#idemocion").value ="";
    document.querySelector("#formEmocion").reset();
    $("#modalEmocion").modal("hide");
   
}

function fntEditInfo(element, idemocion) {
 
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector("#btnEmocion").innerHTML = "Actualizar emocion";
    document.querySelector("#titleModal").innerHTML = "Actualizar emocion";
    document
        .querySelector("#btnEmocion")
        .classList.replace("btn-primary", "btn-warning");

    let request = window.XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/emocion/getEmocion/" + idemocion;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let htmlImage = "";
                let objemocion = objData.emocion;

                removePhotos();
                document.querySelector("#formEmocion").reset();
             

                document.querySelector("#idemocion").value = objemocion.idemocion_image;
               
             

                document.querySelector("#emocion").value =objemocion.id_emocion;
                document.querySelector("#descripcion").value =objemocion.descripcion;
               
             
                document.querySelector("#image_actual").value =
                objemocion.emocion_image; 
                ///foto avatar
                if (objemocion.image_exite) {
                    
                    document.querySelector("#image_remove").value = 0;

                    if (document.querySelector("#imgregistro")) {
                        document.querySelector("#imgregistro").remove();
                    }

                    document.querySelector(".prevRegistro div").innerHTML =
                        "<img id='imgregistro' src=" + objemocion.url_image + ">";
                    document
                        .querySelector(".delFotoRegistro")
                        .classList.remove("notBlock");
                } else {
                    document.querySelector(".delFotoRegistro").classList.add("notBlock");
                }
                

               
                $("#modalEmocion").modal("show");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    };
}


function fntDelInfo(idemocion){

    Swal.fire({
        title: "Eliminar emocion",
        text: "¿Realmente quiere eliminar esta emocion?",
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
            let ajaxUrl = base_url+'/emocion/delEmocion';
            let strData = "idemocion="+idemocion;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Eliminar!", objData.msg, "success");
                       
                        tableEmocion.api().ajax.reload();
                    }else{
                        Swal.fire("Atención!", objData.msg, "success");
                        
                    }
                }
            }
        } 
      })


 
}

