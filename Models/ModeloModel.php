<?php 

	class ModeloModel extends Mysql
	{
		
        private $intModelo;
		private $srtnacimiento;
		private $srtantiguedad;
		private $intingles;
		private $srtcreacion;

		public function __construct()
		{
			parent::__construct();
		}

		public function getmodel(){
            $sql = "SELECT l.model, ub.nombre, ub.edad, ub.fecha_creacion, ub.fecha_inicio, en.nivel_ingles, COUNT(*) as consultas
            from `log` as l 
            left join `usuariobot` as ub on l.model  = ub.idusuariobot
			left join `nivel_ingles` as en on ub.nivel_ingles = en.idnivel_ingles
            WHERE l.user!= 0 
            GROUP by ub.nombre";
            
			$request = $this->select_all($sql);
			return $request;
        }

		public function getmodelall(){
            $sql = "SELECT *
            from `usuariobot` where tipo = 1 ";
          
            
			$request = $this->select_all($sql);
			return $request;
        }

		public function consulcon(int $idmodelo){
			$this->intModelo  = $idmodelo;
			$sql = "SELECT 
			*
			FROM  conversacion  where idmodelo = $this->intModelo";
			$request = $this->select_all($sql);
			return $request;
		}

		public function consulconlog(int $idmodelo){
			$this->intModelo  = $idmodelo;
			$sql = "SELECT 
			*
			FROM  log  where model = $this->intModelo";
			$request = $this->select_all($sql);
			return $request;
		}

		public function uptateini(int $idmodelo , String $creacion){
			$this->intModelo  = $idmodelo;
			$this->srtcreacion  = $creacion;

			$sql = "UPDATE usuariobot SET fecha_creacion =? WHERE idusuariobot = $this->intModelo  ";
			$arrData = array(
				$this->srtcreacion          
				    
			
			);
			$request_update  = $this->update($sql, $arrData);
			$return =    $request_update;
	
		return $return;
		}
		



		public function getModelo(int $idmodelo){
			$this->intModelo  = $idmodelo;
	
			$sql = "SELECT 
			*
			FROM  usuariobot 
			where idusuariobot = $this->intModelo";
			$request = $this->select($sql);
			return $request;
		}

		public function updateModelo(int $idemodelo,  String $nacimiento,  String $antiguedad, int $ingles){
			$this->intModelo = $idemodelo;
			$this->srtnacimiento  = $nacimiento;      
			$this->srtantiguedad  = $antiguedad;
			$this->intingles  = $ingles;     
			
		
				$sql = "UPDATE usuariobot SET edad =?, fecha_inicio=?, nivel_ingles=? WHERE idusuariobot = $this->intModelo  ";
				$arrData = array(
					$this->srtnacimiento,          
					$this->srtantiguedad,
					$this->intingles           
				
				);
				$request_update  = $this->update($sql, $arrData);
				$return =    $request_update;
		
			return $return;
		
		
			}

    }