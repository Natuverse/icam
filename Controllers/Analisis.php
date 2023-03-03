<?php


class Analisis extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		
		session_start();
		//session_regenerate_id(true);
		/*
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		*/
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

	public function modelos()
	{
		
		$data['page_tag'] = "ANALISIS - ICAM";
		$data['page_title'] = "ANALISIS - ICAM";
		$data['page_name'] = "ANALISIS";
		$data['page_functions_js'] = "functions_analisis.js";
		$this->views->getView($this, "modelos", $data);
      
	}

	public function modelo($model)
	{
		
		$data['page_tag'] = "ANALISIS - ICAM";
		$data['page_title'] = "ANALISIS - ICAM";
		$data['page_name'] = "ANALISIS";
		$data['page_functions_js'] = "functions_analisis.js";
		$data['modelo']=$model;
		$this->views->getView($this, "modelo", $data);
      
	}



	public function getdata(){
	
	
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
       
        die();
	}

	public function getdataModelo($modelo){
	
	
		$arrData = $this->model->getdatahorasModelo($modelo);

		$arrDataMensjaes = $this->model->getdataMensajeshorasModelo($modelo);

	
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
   
	die();
}

	public function getdatamin(){
		
	
            $arrData = $this->model->getdatamin();

			$arrDataMensjaes = $this->model->getdataMensajesmin();

        
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
       
        die();
	}

	public function getdataminmodelo($modelo){
		
	
		$arrDataN['mensajes'] = $this->model->getdataminmodelo($modelo);

		$arrDataMensjaes['icam'] = $this->model->getdataMensajesminmodelo($modelo);

	
		for ($i = 0; $i < count($arrData); $i++) {
			$dato = false;
			for ($j = 0; $j < count($arrDataMensjaes); $j++) {
				
				if(strCleanlive( $arrData[$i]['INI_BOT'])==strCleanlive( $arrDataMensjaes[$j]['INI_MENS'])){
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
   
	die();
}


	

	public function getdatDefault(){
	
	
            $arrData['general'] = $this->model->getdataMensajesSinBandeja();

			$arrData['bandeja'] = $this->model->getdataMensajesBandeja();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    
        die();
	}

	public function getmodel(){
		$arrData = $this->model->getmodel();

		for ($i = 0; $i < count($arrData); $i++) {
		$btnView = '';
		$btnEdit = '';
		$btnDelete = '';

		   

		$btnView .= '<a class="nav-link" href="'.base_url().'/analisis/modelo/'. $arrData[$i]['model'].'"><i class="far fa-eye"></i></a>';

		$arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
		}
		
		

		
		echo json_encode($arrData, JSON_UNESCAPED_UNICODE);

	die();
	}
  


}