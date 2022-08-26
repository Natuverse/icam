<?php 

	class IcamModel extends Mysql
	{
        private $intIdUser;
		private $strUser;
        private $intType;
        private $sttMensaje;
        private $idWebcam;
		private $intprivate;
		private $intvoice;
		private $srtword;

        
		public function __construct()
		{
			parent::__construct();
		}	


        public function consultarUsuario( String $user, int $type){
			

			$this->strUser = $user;
			$this->intType=$type;
			
			$return = 0;

			$sql = "SELECT * FROM usuariobot  
			WHERE nombre = '$this->strUser' ";
			$request = $this->select_all($sql);
			if (empty($request)) {
				$query_insert  = "INSERT INTO usuariobot(nombre, tipo)
				VALUES(?,?)";
				$arrData = array(
					$this->strUser,
					$this->intType
					
				);
			
				$request_insert = $this->insert($query_insert, $arrData);
				$return = $request_insert;
			} else {
				$return = $request[0]['idusuariobot'];
			}
			return $return;
			
		}

        public function InsertConversacional( int $iduser, String $message, int $webCam, Int $private, Int $voice){
			

			$this->intIdUser = $iduser;
			$this->sttMensaje=$message;
            $this->idWebcam = $webCam;
			$this->intprivate= $private;
			$this->intvoice = $voice;
		
		
			
		    $query_insert  = "INSERT INTO conversacion(idusuario, conversacion, idmodelo, privado, voz)
				VALUES(?,?,?,?,?)";
				$arrData = array(
					$this->intIdUser,
					$this->sttMensaje,
                    $this->idWebcam,
					$this->intprivate,
					$this->intvoice
					
				);
			
				$request_insert = $this->insert($query_insert, $arrData);
				$return = $request_insert;
			
			return $return;
			
		}

		public function consultDiccionario( String $word){			

			$this->srtword = $word;
			$sql = "SELECT * FROM diccionario  
			WHERE palabra = '$this->srtword' ";
			
			
				$request = $this->select_all($sql);
				
			return $request;
			
		}

        
        


    }