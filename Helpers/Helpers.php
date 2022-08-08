<?php

//Retorla la url del proyecto
function base_url()
{
    return BASE_URL;
}
//Retorla la url de Assets
function media()
{
    return BASE_URL . "/Assets";
}
function headerAdmin($data = "")
{
    $view_header = "Views/Template/header_admin.php";
    require_once($view_header);
}
function footerAdmin($data = "")
{
    $view_footer = "Views/Template/footer_admin.php";
    require_once($view_footer);
}
function headerTienda($data = "")
{
    $view_header = "Views/Template/header_tienda.php";
    require_once($view_header);
}
function footerTienda($data = "")
{
    $view_footer = "Views/Template/footer_tienda.php";
    require_once($view_footer);
}
//Muestra información formateada
function dep($data)
{
    $format  = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}
function getModal(string $nameModal, $data)
{
    $view_modal = "Views/Template/Modals/{$nameModal}.php";
    require_once $view_modal;
}
//Envio de correos
function sendEmail($data, $template)
{
    $asunto = $data['asunto'];
    $emailDestino = $data['email'];
    $empresa = NOMBRE_REMITENTE;
    $remitente = EMAIL_REMITENTE;
    //ENVIO DE CORREO
    $de = "MIME-Version: 1.0\r\n";
    $de .= "Content-type: text/html; charset=UTF-8\r\n";
    $de .= "From: {$empresa} <{$remitente}>\r\n";
    ob_start();
    require_once("Views/Template/Email/" . $template . ".php");
    $mensaje = ob_get_clean();
    $send = mail($emailDestino, $asunto, $mensaje, $de);
    return $send;
}

function getPermisos(int $idmodulo)
{

    require_once("Models/PermisosModel.php");

    $objPermisos = new PermisosModel();
    $idrol = $_SESSION['userData']['rolid'];
    $arrPermisos = $objPermisos->permisosModulo($idrol);

    $permisos = '';
    $permisosMod = '';
    if (count($arrPermisos) > 0) {
        $permisos = $arrPermisos;
        $permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
    }
    $_SESSION['permisos'] = $permisos;
    $_SESSION['permisosMod'] = $permisosMod;
}



function sessionUser(int $idpersona)
{
    require_once("Models/LoginModel.php");
    $objLogin = new LoginModel();
    $request = $objLogin->sessionLogin($idpersona);
    return $request;
}

function uploadImage(array $data, string $name, string $folder)
{
    $url_temp = $data['tmp_name'];
    $destino    = 'Assets/images/uploads/' . $folder . '/' . $name;
    $move = move_uploaded_file($url_temp, $destino);
    return $move;
}

function uploadImagebase64(String $data, string $name, string $folder)
{
    //$url_temp = $data['tmp_name'];
    $fp = fopen( 'Assets/images/uploads/' . $folder . '/' . $name, "w+");
    //$destino    = 'Assets/images/uploads/' . $folder . '/' . $name;

    fwrite($fp, base64_decode($data));
    fclose($fp);
    //$move = move_uploaded_file($url_temp, $destino);
    return $move;
}

function deleteFile(string $name, string $folder)
{
    if (file_exists("Assets/images/uploads/" . $folder . '/' . $name)) {
        unlink('Assets/images/uploads/' . $folder . '/' . $name);
    }
}

//Elimina exceso de espacios entre palabras
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}

//Genera una contraseña de 10 caracteres
function passGenerator($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);

    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}
//Genera un token
function token()
{
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}
//Formato para valores monetarios
function formatMoney($cantidad)
{
    $cantidad = number_format($cantidad, 2, SPD, SPM);
    return $cantidad;
}

function dateFormat($date)
{
    $date = str_replace('/', '-', $date);
    return  $date = date("Y-m-d", strtotime($date));
}

function dateFormatBD($date)
{
    $date = date("d-m-Y", strtotime($date));
    $date = str_replace('-', '/', $date);
    return  $date = str_replace('-', '/', $date);
}

function getFile(string $url, $data)
{
    ob_start();
    require_once("Views/{$url}.php");
    $file = ob_get_clean();
    return $file;        
}

function getMon (int $mont){
    switch ($mont) {
        case 1:
            $mes = "enero";
            break;
        case 2:
            $mes = "febrero";
            break;
        case 3:
            $mes = "marzo";
            break;
        case 4:
            $mes = "abril";
            break;
        case 5:
            $mes = "mayo";
            break;
        case 6:
            $mes = "junio";
            break;
        case 7:
            $mes = "julio";
            break;
        case 8:
            $mes = "agosto";
            break;
        case 9:
            $mes = "septiembre";
            break;
        case 10:
            $mes = "octubre";
            break;
        case 11:
            $mes = "noviembre";
            break;
        case 12:
            $mes = "diciembre";
            break;
    
        
            
    }

    return  $mes;

    
}