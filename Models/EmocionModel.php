<?php 

	class EmocionModel extends Mysql
	{
	
		private $srtimage;
		private $intemocion;
		private $intidemocion;

		public function __construct()
		{
			parent::__construct();
		}

		public function insertEmocion(int $emocion, String $image){
           
            $this->intemocion  = $emocion;
            $this->srtimage  = $image;
           
                $query_insert  = "INSERT INTO emocion_image(id_emocion, emocion_image)VALUES(?,?)";
                $arrData = array(
                    $this->intemocion,
                    $this->srtimage
                 
                );
                $request_insert = $this->insert($query_insert, $arrData);
                $return = $request_insert;
          
            return $return;
        }

		
        public function updateEmocion(int $idemocion, int $emocion, String $image){

			$this->intidemocion =$idemocion;
            $this->intemocion  = $emocion;
            $this->srtimage  = $image;
     
             $sql = "UPDATE emocion_image SET id_emocion =?, emocion_image =? WHERE idemocion_image = $this->intidemocion";
             $arrData = array(
                	$this->intemocion,
                    $this->srtimage
             );

           
             $request_update  = $this->update($sql, $arrData);
             $return =    $request_update;
        
         return $return;    
     
        }

		public function getEmociones(){
			//EXTRAE conductores
			$sql = "SELECT * FROM  emocion_image as ei
			left join emocion as e on ei.id_emocion = e.idemocion";
			$request = $this->select_all($sql);
			return $request;
		}

		public function getEmocion(int $idemocion){
			$this->intidemocion =$idemocion;
    
            $sql = "SELECT *
            FROM  emocion_image   as ei
			left join emocion as e on ei.id_emocion = e.idemocion     
            where ei.idemocion_image = $this->intidemocion";
            $request = $this->select($sql);
            return $request;
        }

		public function deleteEmocion(int $idemocion){
			$this->intidemocion =$idemocion;

            $query  = "DELETE FROM emocion_image 
            WHERE idemocion_image = $this->intidemocion";

            $request_delete = $this->delete($query);
            return $request_delete;
        }




    }