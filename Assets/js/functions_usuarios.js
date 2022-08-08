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
        $("#imgregistro_remove").val(1);
    });
});

var tableUsuarios;
let rowTable = "";

document.addEventListener("DOMContentLoaded", function() {
    tableUsuarios = $("#tableUsuarios").dataTable({
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
            url: " " + base_url + "/usuarios/getUsuarios",
            dataSrc: "",
        },
        columns: [
            { data: "idusuario" },
            { data: "avatar" },
            { data: "nombres" },
            { data: "apellidos" },
            { data: "nombrerol" },
            { data: "bangue" },
            { data: "options" },
        ],
    });

    if (document.querySelector("#rol_form")) {
        let rol_form = document.querySelector("#rol_form");
        rol_form.onchange = function(e) {
            if (document.querySelector("#rol_form").value == 3) {
                $("#zonaUsuario").show();
                fntZona();
            } else {
                $("#zonaUsuario").hide();
            }
        };
    }

    //NUEVO usuario
    let formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = function(e) {
        e.preventDefault();

        let strnombres = document.querySelector("#nombres").value;
        let strapellidos = document.querySelector("#apellidos").value;
        let strtelefono_movil = document.querySelector("#telefono_movil").value;
        let rol_form = document.querySelector("#rol_form").value;
        let correo = document.querySelector("#correo").value;
        let idusuario = document.querySelector("#idusuario").value;

        if (
            strnombres == "" ||
            strapellidos == "" ||
            strtelefono_movil == "" ||
            correo == "" ||
            rol_form == ""
        ) {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        if (idusuario == "") {
            let password = document.querySelector("#password").value;
            let rep_password = document.querySelector("#rep_password").value;
            if (password == "" || rep_password == "") {
                Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
        }

        divLoading.style.display = "flex";
        let request = window.XMLHttpRequest ?
            new XMLHttpRequest() :
            new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/usuarios/setUsuario";
        let formData = new FormData(formUsuario);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    document.querySelector("#titleModal").innerHTML =
                        "Actualizar usuario";
                    document.querySelector("#btnUsuario").innerHTML =
                        "Actualizar usaurio";
                    document
                        .querySelector("#btnUsuario")
                        .classList.replace("btn-primary", "btn-warning");
                    document.querySelector("#idusuario").value = objData.idusuario;
                    document.querySelector("#idusuario").value = objData.foto;

                    Swal.fire("", objData.msg, "success");

                    tableUsuarios.api().ajax.reload();

                    // $('#modalFormUsuario').modal("hide");
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            }
            divLoading.style.display = "none";
            return false;
        };
    };

    let formPass = document.querySelector("#formPass");
    formPass.onsubmit = function(e) {
        e.preventDefault();

        let password = document.querySelector("#passwordu").value;
        let rep_password = document.querySelector("#rep_passwordu").value;
        if (password == "" || rep_password == "") {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }

        divLoading.style.display = "flex";
        let request = window.XMLHttpRequest ?
            new XMLHttpRequest() :
            new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/usuarios/setPassword";
        let formData = new FormData(formPass);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $("#modalFormPass").modal("hide");
                    Swal.fire("", objData.msg, "success");
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            }
            divLoading.style.display = "none";
            return false;
        };
    };
});

window.addEventListener(
    "load",
    function() {
        fntRol();
    },
    false
);

function fntRol() {
    let ajaxUrl = base_url + "/roles/getRolesSelect";
    let request = window.XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject("Microsoft.XMLHTTP");
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector("#rol_form").innerHTML = request.responseText;
        }
    };
}

function fntEditInfo(element, idusuario) {
    activeconductor = true;
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector("#btnUsuario").innerHTML = "Actualizar usuario";
    document.querySelector("#titleModal").innerHTML = "Actualizar usuario";

    document
        .querySelector("#btnUsuario")
        .classList.replace("btn-primary", "btn-warning");

    let request = window.XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/usuarios/getUsuario/" + idusuario;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let htmlImage = "";
                let objusaurio = objData.usuario;

                removePhotos();
                //$("#pass").hide();

                let pass = document.getElementById("pass");
                if (document.querySelector(pass.hasChildNodes())) {
                    pass.removeChild(pass.lastElementChild);
                    pass.removeChild(pass.lastElementChild);
                }

                document.querySelector("#formUsuario").reset();
                document.querySelector("#idusuario").value = objusaurio.idusuario;

                // tableSeguridadSocialDatos(objusaurio.idusuario);

                document.querySelector("#nombres").value = objusaurio.nombres;
                document.querySelector("#apellidos").value = objusaurio.apellidos;

                document.querySelector("#telefono_movil").value = objusaurio.celular;

                document.querySelector("#correo").value = objusaurio.email;

                document.querySelector("#rol_form").value = objusaurio.idrol;

                ///foto avatar
                if (objusaurio.avatar_exite) {
                    document.querySelector("#imgregistro_actual").value =
                        objusaurio.avatar;
                    document.querySelector("#imgregistro_remove").value = 0;
                    if (document.querySelector("#imgregistro")) {
                        document.querySelector("#imgregistro").remove();
                    }
                    document.querySelector(".prevRegistro div").innerHTML =
                        "<img id='imgregistro' src=" + objusaurio.url_avatar + ">";
                    document
                        .querySelector(".delFotoRegistro")
                        .classList.remove("notBlock");
                } else {
                    document.querySelector(".delFotoRegistro").classList.add("notBlock");
                }

                var idSetTimeout;
                idSetTimeout = setTimeout(
                    function() {
                        $("#rol_form").change();
                    },
                    500,
                    $(this)
                );

                $("#modalFormUsuario").modal("show");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    };
}

