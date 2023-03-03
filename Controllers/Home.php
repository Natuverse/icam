<?php 
	//require_once("Models/TCategoria.php");
	//require_once("Models/TProducto.php");
	class Home extends Controllers{
		//use TCategoria, TProducto;
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}else{
				header('Location: '.base_url().'/dashboard');
				die();
			}
			getPermisos(1);
		}

		public function home()
		{
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "Mi mentor pro";		
			$this->views->getView($this,"home",$data);
		}

	}