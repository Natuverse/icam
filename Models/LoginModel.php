<?php 

	class LoginModel extends Mysql
	{
		private $intIdUsuario;
		private $strDocumento;
		private $strEmail;
		private $strPassword;
		private $strToken;

		public function __construct()
		{
			parent::__construct();
		}	

		public function loginUser(string $email, string $password)
		{

			$this->strEmail = $email;
			$this->strPassword = $password;
			
			$sql = "SELECT idusuario, status FROM usuario WHERE 
					correo = '$this->strEmail' and 
					pass = '$this->strPassword' and 
					status != 0 ";	
							
			$request = $this->select($sql);
			
			return $request;
		}

		public function sessionLogin(int $iduser){
			$this->intIdUsuario = $iduser;
			//BUSCAR ROLE 
			$sql = "SELECT p.idusuario,							
							p.nombres,
							p.apellidos,						
                            p.celular,
							p.correo,
							p.rolid,r.nombrerol,
							p.status 
					FROM usuario p
					left JOIN rol r
					ON p.rolid = r.idrol
					WHERE p.idusuario = $this->intIdUsuario";
			$request = $this->select($sql);
			$_SESSION['userData'] = $request;
			return $request;
		}

		public function getUserEmail(string $strEmail){
			$this->strEmail = $strEmail;
			$sql = "SELECT idusuario,nombres,apellidos,status FROM usuario WHERE 
					correo = '$this->strEmail' and  
					status = 1 ";
			$request = $this->select($sql);
			return $request;
		}

		public function setTokenUser(int $idpersona, string $token){
			$this->intIdUsuario = $idpersona;
			$this->strToken = $token;
			$sql = "UPDATE usuario SET token = ? WHERE idusuario = $this->intIdUsuario ";
			$arrData = array($this->strToken);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function getUsuario(string $email, string $token){
			$this->strEmail = $email;
			$this->strToken = $token;
			$sql = "SELECT idusuario FROM usuario WHERE 
					correo = '$this->strEmail' and 
					token = '$this->strToken' and 					
					status = 1 ";
			$request = $this->select($sql);
			return $request;
		}

		public function insertPassword(int $idPersona, string $password){
			$this->intIdUsuario = $idPersona;
			$this->strPassword = $password;
			$sql = "UPDATE usuario SET password = ?, token = ? WHERE idusuario = $this->intIdUsuario ";
			$arrData = array($this->strPassword,"");
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
 ?>