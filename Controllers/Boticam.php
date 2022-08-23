<?php
header("Access-Control-Allow-Origin: *");

class Boticam extends Controllers
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
} 





















}

