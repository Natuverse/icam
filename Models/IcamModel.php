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
		private $intId_emocion;
		private $strrespuesta;
		private $intIDemocion;

        
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
				$query_insert  = "INSERT INTO usuariobot (nombre, tipo)
				VALUES(?,?)";
				$arrData = array(
					$this->strUser,
					$this->intTyp
					
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

		public function consultarEmociones(int $id_emocion){
			$this->intId_emocion = $id_emocion;

			$sql = "SELECT * FROM emocion_image as ei
			left join emocion as e on ei.id_emocion = e.idemocion 
			WHERE ei.id_emocion = $this->intId_emocion ";
			
			
				$request = $this->select_all($sql);
				
			return $request;
		}

		public function inserlog( int $iduser, int $type, Int $cliente, String $pregunta,  String $respuesta, int $idemocion){
			

			$this->idWebcam = $iduser;
			$this->intIdUser=$cliente;
            $this->intType = $type;
			$this->sttMensaje= $pregunta;
			$this->strrespuesta=  $respuesta;
			$this->intIDemocion = $idemocion;

			
		    $query_insert  = "INSERT INTO log(model, tipo, user, pregunta, respuesta, idemocion)
				VALUES(?,?,?, ?,?,?)";
				$arrData = array(
					$this->idWebcam,
					$this->intType,
                    $this->intIdUser,
					$this->sttMensaje,
					$this->strrespuesta,
					$this->intIDemocion 
					
				);
			
				$request_insert = $this->insert($query_insert, $arrData);
				$return = $request_insert;
			
			return $return;
			
		}

		public function consulAbre(String $word){			

			$this->srtword = $word;
			$sql = "SELECT * FROM abreviacion  
			WHERE abreviacion = '$this->srtword' ";
			
			
				$request = $this->select_all($sql);
				
			return $request;
		}

        
        


    }