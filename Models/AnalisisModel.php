<?php 

	class AnalisisModel extends Mysql
	{
		private $srtpalabra;
		private $srtStatus;
        private $intCant;

		public function __construct()
		{
			parent::__construct();
		}

        
        public function getConversaciones(){
            //EXTRAE conductores
            $sql = "SELECT * FROM  conversacion";
            $request = $this->select_all($sql);
            return $request;
        }

        public function consultPalabraActiva(String $palabra){

            $this->srtpalabra  = $palabra;

            $return = 0;
            $sql = "SELECT * FROM palabras WHERE 
                palabra = '{$this->srtpalabra}' and status = 1 ";
            $request = $this->select_all($sql);
            return $request;

        }

        public function consultOracionctiva(String $palabra){

            $this->srtpalabra  = $palabra;

            $return = 0;
            $sql = "SELECT * FROM oracion WHERE 
                oracion = '{$this->srtpalabra}' and status = 1 ";
            $request = $this->select_all($sql);
            return $request;

        }

        public function desactivarpalabras (){
            $this->srtStatus =0;       
            $sql = "UPDATE palabras SET status =? ";
            $arrData = array(
               $this->srtStatus                  
            );

          
            $request_update  = $this->update($sql, $arrData);
            return $request_update;
        }

        public function desactivaroraciones (){
            $this->srtStatus =0;       
            $sql = "UPDATE oracion SET status =? ";
            $arrData = array(
               $this->srtStatus                  
            );

          
            $request_update  = $this->update($sql, $arrData);
            return $request_update;
        }

        public function insetPalabra(String $palabra, Int $cant){

            $this->srtpalabra  = $palabra;
            $this->intCant = $cant;

            $return = 0;
            $sql = "SELECT * FROM palabras WHERE 
                palabra = '{$this->srtpalabra}' and status =1 ";
            $request = $this->select_all($sql);

            $return = 0;
     
            $sql = "SELECT * FROM palabras WHERE palabra = '{$this->srtpalabra}'";
        
            $request = $this->select_all($sql);
            if (empty($request)) {
        
                $query_insert  = "INSERT INTO palabras(palabra, cant)VALUES(?,?)";
                $arrData = array(
                    $this->srtpalabra,
                    $this->intCant
                );
                $request_insert = $this->insert($query_insert, $arrData);
                $return = $request_insert;
            } else {
                $sql = "UPDATE palabras SET  cant =?, status =1 WHERE palabra = '$this->srtpalabra'";
             $arrData = array(
              
                    $this->intCant
             );

           
             $request_update  = $this->update($sql, $arrData);
             $return =    $request_update;
            }
            return $return;

        }
        public function insetOracion(String $palabra, Int $cant){

            $this->srtpalabra  = $palabra;
            $this->intCant = $cant;

            $return = 0;
            $sql = "SELECT * FROM oracion WHERE 
                oracion = '{$this->srtpalabra}' and status =1 ";
            $request = $this->select_all($sql);

            $return = 0;
     
            $sql = "SELECT * FROM oracion WHERE oracion = '{$this->srtpalabra}'";
        
            $request = $this->select_all($sql);
            if (empty($request)) {
        
                $query_insert  = "INSERT INTO oracion(oracion, cant)VALUES(?,?)";
                $arrData = array(
                    $this->srtpalabra,
                    $this->intCant
                );
                $request_insert = $this->insert($query_insert, $arrData);
                $return = $request_insert;
            } else {
                $sql = "UPDATE oracion SET  cant =?, status =1 WHERE oracion = '$this->srtpalabra'";
             $arrData = array(
              
                    $this->intCant
             );

           
             $request_update  = $this->update($sql, $arrData);
             $return =    $request_update;
            }
            return $return;

        }




     

    }