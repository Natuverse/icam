<?php
header("Access-Control-Allow-Origin: *");
class Icam extends Controllers
{
	public function __construct()
    {
        parent::__construct();
		
    }


	public function icambot()
	{
		if($_POST){

			$arrResponse = array('status' => true, 'msg' => 'ok');
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}else{
			$arrResponse = array('status' => false, 'msg' => 'false');
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		//die();
	}

	public function chatbot()
    {
        if (!empty($_POST)) {
            
            if(empty($_POST['user']) || empty($_POST['type']) || empty($_POST['message']) ){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
            }else{
                $user  =  strClean($_POST['user']);
                $type  =  intval($_POST['type']);
                $message  =  strClean($_POST['message']);
                $webCam  =  strClean($_POST['webCam']);
                $private =  intval($_POST['private']);
                $voice = intval($_POST['voice']);

                if(empty($_POST[$_POST['private']])){
                    $private=0;
                }else{
                    $private =  intval($_POST['private']);
                }

                if(empty($_POST[$_POST['voice']])){
                    $voice=0;
                }else{
                    $voice =  intval($_POST['voice']);
                }

                $iduser   = $this->model->consultarUsuario($user, $type, $private, $voice);
                $idwebcam =0;
                if( $type ==2){
                    $idwebcam   = $this->model->consultarUsuario($webCam, $type, $private, $voice);
                }

    

                $requestConversacion = $this->model->InsertConversacional($iduser, $message, $idwebcam);
                if(!empty($requestConversacion)){
                    $arrResponse = array('status' => true, 'msg' => 'ok' ); 
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'false');
                  
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
     
        die();

    }

}

