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


        public function getdatahoras(){
            $sql = "SELECT DATE_SUB(TO_CHAR(`tiempo` , 'YY/MM/DD HH24'),INTERVAL 1 HOUR) AS INI_BOT, COUNT(*) as COUNT_BOT 
            from `log` 
            WHERE tiempo BETWEEN '2022-10-31 00:00:00' AND NOW()  
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
      



     

    }