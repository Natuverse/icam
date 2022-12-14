<?php 

	class AnalisisModel extends Mysql
	{
		private $srtpalabra;
		private $srtStatus;
        private $intCant;
        private $intModelo;

		public function __construct()
		{
			parent::__construct();
		}


        public function getdatahoras(){
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo` , 'YY/MM/DD HH24'),INTERVAL 1 HOUR) AS INI_BOT, COUNT(*) as COUNT_BOT 
            from `log` 
            WHERE tiempo BETWEEN '2022-10-31 00:00:00' AND NOW()  
            GROUP by INI_BOT";


			$request = $this->select_all($sql);
			return $request;
        }

        public function getdatahorasModelo(int $modelo){
            $this->intModelo = $modelo;
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo` , 'YY/MM/DD HH24'),INTERVAL 1 HOUR) AS INI_BOT, COUNT(*) as COUNT_BOT 
            from `log` 
            WHERE tiempo BETWEEN '2022-10-31 00:00:00' AND NOW() and model =  $this->intModelo
            GROUP by INI_BOT";


			$request = $this->select_all($sql);
			return $request;
        }

        public function getdataMensajeshoras(){
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo`  , 'YY/MM/DD HH24'),INTERVAL 1 HOUR) AS INI_MENS, COUNT(*) as COUNT_MENS 
            from `conversacion`
            WHERE (tiempo BETWEEN '2022-10-31 00:00:00' AND NOW())  and `idmodelo`> 0
            GROUP by INI_MENS";
            
			$request = $this->select_all($sql);
			return $request;
        }

        public function getdataMensajeshorasModelo(int $modelo){
            $this->intModelo = $modelo;
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo`  , 'YY/MM/DD HH24'),INTERVAL 1 HOUR) AS INI_MENS, COUNT(*) as COUNT_MENS 
            from `conversacion`
            WHERE (tiempo BETWEEN '2022-10-31 00:00:00' AND NOW())  and `idmodelo`= $this->intModelo
            GROUP by INI_MENS";
            
			$request = $this->select_all($sql);
			return $request;
        }

        public function getdatamin(){
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo` , 'YY/MM/DD HH24:MI'),INTERVAL 1 MINUTE) AS INI_BOT, COUNT(*) as COUNT_BOT 
            from `log` 
            WHERE tiempo BETWEEN '2022-10-31 00:00:00' AND NOW()  
            GROUP by INI_BOT";


			$request = $this->select_all($sql);
			return $request;
        }
        public function getdataminmodelo(int $modelo){
            $this->intModelo = $modelo;
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo` , 'YY/MM/DD HH24:MI'),INTERVAL 1 MINUTE) AS INI_BOT, COUNT(*) as COUNT_BOT 
            from `log` 
            WHERE tiempo BETWEEN '2022-10-31 00:00:00' AND NOW()   and  model= $this->intModelo
            GROUP by INI_BOT";


			$request = $this->select_all($sql);
			return $request;
        }

        public function getdataMensajesmin(){
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo`  , 'YY/MM/DD HH24:MI'),INTERVAL 1 MINUTE) AS INI_MENS, COUNT(*) as COUNT_MENS 
            from `conversacion`
            WHERE (tiempo BETWEEN '2022-10-31 00:00:00' AND NOW())  and `idmodelo`> 0
            GROUP by INI_MENS";
            
			$request = $this->select_all($sql);
			return $request;
        }

        public function getdataMensajesminmodelo($modelo){
            $this->intModelo = $modelo;
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo`  , 'YY/MM/DD HH24:MI'),INTERVAL 1 MINUTE) AS INI_MENS, COUNT(*) as COUNT_MENS 
            from `conversacion`
            WHERE (tiempo BETWEEN '2022-10-31 00:00:00' AND NOW())  and `idmodelo` =  $this->intModelo
            GROUP by INI_MENS";
            
			$request = $this->select_all($sql);
			return $request;
        }

        public function getdataMensajesBandeja(){
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo`  , 'YY/MM/DD HH24'),INTERVAL 1 HOUR) AS INI_BANDEJA, COUNT(*)  as COUNT_BANDEJA
            from `log` 
            WHERE user= 249 and (tiempo BETWEEN '2022-10-31 00:00:00' AND NOW()) 
            GROUP by INI_BANDEJA";
            
			$request = $this->select_all($sql);
			return $request;
        }

        public function getdataMensajesSinBandeja(){
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo`  , 'YY/MM/DD HH24'),INTERVAL 1 HOUR) AS INI_GENERAL, COUNT(*)  as COUNT_GENERAL
            from `log` 
            WHERE user != 249 and (tiempo BETWEEN '2022-10-31 00:00:00' AND NOW()) 
            GROUP by INI_GENERAL";
            
			$request = $this->select_all($sql);
			return $request;
        }

        public function getmodel(){
            $sql = "SELECT l.model, ub.nombre, COUNT(*) as consultas
            from `log` as l 
            left join `usuariobot` as ub on l.model  = ub.idusuariobot
            WHERE l.user!= 0 
            GROUP by ub.nombre";
            
			$request = $this->select_all($sql);
			return $request;
        }
      



     

    }