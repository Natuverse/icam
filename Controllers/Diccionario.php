<?php

class Diccionario extends Controllers
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
		getPermisos(MDICCIONARIO);
		
	}

	public function diccionario()
	{
		
		$data['page_tag'] = "Diccionario - ICAM";
		$data['page_title'] = "Diccionario - ICAM";
		$data['page_name'] = "diccionario";
		$data['page_functions_js'] = "functions_diccionario.js";
		$this->views->getView($this, "diccionario", $data);
      
	}

    public function getDiccionario(){
        if ($_SESSION['permisosMod']['r']) {
	
            $arrData = $this->model->getDiccionario();



            for ($i = 0; $i < count($arrData); $i++) {
              
                $btnEdit = '';
                $btnDelete = '';

            

                if (file_exists("./Assets/images/uploads/diccionario/" . $arrData[$i]['image']) && $arrData[$i]['image'] != "") {
                    $arrData[$i]['imagen'] = "<img src='" . media() . "/images/uploads/diccionario/" . $arrData[$i]['image'] . "'   class='rounded-circle  rounded' width='50px' height='50px' alt=''>";
                } else {
                    $arrData[$i]['imagen'] = "<img src='" . media() . "/images/uploads/diccionario/default-image.png'   class='rounded-circle  rounded' width='50px' height='50px' alt=''>";
                }
        

              
                if ($_SESSION['permisosMod']['u']) {

                    $btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo(this,' . $arrData[$i]['iddiccionario'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                }
            
                if($_SESSION['permisosMod']['d']){	
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['iddiccionario'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setPalabra(){
       
        if ($_POST) {
			
			if (
				empty($_POST['palabra']) 
			) {
				$arrResponse = array("status" => false,  "msg" => 'Datos incorrectos.');
			} else {


				$iddiccionario = intval($_POST['iddiccionario']);
				$palabra = strClean($_POST['palabra']);		
				$significado_en = strClean($_POST['significado_en']);		
				$traduccion_es = strClean($_POST['traduccion_es']);		
				$significado_es = strClean($_POST['significado_es']);		
			
				//avatar
				$image = $_FILES['fotoRegistro'];
				$nombre_image 	= $image['name'];
				$type_foto =  $image['type'];
				$url_temp_image = $image['tmp_name'];
				$imgimage = 'default-image.png';
				$folderimage = 'diccionario';
				if ($nombre_image != '') {
					$imgimage = 'img_' . md5(date('d-m-Y H:m:s')) . '.jpg';
				}

				if ($iddiccionario == 0) {
					//Crear
					$option = 1;
					if ($_SESSION['permisosMod']['w']) {
						$request = $this->model->insertPalabra(						
							$palabra,
							$significado_en,
							$traduccion_es,
							$significado_es,
							$imgimage
						);
					}
				} else {
					if ($_SESSION['permisosMod']['u']) {
                        
						if ($nombre_image == '') {
							if ($_POST['image_actual'] != 'default-image.png' && $_POST['image_remove'] == 0) {
								$imgimage = $_POST['image_actual'];
							}
						}				

						
						$request = $this->model->updatePalabra(
							$iddiccionario,  
							$palabra,
							$significado_en,
							$traduccion_es,
							$significado_es,
							$imgimage				
						);
						$option = 2;
					}
				}


				if ($request > 0) {
					if ($option == 1) {
						$arrResponse = array('status' => true, 'palabra'=>$palabra, 'significado_en'=>$significado_en, 'traduccion_es'=>$traduccion_es, 'significado_es'=> $significado_es,'iddiccionario' => $request, 'image'=>$imgimage, 'msg' => 'Datos guardados correctamente.');
						if ($nombre_image != '') {
							uploadImage($image, $imgimage, $folderimage);
						}
					
				
					} else {
						$arrResponse = array('status' => true,'palabra'=>$palabra, 'significado_en'=>$significado_en, 'traduccion_es'=>$traduccion_es, 'significado_es'=> $significado_es, 'iddiccionario' => $iddiccionario, 'image'=>$imgimage, 'msg' => 'Datos Actualizados correctamente.');
						if ($nombre_image != '') {
							uploadImage($image, $imgimage, $folderimage);
						}
						if (($nombre_image == '' && $_POST['image_remove'] == 1 && $_POST['image_actual'] != 'default-image.png')
							|| ($nombre_image != '' && $_POST['image_actual'] != 'default-image.png')
						) {
							deleteFile($_POST['image_actual'], $folderimage);
						}
				
					}
				} else if ($request == 'exist') {
					$arrResponse = array('status' => false, 'msg' => '¡Atención! la palabra ya existe, ingrese otro.');
				} else {
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
    }

    public function getPalabra($iddiccionario)
		{

			if ($_SESSION['permisosMod']['r']) {
				$iddiccionario = intval($iddiccionario);
				if ($iddiccionario > 0) {
	
                   
					$arrData = $this->model->getPalabra($iddiccionario);
				
					if (empty($arrData)) {
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					} else {
	
						if (file_exists("./Assets/images/uploads/diccionario/" . $arrData['image']) && $arrData['image'] != "") {
							$arrData['url_image'] = media() . "/images/uploads/diccionario/" . $arrData['image'];
							$arrData['image_exite'] = true;
						} else {
							$arrData['url_image'] = media() . "/images/uploads/diccionario/default-image.png";
							$arrData['image_exite'] = false;
						}
	
						//dep($arrResponseTenedor);
	
	
						$arrResponse = array('status' => true, 'palabra' => $arrData);
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


     public function delPalanbra(){
        if($_POST){
            if($_SESSION['permisosMod']['d']){
                $iddiccionario = intval($_POST['iddiccionario']);
                $requestDelete = $this->model->deletePalabra($iddiccionario);
                if($requestDelete)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la palabra');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la palabra.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
        }
        die();
     } 
}