<?php
header("Access-Control-Allow-Origin: *");
class Icamfull extends Controllers
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

    public function prueba(){
        $arrd   = $this->model->modelosdic();
        //dep($arrd);
        foreach($arrd as $arr){
            print_r($arr);
            $modelo = $this->model->udptemodel($arr['user']);
        }
        die();
    }

    public function feelback(){
        if (!empty($_POST)) {
            if(empty($_POST['question']) || empty($_POST['answer'])  ){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
            }else{
                $question  =  strtolower(strCleanlive($_POST['question']));
                $answer  =  strtolower(strCleanlive($_POST['answer']));
                $qualification  =  ($_POST['qualification']);
                
                $requestfeelback = $this->model->feelback($question, $answer, $qualification);
                
                if(!empty($requestfeelback)){
                    $arrResponse = array('status' => true, 'msg' => 'ok' ); 
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'false');
                  
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();

    }

    public function feelbackFine(){
        if (!empty($_POST)) {
            if(empty($_POST['question']) ){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
            }else{
                $question  =  strCleanlive($_POST['question']);
                $answer_bot1  =  strCleanlive($_POST['answer_bot1']);
                $answer_bot2  =  strCleanlive($_POST['answer_bot2']);
                $edit_answer  =  strCleanlive($_POST['edit_answer']);
                $bot1  =  intval($_POST['bot1']);
                $bot2  =  intval($_POST['bot2']);
                              
                $requestfeelback = $this->model->feelbackFine($question, $answer_bot1, $answer_bot2,   $edit_answer, $bot1,$bot2  );
                
                if(!empty($requestfeelback)){
                    $arrResponse = array('status' => true, 'msg' => 'ok' ); 
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'false');
                  
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();

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

    public function fine(){
        $request= $this->model->consullog();
       // $requestdelete = $this->deteletefine();
        for ($i = 0; $i < count($request); $i++) {
           
            $requestquestion = $this->model->insetQuestion(strClean($request[$i]['pregunta']), strClean($request[$i]['respuesta']),$request[$i]['cant'] );
         
        }
        die();
    }

    function detectLanguage($text){
        $words = explode(" ", $text);
        if (count($words) > 3) {
            
            $params=['message'=>  strClean($text)];
            $defaults = array(
            CURLOPT_URL => 'http://192.168.1.254:5000/idioma',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
            );
            $ch = curl_init();
            curl_setopt_array($ch, $defaults);

            $result2 = curl_exec($ch);

            curl_close($ch);

            $array = json_decode($result2, true);

            return $array['idioma']['label'];
        }
        
        return $text;
    }

    public function diccionario()
    {
        if (!empty($_POST)) {
            
            if(empty($_POST['message']) || empty($_POST['girl'])){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
                
            }else{
              
              
                    $message_EN  =  strClean($_POST['message']);
                    /*$language = $this->detectLanguage($message_EN);
                    //var_dump($language);
                    
                    if($language != "EN"){
                        $message_EN = $this->translateTo($message_EN, 'EN')[0]['text'];
                    }*/
                    
                    $html = '';

                  
                    
                    if(empty($_POST['token'])){
                        $token = $this->login($_POST['girl']);
                        $iduser   = $this->model->consultarUsuario($_POST['girl'], 1);
                        $request_log = $this->model->inserlog($iduser, 1, 0, "","",0,0 );
                
                        if($token == 'none'){
                            $this->signup($_POST['girl']);
                            $token = $this->login($_POST['girl']);
                        }
                    }else{
                        $token = $_POST['token'];
                       
                    }
                    
                    

                    $words = explode(" ", $message_EN);
                    $cadena ="";
                    $html2 = "";

                    $temp =0;
                $double = true;
                //dep($words[0]);
                $cat =  count($words)-1 ;
               

                for($i = 0; $i < count($words); ++$i) {
                    $request =0;
                    $requestcom = 0;
                    $requestabre = $this->model->consulAbre($words[$i]);
                    if(sizeof($requestabre) > 0 ){
                        
                        $words[$i] =   $requestabre[0]['palabra'];                   
                        $cadena.=$words[$i]." ";
                    }else{
                        $cadena.=$words[$i]." ";
                        //$html.=$word." ";
                    }  
                    $request = $this->model->consultDiccionario($words[$i]);
                    $temp = $i;
                   
                    if($i< $cat){
                        $i++;
                       // echo $words[$temp]."\n";
                       // echo $words[$i]."\n";
                        $word = $words[$temp]." ".$words[$i];
                       // echo $word;
                        $requestcom = $this->model->consultDiccionario($word);
                    }else{
                        $requestcom = $this->model->consultDiccionario("");
                    }
                   
                   
                    //print_r($requestcom);
                    if(sizeof($request) > 0 ){
                        //$cadena.=$request[0]['palabra'];
                        if($double){
                            $html2.='<span class="chat-icam-link" data-image="'.media().'/images/iconicam.png" data-text="'.$request[0]['significado_es'].'">'.$words[$temp].'</span> ';
                        }else{
                            $double = true;
                        }
                     
                       // echo sizeof($requestcom);
                    }else if(sizeof($requestcom) > 0){
                        $double = false;
                        //$cadena.=$word." ";
                        $html2.='<span class="chat-icam-link" data-image="'.media().'/images/iconicam.png" data-text="'.$requestcom[0]['significado_es'].'">'.$words[$temp]." ".$words[$i].'</span> ';
                      
                    } else{
                        if( $double){
                            $html2.=$words[$temp]." ";
                        }
                       
                    }
                    $i = $temp;
                }
                    $message_EN = $cadena;           
                    $response1_EN = "";
                    $response2_EN = $this->chat($token, $message_EN);
                    $response3_EN = "";
                        
                    $arrayTranslation = $this->translate(strtolower($message_EN), $response1_EN, $response2_EN, $response3_EN);

                    $message_ES = $arrayTranslation[0]['text'];
                    $response1_ES = $arrayTranslation[1]['text'];
                    $response2_ES = $arrayTranslation[2]['text'];
                    $response3_ES = $arrayTranslation[3]['text'];
                
                    // for feelings
                    $params=['message'=>  $message_EN ];
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
                
                
                    
                    $html .= '<div class="chat-icam-titleBar">
                                    <div id="chat-icam-nameUser" class="chat-icam-bigTitle">'.$_POST['user'].'</div>
                                    <div id="chat-icam-preferences">
                                    </div>
                                </div>
                                <br>
                                <div class="chat-icam-flexH chat-icam-alignT">
                                    <div class="chat-icam-flex1 chat-icam-box">
                                        <div class="chat-icam-titleTag">TRASLATE</div>
                                        <p id="chat-icam-testSpanish">
                                            '.$message_ES.'
                                        </p>
                                        <div class="chat-icam-toRight">
                                            <img class="chat-icam-iconLanguage" src="https://devstec.digital/Assets/images/iconSpanish.png" title="Spanish" />
                                        </div>
                                    </div>

                                    <div class="chat-icam-flex1 chat-icam-box">
                                        <div class="chat-icam-titleTag">ORIGINAL</div>
                                        <p id="chat-icam-textEnglish">
                                            '.$html2.'
                                        </p>
                                        <div class="chat-icam-toRight">
                                            <img class="chat-icam-iconLanguage" src="https://devstec.digital/Assets/images/iconEnglish.png" title="English" />
                                        </div>
                                    </div>

                                    <div class="chat-icam-flex1">
                                        <div class="chat-icam-backgroundColors">
                                            <div class="chat-icam-bigTitle">'.$arrSentimiento[$sent]['emocion_es'] .'</div>
                                            <img id="chat-icam-imageExpression" src="'. media() . '/images/uploads/emocion/'.$arrSentimiento[$sent]['emocion_image'] .'" title="'.$arrSentimiento[$sent]['emocion_es'].'" />
                                            <div class="chat-icam-text" style="font-size: 12px; font-weight:100">'.$arrSentimiento[$sent]['descripcion'] .'</div>
                                        </div>
                                    </div>

                                </div>
                                <div id="chat-icam-answers" style="margin-top:10px; width: 100%;">
                                    <div class="chat-icam-title" style="color: white; font-size:16px; font-weight:bold; margin-bottom: 8px;">SUGERENCIA DE RESPUESTAS</div>
                                    
                                    <div class="chat-icam-flexH chat-icam-itemAnswer" style="padding-right: 0px;">

                                        <div class="chat-icam-flexV" style="flex:15; padding-top: 20px; padding-bottom:20px; align-items: center; justify-content: center;">
                                        
                                            <div class="chat-icam-flex1 chat-icam-flexH chat-icam-alingT">
                                                <img class="chat-icam-flex1" src="https://devstec.digital/Assets/images/iconSpanish.png" title="Spanish" style="width:5px; margin:15px" />
                                                
                                                <div id="chat-icam-answer2ES" class="chat-icam-text" style="flex:20; display: block; text-align:left">
                                                    '.$response2_ES.'
                                                </div>
                                            </div>
                                            
                                            <div class="chat-icam-flex1 chat-icam-flexH chat-icam-alingT">
                                                <img class="chat-icam-flex1" src="https://devstec.digital/Assets/images/iconEnglish.png" title="Spanish" style="width:5px; margin:15px" />
                                                
                                                <div id="chat-icam-answer2EN" class="chat-icam-text" style="flex:20; font-weight: 100; display: block; text-align:left; color:#d7acff;">
                                                    '.$response2_EN.'
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="chat-icam-flex1 chat-icam-flexV">
                                        
                                            <img class="chat-icam-iconSend" src="https://devstec.digital/Assets/images/btn-send.png" data-text="'.$response2_EN.'" title="Copiar"/>

                                            <img class="chat-icam-iconFeelBack" src="https://devstec.digital/Assets/images/pencil.png" data-response="'.$response2_EN.'" data-translate="'.$response2_ES.'" title="Editar"/>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div id="iconsFeelback">
                                    <img src="https://devstec.digital/Assets/images/btn-good.png" data-question="'.$message_EN.'" data-answer="'.$response2_EN.'" data-qualification="1" title="Respuesta buena" />
                                    <img src="https://devstec.digital/Assets/images/btn-bad.png" data-question="'.$message_EN.'" data-answer="'.$response2_EN.'" data-qualification="0" title="Respuesta mala" />
                                </div>';

                                

                    $arrResponse = array('html' => $html, 'token' => $token);
                    $typechat =   0;
                    
                    if(empty($_POST['typechat']) || !isset($_POST['typechat']) ){
                        $typechat =   0;  
                        
                    }else{
                        $typechat =   intval($_POST['typechat']);   
                        
                    }
			
                    
                    $iduser   = $this->model->consultarUsuario( $_POST['user'], 2);
                    $idwebcam   = $this->model->consultarUsuario($_POST['girl'], 1);                   
                    $request_log = $this->model->inserlog($idwebcam, 2, $iduser,$message_EN , $response2_EN, $arrSentimiento[$sent]['idemocion_image'],  0);
                    
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
     
        die();
        
    }
    
    public function loadHTMLNew(){
        echo '
                <div class="chat-icam-titleBar">
                    <div id="chat-icam-nameUser" class="chat-icam-bigTitle">'.$_POST['user'].'</div>
                    <div id="chat-icam-preferences">
                    </div>
                </div>
                <br>
                <div class="chat-icam-flexH chat-icam-alignT">
                    <div class="chat-icam-flex1 chat-icam-box">
                        <div class="chat-icam-titleTag">TRASLATE</div>
                        <p id="chat-icam-testSpanish" style="text-align:left">
                        </p>
                        <div class="chat-icam-toRight">
                            <img class="chat-icam-iconLanguage" src="https://devstec.digital/Assets/images/iconSpanish.png" title="Spanish" />
                        </div>
                    </div>

                    <div class="chat-icam-flex1 chat-icam-box">
                        <div class="chat-icam-titleTag">ORIGINAL</div>
                        <p id="chat-icam-textEnglish" style="text-align:left">
                        </p>
                        <div class="chat-icam-toRight">
                            <img class="chat-icam-iconLanguage" src="https://devstec.digital/Assets/images/iconEnglish.png" title="English" />
                        </div>
                    </div>

                    <div class="chat-icam-flex1">
                        <div class="chat-icam-backgroundColors">
                            <div id="chat-icam-titleExpression" class="chat-icam-bigTitle"></div>
                            <img loading="lazy" id="chat-icam-imageExpression" />
                            <div id="chat-icam-textExpression" class="chat-icam-text" style="font-size: 12px; font-weight:100"></div>
                        </div>
                    </div>
                </div>
                
                <div id="chat-icam-windowbot1" class="chat-icam-flexH">
                        
                </div>
                
                <div id="chat-icam-windowbot2" class="chat-icam-flexH">
                        
                </div>
                
                <div id="chat-icam-reload" class="chat-icam-button" data-text="">Volver a consultar</div>';
    }

    public function sentimiento()
    {
        if (!empty($_POST)) {
            
            if(empty($_POST['message']) || empty($_POST['girl'])){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
                
            }else{
              
              
                    $message_EN  =  strClean($_POST['message']);
                    /*$language = $this->detectLanguage($message_EN);
                    //var_dump($language);
                    
                    if($language != "EN"){
                        $message_EN = $this->translateTo($message_EN, 'EN')[0]['text'];
                    }*/
                    
                    $html = '';



                    $words = explode(" ", $message_EN);
                    $cadena ="";
                    $html2 = "";

                    $temp =0;
                $double = true;
                //dep($words[0]);
                $cat =  count($words)-1 ;
               

                for($i = 0; $i < count($words); ++$i) {
                    $request =0;
                    $requestcom = 0;
                    $requestabre = $this->model->consulAbre($words[$i]);
                    if(sizeof($requestabre) > 0 ){
                        
                        $words[$i] =   $requestabre[0]['palabra'];                   
                        $cadena.=$words[$i]." ";
                    }else{
                        $cadena.=$words[$i]." ";
                        //$html.=$word." ";
                    }  
                    $request = $this->model->consultDiccionario($words[$i]);
                    $temp = $i;
                   
                    if($i< $cat){
                        $i++;
                       // echo $words[$temp]."\n";
                       // echo $words[$i]."\n";
                        $word = $words[$temp]." ".$words[$i];
                       // echo $word;
                        $requestcom = $this->model->consultDiccionario($word);
                    }else{
                        $requestcom = $this->model->consultDiccionario("");
                    }
                   
                   
                    //print_r($requestcom);
                    if(sizeof($request) > 0 ){
                        //$cadena.=$request[0]['palabra'];
                        if($double){
                            $html2.='<span class="chat-icam-link" data-image="'.media().'/images/iconicam.png" data-text="'.$request[0]['significado_es'].'">'.$words[$temp].'</span> ';
                        }else{
                            $double = true;
                        }
                     
                       // echo sizeof($requestcom);
                    }else if(sizeof($requestcom) > 0){
                        $double = false;
                        //$cadena.=$word." ";
                        $html2.='<span class="chat-icam-link" data-image="'.media().'/images/iconicam.png" data-text="'.$requestcom[0]['significado_es'].'">'.$words[$temp]." ".$words[$i].'</span> ';
                      
                    } else{
                        if( $double){
                            $html2.=$words[$temp]." ";
                        }
                       
                    }
                    $i = $temp;
                }
                    $message_EN = $cadena;           
                    $response1_EN = "";
                    $response2_EN = "";
                    $response3_EN = "";
                        
                    $arrayTranslation = $this->translate(strtolower($message_EN), $response1_EN, $response2_EN, $response3_EN);

                    $message_ES = $arrayTranslation[0]['text'];
                    $response1_ES = $arrayTranslation[1]['text'];
                    $response2_ES = $arrayTranslation[2]['text'];
                    $response3_ES = $arrayTranslation[3]['text'];
                
                    // for feelings
                    $params=['message'=>  $message_EN ];
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
                
                
                    
                    $html .= '
                               
                               ';

                    $textExpression = $arrSentimiento[$sent]['descripcion'];
                    $titleExpression = $arrSentimiento[$sent]['emocion_es'];
                    $imageExpression = $arrSentimiento[$sent]['emocion_image'];
                    
                    if($textExpression == null){
                    	$textExpression = 'TE EMOCIONA';
                    }
                    
                    if($titleExpression == null){
                    	$titleExpression = 'SEXUAL';
                    }
                    
                    if($imageExpression == null){
                    	$imageExpression = 'img_1f0a6cb88fa4bc7547565cfc40ebc169.gif';
                    }
                    
                    $arrResponse = array('testSpanish' => $message_ES, 'textEnglish' => $html2,
                                        'titleExpression' => $titleExpression, 'textExpression' => $textExpression, 'imageExpression' => media().'/images/uploads/emocion/'.$imageExpression);
                    /*
                    $typechat =   0;
                    
                    if(empty($_POST['typechat']) || !isset($_POST['typechat']) ){
                        $typechat =   0;  
                        
                    }else{
                        $typechat =   intval($_POST['typechat']);   
                        
                    }
			
                    
                    $iduser   = $this->model->consultarUsuario( $_POST['user'], 2);
                    $idwebcam   = $this->model->consultarUsuario($_POST['girl'], 1);                   
                    $request_log = $this->model->inserlog($idwebcam, 2, $iduser,$message_EN , $response2_EN, $arrSentimiento[$sent]['idemocion_image'],  0);
                    */
                    
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
     
        die();
        
    }
    public function bot1()
    {
        if (!empty($_POST)) {
            
            if(empty($_POST['message']) || empty($_POST['girl'])){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
                
            }else{
              
              
                    $message_EN  =  strClean($_POST['message']);
                   
                    $html = '';

                  
                    
                    if(empty($_POST['token'])){
                        $token = $this->login($_POST['girl']);
                        $iduser   = $this->model->consultarUsuario($_POST['girl'], 1);
                        $request_log = $this->model->inserlog($iduser, 1, 0, "","",0,0 );
                
                        if($token == 'none'){
                            $this->signup($_POST['girl']);
                            $token = $this->login($_POST['girl']);
                        }
                    }else{
                        $token = $_POST['token'];
                       
                    }
                    
                    

                    $words = explode(" ", $message_EN);
                    $cadena ="";
                    $html2 = "";

                    $temp =0;
                $double = true;
                //dep($words[0]);
                $cat =  count($words)-1 ;
               

               
                    //$message_EN = $cadena;           
                    $response1_EN = "";
                    $response2_EN = $this->chat($token, $message_EN);
                    $response3_EN = "";
                        
                    $arrayTranslation = $this->translate(strtolower($message_EN), $response1_EN, $response2_EN, $response3_EN);

                    $message_ES = $arrayTranslation[0]['text'];
                    $response1_ES = $arrayTranslation[1]['text'];
                    $response2_ES = $arrayTranslation[2]['text'];
                    $response3_ES = $arrayTranslation[3]['text'];
                
                
                
                
                    
                    $html .= '
                    <div class="chat-icam-flex11 chat-icam-flexV" style="flex:15; align-items: center; justify-content: center;">

                            <div class="chat-icam-flex1 chat-icam-flexH chat-icam-alingT">
                                <img class="chat-icam-iconAnswer chat-icam-flex1" src="https://devstec.digital/Assets/images/iconSpanish.png" title="Spanish" />

                                <div id="chat-icam-answer2ES_1" class="chat-icam-text" style="flex:20; display: block; text-align:left">
                                    '.$response2_ES.'
                                </div>
                            </div>

                            <div class="chat-icam-flex1 chat-icam-flexH chat-icam-alingT">
                                <img class="chat-icam-iconAnswer chat-icam-flex1" src="https://devstec.digital/Assets/images/iconEnglish.png" title="Spanish" />

                                <div id="chat-icam-answer2EN_1" class="chat-icam-text" style="flex:20; font-weight: 100; display: block; text-align:left; color:#d7acff;">
                                    '.$response2_EN.'
                                </div>
                            </div>
                        </div>

                        <div class="chat-icam-flex1 chat-icam-flexV">

                            <img id="chat-icam-iconCopy_1" class="chat-icam-iconSend" src="https://devstec.digital/Assets/images/btn-send.png" data-text="'.$response2_EN.'" title="Copiar"/>

                            <img id="chat-icam-iconEdit_1" class="chat-icam-iconFeelBack" src="https://devstec.digital/Assets/images/pencil.png" data-response="'.$response2_EN.'" data-translate="'.$response2_ES.'" title="Editar"/>
                        </div>

                    </div>';

                                

                    $arrResponse = array('html' => $html, 'token' => $token);
                    $typechat =   0;
                    
                    if(empty($_POST['typechat']) || !isset($_POST['typechat']) ){
                        $typechat =   0;  
                        
                    }else{
                        $typechat =   intval($_POST['typechat']);   
                        
                    }
			
                    
                    $iduser   = $this->model->consultarUsuario( $_POST['user'], 2);
                    $idwebcam   = $this->model->consultarUsuario($_POST['girl'], 1);                   
                    $request_log = $this->model->inserlog($idwebcam, 2, $iduser,$message_EN , $response2_EN, 0,  0);
                    
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
     
        die();
        
    }

    public function bot2()
    {
        if (!empty($_POST)) {
            
            if(empty($_POST['message']) || empty($_POST['girl'])){
                $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
                
            }else{
              
              
                    $message_EN  =  strClean($_POST['message']);
                   
                    $html = '';

                  
                    
                    if(empty($_POST['token'])){
                        $token = $this->login($_POST['girl']);
                        $iduser   = $this->model->consultarUsuario($_POST['girl'], 1);
                        $request_log = $this->model->inserlog($iduser, 1, 0, "","",0,0 );
                
                        if($token == 'none'){
                            $this->signup($_POST['girl']);
                            $token = $this->login($_POST['girl']);
                        }
                    }else{
                        $token = $_POST['token'];
                       
                    }
                    
                    

                    $words = explode(" ", $message_EN);
                    $cadena ="";
                    $html2 = "";

                    $temp =0;
                $double = true;
                //dep($words[0]);
                $cat =  count($words)-1 ;
               

               
                    //$message_EN = $cadena;           
                    $response1_EN = "";
                    $response2_EN = $this->chat2($token, $message_EN);
                    $response3_EN = "";
                        
                    $arrayTranslation = $this->translate(strtolower($message_EN), $response1_EN, $response2_EN, $response3_EN);

                    $message_ES = $arrayTranslation[0]['text'];
                    $response1_ES = $arrayTranslation[1]['text'];
                    $response2_ES = $arrayTranslation[2]['text'];
                    $response3_ES = $arrayTranslation[3]['text'];
                
                
                
                
                    
                    $html .= '
                    
                    <div class="chat-icam-flex11 chat-icam-flexV" style="flex:15; align-items: center; justify-content: center;">

                            <div class="chat-icam-flex1 chat-icam-flexH chat-icam-alingT">
                                <img class="chat-icam-iconAnswer chat-icam-flex1" src="https://devstec.digital/Assets/images/iconSpanish.png" title="Spanish" />

                                <div id="chat-icam-answer2ES_2" class="chat-icam-text" style="flex:20; display: block; text-align:left">
                                    '.$response2_ES.'
                                </div>
                            </div>

                            <div class="chat-icam-flex1 chat-icam-flexH chat-icam-alingT">
                                <img class="chat-icam-iconAnswer chat-icam-flex1" src="https://devstec.digital/Assets/images/iconEnglish.png" title="Spanish" />

                                <div id="chat-icam-answer2EN_2" class="chat-icam-text" style="flex:20; font-weight: 100; display: block; text-align:left; color:#d7acff;">
                                    '.$response2_EN.'
                                </div>
                            </div>
                        </div>

                        <div class="chat-icam-flex1 chat-icam-flexV">

                            <img id="chat-icam-iconCopy_2" class="chat-icam-iconSend" src="https://devstec.digital/Assets/images/btn-send.png" data-text="'.$response2_EN.'" title="Copiar"/>

                            <img id="chat-icam-iconEdit_2" class="chat-icam-iconFeelBack" src="https://devstec.digital/Assets/images/pencil.png" data-response="'.$response2_EN.'" data-translate="'.$response2_ES.'" title="Editar"/>
                        </div>

                    </div>';

                                

                    $arrResponse = array('html' => $html, 'token' => $token);
                    $typechat =   0;
                    
                    if(empty($_POST['typechat']) || !isset($_POST['typechat']) ){
                        $typechat =   0;  
                        
                    }else{
                        $typechat =   intval($_POST['typechat']);   
                        
                    }
			
                    
                    $iduser   = $this->model->consultarUsuario( $_POST['user'], 2);
                    $idwebcam   = $this->model->consultarUsuario($_POST['girl'], 1);                   
                    $request_log = $this->model->inserlog($idwebcam, 2, $iduser,$message_EN , $response2_EN,0,  0);
                    
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

    public function chat2($token, $message){
        $url = "localhost:5001/chat2";
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
        $url = "https://api.deepl.com/v2/translate";

        $ch = curl_init($url);

        $post = array(
            'text' => $text1,
            'text' => $text2,
            'text' => $text3,
            'text' => $text4,
            'target_lang' => 'ES',
            'auth_key' => 'd15a8e8e-94a7-9e17-547d-9331610be21c');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                'text='.$text1.'&text='.$text2.'&text='.$text3.'&text='.$text4.'&target_lang=ES&auth_key=d15a8e8e-94a7-9e17-547d-9331610be21c');


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        header('Content-Type: text/html');

        $array = json_decode($server_output, true);
        
        curl_close ($ch);

        return $array['translations'];
    }
    
    function translateTo(String $text1, String $language){
        $url = "https://api.deepl.com/v2/translate";

        $ch = curl_init($url);

        $post = array(
            'text' => $text1,
            'target_lang' => $language,
            'auth_key' => 'd15a8e8e-94a7-9e17-547d-9331610be21c');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                'text='.$text1.'&target_lang='.$language.'&auth_key=d15a8e8e-94a7-9e17-547d-9331610be21c');


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        

        $server_output = curl_exec($ch);

        header('Content-Type: text/html');

        $array = json_decode($server_output, true);
        
        curl_close ($ch);
        
        return $array['translations'];
    }
    
    function onlyTranslate(){
        $array = $this->translateTo($_POST['message'], "EN");
        echo $array[0]['text'];
    }

   
}


