<?php


class Modelo extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		
		session_start();
		session_regenerate_id(true);
		
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		
		getPermisos(MANALISIS);
		
	}

	public function Modelo()
	{
		
		$data['page_tag'] = "Modelo - ICAM";
		$data['page_title'] = "Modelo - ICAM";
		$data['page_name'] = "Modelo";
		$data['page_functions_js'] = "modelo_analisis.js";
		$this->views->getView($this, "modelo", $data);
      
	}

}