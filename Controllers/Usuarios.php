<?php 

	class Usuarios extends Controllers{
		public function __construct()
		{
			parent::__construct();
            session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}			
			getPermisos(MUSUARIOS);
            
		}

		public function usuarios()
		{
		//	$data['page_id'] = 2;
			$data['page_tag'] = "Usuarios - Mi mentor pro";
			$data['page_title'] = "Usuarios - Mi mentor pro";
			$data['page_name'] = "usuarios";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function getUsuarios(){
			if ($_SESSION['permisosMod']['r']) {
	
				$arrData = $this->model->getusuarios();
	
	
	
				for ($i = 0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
	
					if ($arrData[$i]['status'] == 1) {
						if ($_SESSION['permisosMod']['d']) {
							$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelUsuario(' . $arrData[$i]['idusuario'] . ')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
								</div>';
						}
					
					}else{
						if ($_SESSION['permisosMod']['d']) {
							$btnDelete = '<button class="btn btn-dark btn-sm " onClick="fntActivateUsuario(' . $arrData[$i]['idusuario'] . ')" title="Activar"><i class="far fa-trash-alt"></i></button>
							</div>';
						}
					}
	
					if (file_exists("./Assets/images/uploads/perfil/" . $arrData[$i]['avatar']) && $arrData[$i]['avatar'] != "") {
						$arrData[$i]['avatar'] = "<img src='" . media() . "/images/uploads/perfil/" . $arrData[$i]['avatar'] . "'   class='rounded-circle  rounded' width='50px' height='50px' alt=''>";
					} else {
						$arrData[$i]['avatar'] = "<img src='" . media() . "/images/uploads/perfil/default.png'   class='rounded-circle  rounded' width='50px' height='50px' alt=''>";
					}

					
	
			
					if ($arrData[$i]['status'] == 1) {
						$arrData[$i]['bangue'] = '<span class="badge bg-success">Activo</span>';
					} else {
						$arrData[$i]['bangue'] = '<span class="badge bg-danger">Inactivo</span>';
					}
	
					if ($_SESSION['permisosMod']['r']) {
	
						$btnView .= '<button class="btn btn-info btn-sm " onClick="fntEditInfoDetalle(' . $arrData[$i]['idusuario'] . ')" title="Ver Detalle"><i class="far fa-eye"></i></button>';
					}
	
					if ($_SESSION['permisosMod']['u']) {
	
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo(this,' . $arrData[$i]['idusuario'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
						<button class="btn btn-warning btn-sm " onClick="fntEditPass(this,' . $arrData[$i]['idusuario'] . ')" title="Password"><i class="fas fa-pencil-alt"></i></button>';
					}
				
					$arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function setUsuario(){
			if ($_POST) {
				
			
			if (
			 empty($_POST['nombres'])
				|| empty($_POST['apellidos']) || empty($_POST['telefono_movil']) || empty($_POST['rol_form'])  || empty($_POST['correo']) 
			) {
				$arrResponse = array("status" => false,  "msg" => 'Datos incorrectos.');
			} else {


				$idusuario = intval($_POST['idusuario']);
			
			
				//avatar
				$fotoRegistro = $_FILES['fotoRegistro'];
				$nombre_fotoRegistro 	= $fotoRegistro['name'];
				$type_foto =  $fotoRegistro['type'];
				$url_temp_fotoRegistro = $fotoRegistro['tmp_name'];
				$imgfotoRegistro = 'fotoRegistro.jpg';
				$folderFotoRegistro = 'perfil';
				if ($nombre_fotoRegistro != '') {
					$imgfotoRegistro = 'img_' . md5(date('d-m-Y H:m:s')) . '.jpg';
				}

				if(empty($_POST['idusuario'])){
					
					
					if($_POST['password'] == $_POST['rep_password']){
						$password = strCleanlive($_POST['password']);
						$pass  =  hash("sha512", $password);
					}else{
						$arrResponse = array("status" => false,  "msg" => 'Password incorrecto.');
						echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
						die();
					}
					
				
				}
				

				
				$nombres = ucwords(strCleanlive($_POST['nombres']));
				$apellidos = ucwords(strCleanlive($_POST['apellidos']));
				
				$celular  = intval(strCleanlive($_POST['telefono_movil']));
				
				$correo = strtolower(strCleanlive($_POST['correo']));
				$rolid = intval($_POST['rol_form']);

		

				
				$registro = 1;
				$request_usuario = "";

				if ($idusuario == 0) {
					//Crear
					$option = 1;
					if ($_SESSION['permisosMod']['w']) {
						$request_usuario = $this->model->insertUsario(
							$imgfotoRegistro,							
							$pass,						
							$nombres,
							$apellidos,					
							$celular,						
							$correo,												
							$rolid
						);
					}
				} else {
					if ($_SESSION['permisosMod']['u']) {
						if ($nombre_fotoRegistro == '') {
							if ($_POST['imgregistro_actual'] != 'fotoRegistro.jpg' && $_POST['imgregistro_remove'] == 0) {
								$imgfotoRegistro = $_POST['imgregistro_actual'];
							}
						}						

						
						$request_usuario = $this->model->updateUsuario(							
							$idusuario,	
							$imgfotoRegistro,					
							$nombres,
							$apellidos,						
							$celular,						
							$correo,												
							$rolid				
						);
						$option = 2;
					}
				}


				if ($request_usuario > 0) {
					if ($option == 1) {
						$arrResponse = array('status' => true,  'idusuario' => $request_usuario, 'msg' => 'Datos guardados correctamente.');
						if ($nombre_fotoRegistro != '') {
							uploadImage($fotoRegistro, $imgfotoRegistro, $folderFotoRegistro);
						}					
				
					} else {
						$arrResponse = array('status' => true, 'idusuario' => $idusuario, 'msg' => 'Datos Actualizados correctamente.');
						if ($nombre_fotoRegistro != '') {
							uploadImage($fotoRegistro, $imgfotoRegistro, $folderFotoRegistro);
						}
						if (($nombre_fotoRegistro == '' && $_POST['imgregistro_remove'] == 1 && $_POST['imgregistro_actual'] != 'fotoRegistro.jpg')
							|| ($nombre_fotoRegistro != '' && $_POST['imgregistro_actual'] != 'fotoRegistro.jpg')
						) {
							deleteFile($_POST['imgregistro_actual'], $folderFotoRegistro);
						}				
				
					}
				} else if ($request_usuario == 'exist') {
					$arrResponse = array('status' => false, 'msg' => '¡Atención! la identificación o el numero de celular ya existe, ingrese otro.');
				} else {
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getUsuario($idusuario)
		{

			if ($_SESSION['permisosMod']['r']) {
				$idusuario = intval($idusuario);
				if ($idusuario > 0) {
	
					$arrData = $this->model->getUsuario($idusuario);
				
					if (empty($arrData)) {
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					} else {
	
						if (file_exists("./Assets/images/uploads/perfil/" . $arrData['avatar']) && $arrData['avatar'] != "") {
							$arrData['url_avatar'] = media() . "/images/uploads/perfil/" . $arrData['avatar'];
							$arrData['avatar_exite'] = true;
						} else {
							$arrData['url_avatar'] = media() . "/images/uploads/perfil/default.png";
							$arrData['avatar_exite'] = false;
						}
	
	
						$arrResponse = array('status' => true, 'usuario' => $arrData);
					}
	
	
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
	
			die();
		}

		public function setPassword(){
			if ($_POST) {
				
			
			if ( empty($_POST['passwordu']) || empty($_POST['rep_passwordu'])
			) {
				$arrResponse = array("status" => false,  "msg" => 'Datos incorrectos faltan.');
			} else {


				$idusuario = intval($_POST['iduserpass']);
			
			
				if($_POST['passwordu'] == $_POST['rep_passwordu']){
					$password = strCleanlive($_POST['passwordu']);
					$pass  =  hash("sha512", $password);
				}else{
					$arrResponse = array("status" => false,  "msg" => 'Password incorrecto.');
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
					die();
				}			

				if ($_SESSION['permisosMod']['u']) {
						
					$request_usuario = $this->model->setPassword($idusuario, $pass);
						
				}
				


				if ($request_usuario > 0) {
				
						$arrResponse = array('status' => true, 'idusuario' => $idusuario, 'msg' => 'Password actualizado.');									
				
					
				}  else {
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delUsuario()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteUsuario($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function actUsuario()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->model->actUsuario($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha activado el usuario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al activar el usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		

    }