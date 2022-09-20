<?php
header("Access-Control-Allow-Origin: *");
class Icam extends Controllers
{
	public function __construct()
    {
        parent::__construct();
		
    }


	public function icambot()
	{
		if($_POST){

			$arrResponse = array('status' => true, 'msg' => 'ok');
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}else{
			$arrResponse = array('status' => false, 'msg' => 'false');
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		//die();
	}

	public function chatbot()
    {
        if (!empty($_POST)) {
            
            if(empty($_POST['user']) || empty($_POST['type']) || empty($_POST['message']) ){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
            }else{
                $user  =  strClean($_POST['user']);
                $type  =  intval($_POST['type']);
                $message  =  strClean($_POST['message']);
                $webCam  =  strClean($_POST['webCam']);
                $private =  intval($_POST['private']);
                $voice =  intval($_POST['voice']);          
           
                $iduser   = $this->model->consultarUsuario($user, $type);
                $idwebcam =0;
                if( $type ==2){
                    $idwebcam   = $this->model->consultarUsuario($webCam, $type);
                }               
             
                $requestConversacion = $this->model->InsertConversacional($iduser, $message, $idwebcam, $private, $voice);
           
                if(!empty($requestConversacion)){
                    $arrResponse = array('status' => true, 'msg' => 'ok' ); 
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'false');
                  
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
     
        die();

    }

    public function diccionario()
    {
        if (!empty($_POST)) {
            
            if(empty($_POST['message']) ){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
            }else{
              
                $message  =  strClean($_POST['message']);

                $params=['message'=>  $message];
                $defaults = array(
                CURLOPT_URL => 'http://192.168.1.254:5000',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $params,
                );
                $ch = curl_init();
                curl_setopt_array($ch, $defaults);

                $result2 = curl_exec($ch);

                curl_close($ch);
                //$str = substr($result, 1, -1);
                //print_r($result);


                $array = json_decode($result2, true);
                //print_r($array);

               
                $words2 =  $array['traduccion']['text'];
                //dep($array);
                $array = $array['sentimiento'][0];

                $aux=0;
                $max=0;

                for($i=0; $i<count($array); $i++){

                    if($array[$i]['score']>$aux){
                        $aux =$array[$i]['score'];
                        $max = $i;
                    }
                }

                $max++;

                $arrSentimiento = $this->model->consultarEmociones($max);
               

                $sent= rand(0, count($arrSentimiento));

               
                $defaults = array(
                CURLOPT_URL => 'http://192.168.1.254:8080/interact',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $params,
                );
                $ch2 = curl_init();
                curl_setopt_array($ch2, $defaults);

                $result3 = curl_exec($ch2);
                curl_close($ch2);
                //$str = substr($result, 1, -1);
                //print_r($result);


                $array2 = json_decode($result3, true);
               
               
                $params=['message'=>  $array2['text']];
                $defaults = array(
                CURLOPT_URL => 'http://192.168.1.254:5000',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $params,
                );
                $ch = curl_init();
                curl_setopt_array($ch, $defaults);

                $resultes1 = curl_exec($ch);

                curl_close($ch);
                //$str = substr($result, 1, -1);
                //print_r($result);


                $arrayEs2 = json_decode($resultes1, true);
                $textEsF = $arrayEs2['traduccion']['text'];

                /////////////////////////////////

                $params=['message'=>   $array2['beam_texts'][0][0]];
                $defaults = array(
                CURLOPT_URL => 'http://192.168.1.254:5000',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $params,
                );
                $ch = curl_init();
                curl_setopt_array($ch, $defaults);

                $resultes2 = curl_exec($ch);

                curl_close($ch);
                //$str = substr($result, 1, -1);
                //print_r($result);


                $arrayEs2 = json_decode($resultes2, true);
                $textEsF1 = $arrayEs2['traduccion']['text'];

                ////////////////////////////////////////////
                $params=['message'=>   $array2['beam_texts'][1][0]];
                $defaults = array(
                CURLOPT_URL => 'http://192.168.1.254:5000',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $params,
                );
                $ch = curl_init();
                curl_setopt_array($ch, $defaults);

                $resultes3 = curl_exec($ch);

                curl_close($ch);
                //$str = substr($result, 1, -1);
                //print_r($result);


                $arrayEs3 = json_decode($resultes3, true);
                $textEsF2 = $arrayEs3['traduccion']['text'];
              

                $words = explode(" ", $message);
                $words2 = explode(" ", $words2);
                //$words2  =  strClean($words2);
                $result = [];

                $html= '<div id="btnClose"></div>
                <div class="titleBar">
                    <div id="nameUser" class="bigTitle">JCLEON</div>
                    <div id="preferences">
                        
                    </div>
                </div>
                <br>
                <div class="flexH">
                    <div class="flex2">
                        <div class="box">
                      
                            <div class="titleTag">TRASLATE</div>
                            <p id="testSpanish">';
                         
                foreach($words2 as $word){
                    $request =0;
                    $request = $this->model->consultDiccionario($word);
                    //Consultar base de datos
                    // $dts es la respuesta de la consulta
                 
            

                    if(sizeof($request) > 0 ){
                        $html.='<span class="link" data-image="'.media().'/images/iconicam.png" data-text="'.$request[0]['significado_es'].'">'.$word.'</span> ';

                    }else{
                        $html.=$word." ";
                    }

                                       
                   
                }
             
                $html.=' </p>
                <div class="toRight">
                    <img class="iconLanguage" src="https://creamox.com/images_icam/iconSpanish.png" title="Spanish" />
                </div>
            </div>
            <br>
            <br>
            <div class="box">
                
                <div class="titleTag">ORIGINAL</div>        
                <p id="textEnglish">';

               // $worda2 =  $array['traduccion']['text']

              
                foreach($words as $word){
                    $request =0;
                    $request = $this->model->consultDiccionario($word);
                    //Consultar base de datos
                    // $dts es la respuesta de la consulta
                 
            

                    if(sizeof($request) > 0 ){
                        $html.='<span class="link" data-image="'.media().'/images/iconicam.png" data-text="'.$request[0]['significado_es'].'">'.$word.'</span> ';

                    }else{
                        $html.=$word." ";
                    }                                     
                   
                }              
                
                
                $html.='</p>
                <div class="toRight">
                    <img class="iconLanguage" src="https://creamox.com/images_icam/iconEnglish.png" title="English" />
                </div>
            </div>
        </div>

        <div class="flex1">
        
            <img id="imageExpression" src="'. media() . '/images/uploads/emocion/'.$arrSentimiento[$sent]['emocion_image'] .'" title="'.$arrSentimiento[$sent]['id_emocion'].'" />
        </div>
        
    </div>

    <div id="answers">
        <div class="itemAnswer">
            <div class="text">
                '.$textEsF.'
            </div>
            <br>
            <div class="titleGreen">
               '.$array2['text'].'
            </div>
            <img class="iconSend" src="https://creamox.com/images_icam/btn-send.png" data-text="'.$array2['text'].'" title="Send"/>
        </div>

        <div class="itemAnswer">
            <div class="text">
               '.$textEsF1.'
            </div>
            <br>
            <div class="titleGreen">
                '.$array2['beam_texts'][0][0].'
            </div>
            <img class="iconSend" src="https://creamox.com/images_icam/btn-send.png" data-text=" '.$array2['beam_texts'][0][0].'" title="Send"/>
        </div>

        <div class="itemAnswer">
            <div class="text">
               '.$textEsF2 .'
            </div>
            <br>
            <div class="titleGreen">
            '.$array2['beam_texts'][1][0].'
            </div>
            <img class="iconSend" src="https://creamox.com/images_icam/btn-send.png" data-text=" '.$array2['beam_texts'][1][0].'" title="Send"/>
        </div>
    </div>';

          
             

               
             
              
           
    
                    $arrResponse = array('status' => true, 'msg' => 'ok', 'html'=>$html ); 
            
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
     
        die();
    }

}



