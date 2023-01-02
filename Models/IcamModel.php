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
		private $intCant;
		private $intIDemocion;
		//private $inttypechat;
		private $srtquestion;
		private $srtanswer;
		private $srtanswerbot1;
		private $srtanswerbot2;
		private $srteditanswer;
		private $intbot1;
		private $intbot2;
		


		private $intqualification;

        
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

		public function feelback(String $question,String $answer,Int $qualification){
			
			$this->srtquestion= $question;
			$this->srtanswer = $answer;
			$this->intqualification = $qualification;

	
			
		    $query_insert  = "INSERT INTO feelback(question, answer, qualification)
				VALUES(?,?,?)";
				$arrData = array(
					$this->srtquestion,
					$this->srtanswer,
                    $this->intqualification
					
				);
			
				$request_insert = $this->insert($query_insert, $arrData);
				$return = $request_insert;
			
			return $return;
			
		}
      
		public function feelbackFine(String $question,String $answer_bot1,String $answer_bot2, String $edit_answer, Int $bot1, Int $bot2){
			
			$this->srtquestion= $question;
			$this->srtanswerbot1 = $answer_bot1;
			$this->srtanswerbot2 = $answer_bot2;
			$this->srteditanswer = $edit_answer;
			$this->intbot1 = $bot1;
			$this->intbot2 = $bot2;

			
		    $query_insert  = "INSERT INTO feelback_fine(question, answer_bot1, answer_bot2, edit_answer,  bot1, bot2)
				VALUES(?,?,?,?,?,?)";
				$arrData = array(
					$this->srtquestion,
					$this->srtanswerbot1,
					$this->srtanswerbot2,
                    $this->srteditanswer,
                    $this->intbot1,
                    $this->intbot2

					
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

		public function consullog( ){			

			
			$sql = "SELECT pregunta, max(respuesta) as respuesta, count(pregunta) as cant FROM log where pregunta != '' and pregunta != ' ' and pregunta != '  ' and pregunta != '   ' and pregunta != '   ' group by pregunta";
			
			
				$request = $this->select_all($sql);
				
			return $request;
			
		}

		public function deteletefine (){
			$sql = " delete from fine";
			$request = $this->delete($sql);
			return $request;
		} 

		public function insetQuestion(String $mensaje, String $respuesta, Int $cant){

			$this->sttMensaje = $mensaje;
			$this->strrespuesta=  $respuesta;
			$this->intCant = $cant;
			$query_insert  = "INSERT INTO fine(pregunta, respuesta, cant)
			VALUES(?,?,?)";
			$arrData = array(
				$this->sttMensaje,
				$this->strrespuesta,
				$this->intCant
				
			);
		
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		
		return $return;
		}


		public function consultarEmociones(int $id_emocion){
			$this->intId_emocion = $id_emocion;

			$sql = "SELECT * FROM emocion_image as ei
			left join emocion as e on ei.id_emocion = e.idemocion 
			WHERE ei.id_emocion = $this->intId_emocion ";
			
			
				$request = $this->select_all($sql);
				
			return $request;
		}

		public function inserlog( int $iduser, int $type, Int $cliente, String $pregunta,  String $respuesta, int $idemocion, int $typechat){
			

			$this->idWebcam = $iduser;
			$this->intIdUser=$cliente;
            $this->intType = $type;
			$this->sttMensaje= $pregunta;
			$this->strrespuesta=  $respuesta;
			$this->intIDemocion = $idemocion;
			$this-> inttypechat =  $typechat;
		
		    $query_insert  = "INSERT INTO log(model, tipo, user, pregunta, respuesta, idemocion, typechat)
				VALUES(?,?,?, ?,?,?, ?)";
				$arrData = array(
					$this->idWebcam,
					$this->intType,
                    $this->intIdUser,
					$this->sttMensaje,
					$this->strrespuesta,
					$this->intIDemocion,
					$this-> inttypechat
					
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

		public function modelosdic(){
			$sql = "SELECT user FROM `log` WHERE tipo = 2";
			
			
				$request = $this->select_all($sql);
				
			return $request;
		}

		public function udptemodel(int $idmodelo){


			$this->idWebcam = $idmodelo;
			$this->intType = 2;
			$sql = "UPDATE usuariobot SET tipo = ? WHERE idusuariobot = $this->idWebcam";
			$arrData = array(
				$this->intType 
			);
			$request_update  = $this->update($sql, $arrData);
			return $request_update;
		}
        
        


    }
