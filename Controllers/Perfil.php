<?php

class Perfil extends Controllers
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
		//getPermisos(MDASHBOARD);
		
	}

	public function perfil()
	{
		
		$data['page_tag'] = "Perfil - Mi mentor pro";
		$data['page_title'] = "Perfil - Mi mentor pro";
		$data['page_name'] = "Perfil";
		$data['page_functions_js'] = "functions_perfil.js";
		$this->views->getView($this, "perfil", $data);
	}
}