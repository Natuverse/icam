


function ejecutar() {
    let request = window.XMLHttpRequest ?
        new XMLHttpRequest() :
        new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/analisis/calpalabras";
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
           

               
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        }
    };
}