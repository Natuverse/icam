<?php

class Analisis extends Controllers
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
		//getPermisos(MANALISIS);
		
	}

	public function analisis()
	{
		
		$data['page_tag'] = "ANALISIS - ICAM";
		$data['page_title'] = "ANALISIS - ICAM";
		$data['page_name'] = "ANALISIS";
		$data['page_functions_js'] = "functions_analisis.js";
		$this->views->getView($this, "analisis", $data);
      
	}

    public function palabras()
	{
		
		$data['page_tag'] = "ANALISIS - ICAM";
		$data['page_title'] = "ANALISIS - ICAM";
		$data['page_name'] = "ANALISIS";
		$data['page_functions_js'] = "functions_analisis.js";
		$this->views->getView($this, "palabras", $data);
      
	}

	public function calpalabras(){

		$desactivar = $this->model->desactivarpalabras();
        $arrData =  $this->model->getConversaciones();

		//dep($arrData);

		echo "entro ";

		for ($i = 0; $i < count($arrData); $i++) {

            $message  = $arrData[$i]['conversacion'];
      
                $words = explode(" ", $message);
				

                foreach($words as $word){
					if($word !='or' && $word != 'and' && $word != "i´m"  && $word != "I´m" && $word != "I'm" && $word != "I´M" && $word != "that's" && $word != "how's" && $word != "i'm"){
						

						echo $word.'<br>';
                    	$cant = 0;
						$word = addslashes($word);
						$word = str_replace('?',"",$word);
						$word = str_replace('"',"'",$word);
						$word = str_replace("´","'",$word);
						$word = str_replace('/\/',"'",$word);
						$word = strClean($word);		
						//echo $word.'<br>';
                    	$arrWord = $this->model->consultPalabraActiva($word);
                    	if($arrWord>0){
                    	    for ($j = 0; $j < count($arrData); $j++) {

                    	        $message2  = $arrData[$j]['conversacion'];
							
                    	        $words2 = explode(" ", $message2);
                    	      

                    	        foreach($words2 as $word2){
									$word2 = addslashes($word2);
									$word2 = str_replace('?',"",$word2);
									$word2 = str_replace('"',"'",$word2);
									$word2 = str_replace('´',"'",$word2);
									$word2 = str_replace('/\/',"'",$word2);
									$word2 = strClean( $word2);	
                    	            if($word ==$word2 ){
                    	                $cant++;
                    	            }

                    	        }
                    	    }

                    	    $insetPalabra = $this->model->insetPalabra($word, $cant);

                    	}
					}
                }

        }
		echo "Fin del proceso";		
	}

	public function calOraciones(){

		

		$desactivar = $this->model->desactivaroraciones();
        $arrData =  $this->model->getConversaciones();

		//dep($arrData);

		echo "entro ";

		for ($i = 0; $i < count($arrData); $i++) {

            $message  = $arrData[$i]['conversacion'];
      
						echo $message.'<br>';
                    	$cant = 0;
						$message = addslashes($message);
						$message = str_replace('?',"",$message);
						$message = str_replace('"',"'",$message);
						$message = str_replace("´","'",$message);
						$message = str_replace('/\/',"'",$message);
						$message = strClean($message);
						//echo $word.'<br>';
                    	$arrWord = $this->model->consultOracionctiva($message);
                    	if($arrWord>0){
                    	    for ($j = 0; $j < count($arrData); $j++) {

                    	        $message2  = $arrData[$j]['conversacion'];
							
                    	      
									$message2 = addslashes($message2);
									$message2 = str_replace('?',"",$message2);
									$message2 = str_replace('"',"'",$message2);
									$message2 = str_replace('´',"'",$message2);
									$message2 = str_replace('/\/',"'",$message2);
									$message2 = strClean( $message2);
                    	            if($message ==$message2){
                    	                $cant++;
                    	            }

                    	  
                    	    }

                    	    $insetPalabra = $this->model->insetOracion($message, $cant);

                
					
                }

        }
		echo "Fin del proceso";		
	}



}