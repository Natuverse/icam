<?php

class Analisis extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		
		session_start();
		session_regenerate_id(true);
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		//getPermisos(MANALISIS);
		
	}

	public function analisis()
	{
		
		$data['page_tag'] = "ANALISIS - ICAM";
		$data['page_title'] = "ANALISIS - ICAM";
		$data['page_name'] = "ANALISIS";
		$data['page_functions_js'] = "functions_analisis.js";
		$this->views->getView($this, "analisis", $data);
      
	}

	public function getdata(){
		if ($_SESSION['permisosMod']['r']) {
	
            $arrData = $this->model->getdatahoras();

			$arrDataMensjaes = $this->model->getdataMensajeshoras();

        
			for ($i = 0; $i < count($arrData); $i++) {
				$dato = false;
				for ($j = 0; $j < count($arrDataMensjaes); $j++) {
					
					if($arrData[$i]['INI_BOT']==$arrDataMensjaes[$j]['INI_MENS']){
						$dato = true;
						
							$arrData[$i]['COUNT_MENS']=$arrDataMensjaes[$j]['COUNT_MENS'];
							$arrData[$i]['INI_MENS']=$arrDataMensjaes[$j]['INI_MENS'];
					
					}
				}
				if(!$dato){
					$arrData[$i]['COUNT_MENS'] = 0;
				}
				$arrData[$i]['INI_BOT'] =strCleanlive( $arrData[$i]['INI_BOT']);
			}
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
	}

  


}