function openModal() {
    rowTable = "";
    activeconductor = true;

    document
        .querySelector("#btnUsuario")
        .classList.replace("btn-warning", "btn-primary");
    document.querySelector("#btnUsuario").innerHTML = "Crear usuario";
    document.querySelector("#titleModal").innerHTML = "Nuevo usuario";
    document.querySelector("#formUsuario").reset();
    document.querySelector("#pass").innerHTML =
        '<div class="col-md-6"><label class="form-label" for="password">PASSWORD:<span class="required">*</span> </label><input type="password" name="password" id="password" class="form-control " placeholder="Password" required></div><div class="col-md-6"><label class="form-label" for="rep_password">REPETIR PASSWORD:<span class="required">*</span></label><input type="password" name="rep_password" id="rep_password" class="form-control " placeholder="Repetir password"></div>';
    removePhotos();

    $("#modalFormUsuario").modal("show");
}

function fntEditPass(element, idusuario) {
    document.querySelector("#formPass").reset();
    $("#modalFormPass").modal("show");
}

function cerrarModal() {
    tableUsuarios.api().ajax.reload();
    $("#modalFormUsuario").modal("hide");
}

function removePhotos() {
    $("#fotoRegistro").val("");
    $(".delFotoRegistro").addClass("notBlock");
    if (document.querySelector("#imgregistro")) {
        document.querySelector("#imgregistro").remove();
    }
    $("#imgregistro_remove").val(1);
}

function fntEditInfoDetalle(idusuario) {
    let request = window.XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/usuarios/getUsuario/" + idusuario;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let htmlImage = "";
                let objusaurio = objData.usuario;

                removePhotos();
                //$("#pass").hide();

                let pass = document.getElementById("pass");
                if (document.querySelector(pass.hasChildNodes())) {
                    pass.removeChild(pass.lastElementChild);
                    pass.removeChild(pass.lastElementChild);
                }

                document.querySelector("#formUsuarioinfo").reset();

                document.querySelector("#nombresinfo").value = objusaurio.nombres;
                document.querySelector("#apellidosinfo").value = objusaurio.apellidos;

                document.querySelector("#telefono_movilinfo").value =
                    objusaurio.celular;

                document.querySelector("#correoinfo").value = objusaurio.email;

                document.querySelector("#rol_forminfo").value = objusaurio.nombrerol;

                ///foto avatar
                if (objusaurio.avatar_exite) {
                    if (document.querySelector("#imgregistroinfo")) {
                        document.querySelector("#imgregistroinfo").remove();
                    }
                    document.querySelector(".prevRegistroinfo div").innerHTML =
                        "<img id='imgregistroinfo' src=" + objusaurio.url_avatar + ">";
                }

                var idSetTimeout;
                idSetTimeout = setTimeout(
                    function() {
                        $("#rol_form").change();
                    },
                    500,
                    $(this)
                );

                $("#modalInfoUsario").modal("show");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    };
}

function cerrarModalInfo() {
    tableUsuarios.api().ajax.reload();
    $("#modalInfoUsario").modal("hide");
}

function fntDelUsuario(idpersona) {
    Swal.fire({
        title: "Eliminar Usuario",
        text: "¿Realmente quiere eliminar el Usuario?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        confirmButtonColor: "#3085d6",
        cancelButtonText: "No, cancelar!",
        cancelButtonColor: "#d33",
        closeOnConfirm: false,
        closeOnCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let request = window.XMLHttpRequest ?
                new XMLHttpRequest() :
                new ActiveXObject("Microsoft.XMLHTTP");
            let ajaxUrl = base_url + "/Usuarios/delUsuario";
            let strData = "idUsuario=" + idpersona;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader(
                "Content-type",
                "application/x-www-form-urlencoded"
            );
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Eliminar!", objData.msg, "success");
                        tableUsuarios.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            };
        }
    });
}

function fntActivateUsuario(idpersona) {
    Swal.fire({
        title: "Activar Usuario",
        text: "¿Realmente quiere activar el Usuario?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, activar!",
        confirmButtonColor: "#3085d6",
        cancelButtonText: "No, cancelar!",
        cancelButtonColor: "#d33",
        closeOnConfirm: false,
        closeOnCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let request = window.XMLHttpRequest ?
                new XMLHttpRequest() :
                new ActiveXObject("Microsoft.XMLHTTP");
            let ajaxUrl = base_url + "/Usuarios/actUsuario";
            let strData = "idUsuario=" + idpersona;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader(
                "Content-type",
                "application/x-www-form-urlencoded"
            );
            request.send(strData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        Swal.fire("Eliminar!", objData.msg, "success");
                        tableUsuarios.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            };
        }
    });
}