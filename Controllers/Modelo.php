<?php


class Modelo extends Controllers
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
		
		getPermisos(MANALISIS);
		
	}

	public function Modelo()
	{		
		$data['page_tag'] = "Modelo - ICAM";
		$data['page_title'] = "Modelo - ICAM";
		$data['page_name'] = "Modelo";
		$data['page_functions_js'] = "functions_modelo.js";
		$this->views->getView($this, "modelo", $data);
      
	}

	public function getmodelall()
	{		
		$arrData = $this->model->getmodelall();
		for ($i = 0; $i < count($arrData); $i++) {

			$arr = $this->model->consulcon($arrData[$i]['idusuariobot']);
			if(count($arr) > 0 ){
				//dep($arrData[$i]);
				//dep($arr);
				$arrupdate = $this->model->uptateini($arrData[$i]['idusuariobot'], $arr[0]['tiempo']);
			}else{
				$arr2 = $this->model->consulconlog($arrData[$i]['idusuariobot']);
				if(count($arr2) > 0 ){
				dep($arrData[$i]);
				//dep($arr2);
				$arrupdate = $this->model->uptateini($arrData[$i]['idusuariobot'], $arr2[0]['tiempo']);
				}else{
					dep($arrData[$i]);
				}
				
			}
		
		}
		
		
	}

	

	public function getmodel(){
		$arrData = $this->model->getmodel();

		for ($i = 0; $i < count($arrData); $i++) {
		$btnView = '';
		$btnEdit = '';
		$btnDelete = '';

		$arrData[$i]['edad'] = cleanFecha($arrData[$i]['edad']);
		$arrData[$i]['fecha_inicio'] = cleanFecha($arrData[$i]['fecha_inicio']);
		
		$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo(this,' . $arrData[$i]['model'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';

		

		$arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
		}
		
		

		
		echo json_encode($arrData, JSON_UNESCAPED_UNICODE);

	die();
	}

	public function getModelo($idmodelo)
	{

		
			$idmodelo = intval($idmodelo);
			if ($idmodelo > 0) {

				$arrData = $this->model->getModelo($idmodelo);

				$arrData['edad'] = cleanFecha($arrData['edad']);
				$arrData['fecha_inicio'] = cleanFecha($arrData['fecha_inicio']);
				$arrData['fecha_creacion'] = cleanFecha($arrData['fecha_creacion']);
			
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {



					$arrResponse = array('status' => true, 'modelo' => $arrData);
				}


				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}


		die();
	}


	public function setModelo(){
		if ($_POST) {		
		
		if (
		 empty($_POST['idemodelo'])	|| empty($_POST['nacimiento']) || empty($_POST['antiguedad']) || empty($_POST['ingles'])  
		) {
			$arrResponse = array("status" => false,  "msg" => 'Datos incorrectos.');
		} else {
			$idemodelo = intval($_POST['idemodelo']);
			$ingles = intval($_POST['ingles']);
			
			$nacimiento = strCleanlive($_POST['nacimiento']);
			$antiguedad = strCleanlive($_POST['antiguedad']);

			$request_usuario = "";	
						
					$request_usuario = $this->model->updateModelo(							
						$idemodelo,	
						$nacimiento,					
						$antiguedad,
						$ingles		
					);
				
			


			if ($request_usuario > 0) {
				
					$arrResponse = array('status' => true,  'idusuario' => $request_usuario, 'msg' => 'Datos guardados correctamente.');
									
			
			
			}  else {
				$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
			}
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

}