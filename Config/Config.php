<?php 
	
	
	const BASE_URL = "https://devstec.digital";

	//Zona horaria
	date_default_timezone_set('America/Bogota');

	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "u229691282_icam";
	const DB_USER = "root";
	const DB_PASSWORD = "devstech";
	const DB_CHARSET = "utf8";

		//Deliminadores decimal y millar Ej. 24,1989.00
		const SPD = ".";
		const SPM = ",";
	
		//Simbolo de moneda
		const SMONEY = "$";
		
		const MDASHBOARD = 1;
		const MROLES= 2;
		const MUSUARIOS = 3;
		const MDICCIONARIO =4;
		const MANALISIS =5;
		const MEMOCIONES =6;


		const NOMBRE_REMITENTE = "ICAM";
		const EMAIL_REMITENTE = "no-reply@ICAM.com";
		const NOMBRE_EMPESA = "ICAM";
		const WEB_EMPRESA = "www.icam.com";
