<?php 

	class DiccionarioModel extends Mysql
	{
		private $srtpalabra;
		private $srtsignificado_en;
		private $srttraduccion_es;
		private $srtsignificado_es;
		private $srtimage;
		private $intiddiccionario;
		

		public function __construct()
		{
			parent::__construct();
		}

        

        public function getDiccionario(){
			//EXTRAE conductores
			$sql = "SELECT * FROM  diccionario";
			$request = $this->select_all($sql);
			return $request;
		}

        public function insertPalabra(String $palabra, String $significado_en, String $traduccion_es, String $significado_es, String $image){
            $this->srtpalabra  = $palabra;
            $this->srtsignificado_en  = $significado_en;
            $this->srttraduccion_es  = $traduccion_es;
            $this->srtsignificado_es  = $significado_es;
            $this->srtimage  = $image;
           
           
            $return = 0;
            $sql = "SELECT * FROM diccionario WHERE 
                palabra = '{$this->srtpalabra}'";
            $request = $this->select_all($sql);
            if (empty($request)) {
    
                $query_insert  = "INSERT INTO diccionario(palabra, significado_en, traduccion_es, significado_es, image )VALUES(?,?,?,?,?)";
                $arrData = array(
                    $this->srtpalabra,
                    $this->srtsignificado_en,
                    $this->srttraduccion_es,
                    $this->srtsignificado_es,
                    $this->srtimage
                 
                );
                $request_insert = $this->insert($query_insert, $arrData);
                $return = $request_insert;
            } else {
                $return = "exist";
            }
            return $return;
        }

        public function updatePalabra(Int $iddiccionario, String $palabra, String $significado_en, String $traduccion_es, String $significado_es, String $image){

            $this->intiddiccionario = $iddiccionario; 
            $this->srtpalabra  = $palabra;
            $this->srtsignificado_en  = $significado_en;
            $this->srttraduccion_es  = $traduccion_es;
            $this->srtsignificado_es  = $significado_es;
            $this->srtimage  = $image;
     
         $return = 0;
     
         $sql = "SELECT * FROM diccionario WHERE palabra = '{$this->srtpalabra}'  AND iddiccionario != $this->intiddiccionario";
     
         $request = $this->select_all($sql);
         if (empty($request)) {
     
             $sql = "UPDATE diccionario SET palabra =?, significado_en =?, traduccion_es =?, significado_es=?, image = ? WHERE iddiccionario = $this->intiddiccionario  ";
             $arrData = array(
                $this->srtpalabra,
                    $this->srtsignificado_en,
                    $this->srttraduccion_es,
                    $this->srtsignificado_es,
                    $this->srtimage
             );

           
             $request_update  = $this->update($sql, $arrData);
             $return =    $request_update;
         } else {
             $return = "exist";
         }
         return $return;
     
     
        }

        public function getPalabra(int $iddiccionario){
            $this->intiddiccionario  = $iddiccionario;
    
            $sql = "SELECT *
            FROM  diccionario          
            where iddiccionario = $this->intiddiccionario";
            $request = $this->select($sql);
            return $request;
        }
     

    }