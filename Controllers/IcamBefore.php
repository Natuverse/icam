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
            
            if(empty($_POST['message']) || empty($_POST['girl'])){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
                
            }else{
              
              
                    $message_EN  =  strClean($_POST['message']);
                    $html = '';

                    //Validate existing token, if empy, sing up for get new
                    
                    
                $token = $this->login($_POST['girl']);
                    if(empty($_POST['token'])){
                        $token = $this->login($_POST['girl']);
                        
                        if($token == 'none'){
                            $this->signup($_POST['girl']);
                            $token = $this->login($_POST['girl']);
                        }
                    }
                
                    
                    $response1_EN = "";
                    $response2_EN = $this->chat($token, $message_EN);
                    $response3_EN = "";
                        
                    $arrayTranslation = $this->translate(strtolower($message_EN), $response1_EN, $response2_EN, $response3_EN);

                    $message_ES = $arrayTranslation[0]['text'];
                    $response1_ES = $arrayTranslation[1]['text'];
                    $response2_ES = $arrayTranslation[2]['text'];
                    $response3_ES = $arrayTranslation[3]['text'];
                
                
                    // for feelings
                
                    $params=['message'=>  strClean($_POST['message'])];
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

                    $array = json_decode($result2, true);

                    $words2 =  $array['traduccion']['text'];

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
                
                
                    
                    $html .= '<div class="titleBar">
                                    <div id="nameUser" class="bigTitle">'.$_POST['user'].'</div>
                                    <div id="preferences">
                                    </div>
                                </div>
                                <br>
                                <div class="flexH alignT">
                                    <div class="flex1 box">
                                        <div class="titleTag">TRASLATE</div>
                                        <p id="testSpanish">
                                            '.$message_ES.'
                                        </p>
                                        <div class="toRight">
                                            <img class="iconLanguage" src="https://devstec.digital/Assets/images/iconSpanish.png" title="Spanish" />
                                        </div>
                                    </div>

                                    <div class="flex1 box">
                                        <div class="titleTag">ORIGINAL</div>
                                        <p id="textEnglish">
                                            ';
                
                    $words = explode(" ", $message_EN);

                    foreach($words as $word){
                        $request =0;
                        $request = $this->model->consultDiccionario($word);
                        
                        if(sizeof($request) > 0 ){
                            $html.='<span class="link" data-image="'.media().'/images/iconicam.png" data-text="'.$request[0]['significado_es'].'">'.$word.'</span> ';

                        }else{
                            $html.=$word." ";
                        }                                     

                    }      
                
                    $html .= '
                                        </p>
                                        <div class="toRight">
                                            <img class="iconLanguage" src="https://devstec.digital/Assets/images/iconEnglish.png" title="English" />
                                        </div>
                                    </div>

                                    <div class="flex1">
                                        <div class="backgroundColors">
                                            <div class="bigTitle">ALEGRE</div>
                                            <img id="imageExpression" src="'. media() . '/images/uploads/emocion/'.$arrSentimiento[$sent]['emocion_image'] .'" title="'.$arrSentimiento[$sent]['id_emocion'].'" />
                                            <div class="text" style="font-size: 12px; font-weight:100">Muestra tu mejor sonrisa</div>
                                        </div>
                                    </div>

                                </div>

                                <div id="answers">
                                    <div class="title" style="color: white; font-size:16px; font-weight:bold; margin-bottom: 8px;">SUGERENCIA DE RESPUESTAS</div>
                                    <div class="itemAnswer">
                                        <div id="answer1ES" class="text">
                                            '.$response1_ES.'
                                        </div>
                                        <br>
                                        <div id="answer1EN" class="text" style="font-weight: 100;">
                                            '.$response1_EN.'
                                        </div>
                                        <img class="iconSend" src="https://devstec.digital/Assets/images/btn-send.png" data-text="'.$response1_EN.'" title="Send"/>
                                    </div>

                                    <div class="itemAnswer">
                                        <div id="answer2ES" class="text">
                                            '.$response2_ES.'
                                        </div>
                                        <br>
                                        <div id="answer2EN" class="text" style="font-weight: 100;">
                                            '.$response2_EN.'
                                        </div>
                                        <img class="iconSend" src="https://devstec.digital/Assets/images/btn-send.png" data-text="'.$response2_EN.'" title="Send"/>
                                    </div>

                                    <div class="itemAnswer">
                                        <div id="answer3ES" class="text">
                                            '.$response3_ES.'
                                        </div>
                                        <br>
                                        <div id="answer3EN" class="text" style="font-weight: 100;">
                                            '.$response3_EN.'
                                        </div>
                                        <img class="iconSend" src="https://devstec.digital/Assets/images/btn-send.png" data-text="'.$response3_EN.'" title="Send"/>
                                    </div>
                                </div>';

                    $arrResponse = array('html' => $html, 'token' => $token);
                    

                

                /*
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
                    <img class="iconLanguage" src="https://devstec.digital/Assets/images/iconSpanish.png" title="Spanish" />
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
                    <img class="iconLanguage" src="https://devstec.digital/Assets/images/iconEnglish.png" title="English" />
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
            <img class="iconSend" src="https://devstec.digital/Assets/images/btn-send.png" data-text="'.$array2['text'].'" title="Send"/>
        </div>

        <div class="itemAnswer">
            <div class="text">
               '.$textEsF1.'
            </div>
            <br>
            <div class="titleGreen">
                '.$array2['beam_texts'][0][0].'
            </div>
            <img class="iconSend" src="https://devstec.digital/Assets/images/btn-send.png" data-text=" '.$array2['beam_texts'][0][0].'" title="Send"/>
        </div>

        <div class="itemAnswer">
            <div class="text">
               '.$textEsF2 .'
            </div>
            <br>
            <div class="titleGreen">
            '.$array2['beam_texts'][1][0].'
            </div>
            <img class="iconSend" src="https://devstec.digital/Assets/images/btn-send.png" data-text=" '.$array2['beam_texts'][1][0].'" title="Send"/>
        </div>
    </div>';

          
             

               
             
              
           
    
                    $arrResponse = array('status' => true, 'msg' => 'ok', 'html'=>$html ); 
            */
                    
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
     
        die();
        
    }



    public function signup($name){

        $url = "localhost:5001/signup";
        $ch = curl_init($url);

        $post = array(
          'name'=>$name,
          'email'=>$name.'@icam.com',
          'password'=>'12345678');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_PORT, 5001);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                  "name=".$post['name']."&email=".$post['email']."&password=".$post['password']."");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        header('Content-Type: text/html');
        
        curl_close ($ch);
        
        return $server_output;
    }




    public function login($name){
        $url = "localhost:5001/login";
        $ch = curl_init($url);

        $post = array(
          'email'=>$name.'@icam.com',
          'password'=>'12345678');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                  "email=".$post['email']."&password=".$post['password']."");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        header('Content-Type: text/html');

        $token = 'none';

        if($server_output != 'Could not verify'){
            $array = json_decode($server_output, true);
            $token = $array['token'];
        }

        curl_close ($ch);

        return $token;
    }



    public function chat($token, $message){
        $url = "localhost:5001/chat";
        $ch = curl_init($url);

        $post = array(
          'question'=>$message);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                  "question=".$post['question']);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Access-Control-Allow-Credentials: true',
        'Accept: application/json',
        'Authorization: Bearer '.$token
        ));

        $server_output = curl_exec($ch);

        header('Content-Type: text/html');

        $array = json_decode($server_output, true);
        
        curl_close ($ch);
        
        return $array['Answer'];
    }
        
    
    public function translate($text1, $text2, $text3, $text4){
        $url = "https://api-free.deepl.com/v2/translate";

        $ch = curl_init($url);

        $post = array(
            'text' => $text1,
            'text' => $text2,
            'text' => $text3,
            'text' => $text4,
            'target_lang' => 'ES',
            'auth_key' => '9d2faece-c6a9-1244-2596-e047dd25d881:fx');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                'text='.$text1.'&text='.$text2.'&text='.$text3.'&text='.$text4.'&target_lang=ES&auth_key=9d2faece-c6a9-1244-2596-e047dd25d881:fx');


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        header('Content-Type: text/html');

        $array = json_decode($server_output, true);
        
        curl_close ($ch);

        return $array['translations'];
    }
}


