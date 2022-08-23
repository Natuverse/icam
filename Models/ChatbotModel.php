<?php 

	class ChatbotModel extends Mysql
	{
        private $intIdUser;
		private $strUser;
        private $intType;
        private $sttMensaje;
        private $idWebcam;

        
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
                $return = $sql['idusuariobot'];
            }
            return $return;
            
        }

        public function InsertConversacional( int $iduser, String $message, int $webCam){
            

            $this->intIdUser = $iduser;
            $this->sttMensaje=$message;
            $this->idWebcam = $webCam;

        
            
            $query_insert  = "INSERT INTO conversacion(idusuario, conversacion, idmodelo)
                VALUES(?,?,?)";
                $arrData = array(
                    $this->intIdUser,
                    $this->sttMensaje,
                    $this->idWebcam
                    
                );
            
                $request_insert = $this->insert($query_insert, $arrData);
                $return = $request_insert;
            
            return $return;
            
        }


        
        


    }