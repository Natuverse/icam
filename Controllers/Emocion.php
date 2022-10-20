<?php

class Emocion extends Controllers
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
		getPermisos(MEMOCIONES);
		
	}

	public function emocion()
	{
		$data['page_id'] = 2;
		$data['page_tag'] = "Emociones - ICAM";
		$data['page_title'] = "Emociones - ICAM";
		$data['page_name'] = "Emociones";
		$data['page_functions_js'] = "functions_emocion.js";
		$this->views->getView($this, "emocion", $data);
	}

	public function setEmocion(){
		if ($_POST) {
			
			if (
				empty($_POST['emocion']) 
			) {
				$arrResponse = array("status" => false,  "msg" => 'Datos incorrectos.');
			} else {


				$idemocion = intval($_POST['idemocion']);
				$emocion = intval($_POST['emocion']);
				$descripcion = strClean($_POST['descripcion']);
				
				//dep($_FILES['fotoRegistro']);
			
				//emocion
				$image = $_FILES['fotoRegistro'];
				$nombre_image 	= $image['name'];
				$type_foto =  $image['type'];
				$url_temp_image = $image['tmp_name'];
				$imgimage = 'default-image.png';
				$folderimage = 'emocion';
				if ($nombre_image != '') {
					$imgimage = 'img_' . md5(date('d-m-Y H:m:s')) . '.git';
				}

			

				if ($idemocion == 0) {
					//Crear
					$option = 1;
					if ($_SESSION['permisosMod']['w']) {
						$request = $this->model->insertEmocion(						
							$emocion,
							$imgimage,
							$descripcion
						);
					}

					$arr=$arrData = $this->model->getEmocion($request);
				} else {
					if ($_SESSION['permisosMod']['u']) {
                        
						if ($nombre_image == '') {
							if ($_POST['image_actual'] != 'default-image.png' && $_POST['image_remove'] == 0) {
								$imgimage = $_POST['image_actual'];
							}
						}				

						
						$request = $this->model->updateEmocion(
							$idemocion,  
							$emocion,
							$imgimage,
							$descripcion	

						);

						$arr=$arrData = $this->model->getEmocion($idemocion);
						$option = 2;
					}
				}



				if ($request > 0) {
					if ($option == 1) {
						$arrResponse = array('status' => true, 'emocion'=>$arr['emocion'], 'idemocion' => $request, 'image'=>$imgimage, 'msg' => 'Datos guardados correctamente.');
						if ($nombre_image != '') {
							uploadImage($image, $imgimage, $folderimage);
						}
					
				
					} else {
						$arrResponse = array('status' => true, 'emocion'=>$arr['emocion'], 'idemocion' => $idemocion, 'image'=>$imgimage, 'msg' => 'Datos guardados correctamente.');
						if ($nombre_image != '') {
							uploadImage($image, $imgimage, $folderimage);
						}
						if (($nombre_image == '' && $_POST['image_remove'] == 1 && $_POST['image_actual'] != 'default-image.png')
							|| ($nombre_image != '' && $_POST['image_actual'] != 'default-image.png'  )
						) {
							deleteFile($_POST['image_actual'], $folderimage);
						}
				
					}
				}  else {
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
    }

	public function getEmociones(){
        if ($_SESSION['permisosMod']['r']) {
	
            $arrData = $this->model->getEmociones();



            for ($i = 0; $i < count($arrData); $i++) {
              
                $btnEdit = '';
                $btnDelete = '';

            

                if (file_exists("./Assets/images/uploads/emocion/" . $arrData[$i]['emocion_image']) && $arrData[$i]['emocion_image'] != "") {
                    $arrData[$i]['imagen'] = "<img src='" . media() . "/images/uploads/emocion/" . $arrData[$i]['emocion_image'] . "'   class='rounded-circle  rounded' width='50px' height='50px' alt=''>";
                } else {
                    $arrData[$i]['imagen'] = "<img src='" . media() . "/images/uploads/emocion/default-image.png'   class='rounded-circle  rounded' width='50px' height='50px' alt=''>";
                }
        

              
                if ($_SESSION['permisosMod']['u']) {

                    $btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo(this,' . $arrData[$i]['idemocion_image'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
            
                if($_SESSION['permisosMod']['d']){	
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idemocion_image'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

	public function getEmocion($idemocion)
	{

		if ($_SESSION['permisosMod']['r']) {
			$idemocion = intval($idemocion);
			if ($idemocion > 0) {

			   
				$arrData = $this->model->getEmocion($idemocion);
			
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {

					if (file_exists("./Assets/images/uploads/emocion/" . $arrData['emocion_image']) ) {
						$arrData['url_image'] = media() . "/images/uploads/emocion/" . $arrData['emocion_image'];
						$arrData['image_exite'] = true;
					} else {
						$arrData['url_image'] = media() . "/images/uploads/emocion/default-image.png";
						$arrData['image_exite'] = false;
					}

					//dep($arrResponseTenedor);


					$arrResponse = array('status' => true, 'emocion' => $arrData);
				}


				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}else{
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}else{
			$arrResponse = array('status' => false, 'msg' => 'No tienes permiso.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}

		die();
	}

	public function delEmocion(){
        if($_POST){
            if($_SESSION['permisosMod']['d']){
                $idemocion = intval($_POST['idemocion']);
				$arr = $this->model->getEmocion($idemocion);
                $requestDelete = $this->model->deleteEmocion($idemocion);
				$folderimage = 'emocion';
				if($arr['emocion_image']!="default-image.png"){
					deleteFile($arr['emocion_image'], $folderimage);
				}
				
                if($requestDelete)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la emocion');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la emocion.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
        }
        die();
     } 
}