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
                CURLOPT_URL => 'http://192.168.1.68:5000',
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

                $array = $array[0];


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






              

                $words = explode(" ", $message);
                $result = [];

                $html= '<div id="btnClose"></div>
                <div class="titleBar">
                    <div id="preferences">
                        <span>BDSM</span> | <span>Feet</span> | <span>Lesbian</span>
                    </div>
                </div>
                <br>
                <div class="flexH">
                    <div class="flex2">
                        <div class="box">
                            <div class="titleTag">TRASLATE</div>
                            <p id="testSpanish">';

                foreach($words as $word){
                    $request =0;
                    $request = $this->model->consultDiccionario($word);
                    //Consultar base de datos
                    // $dts es la respuesta de la consulta
                 
            

                    if(sizeof($request) > 0 ){
                        $html.='<span class="link" data-image="" data-text="'.$request[0]['significado_es'].'">'.$word.'</span> ';

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
                foreach($words as $word){
                    $request =0;
                    $request = $this->model->consultDiccionario($word);
                    //Consultar base de datos
                    // $dts es la respuesta de la consulta
                 
            

                    if(sizeof($request) > 0 ){
                        $html.='<span class="link" data-image="" data-text="'.$request[0]['significado_es'].'">'.$word.'</span> ';

                    }else{
                        $html.=$word." ";
                    }                                     
                   
                }              
                
                
                $html.='</p>
                <div class="toRight">
                    <img class="iconLanguage" src="'. media() . '/images/uploads/emocion/'.$arrSentimiento[$sent]['emocion_image'] .'" title="English" />
                </div>
            </div>
        </div>

        <div class="flex1">
            <img id="imageExpression" src="https://creamox.com/images_icam/bdsm.jpg" />
        </div>
        
    </div>

    <div id="answers">
        <div class="itemAnswer">
            <div class="text">
                Por supuesto bebé estaré encantada de mostrarte en pvt
            </div>
            <br>
            <div class="titleGreen">
                Off course baby i ll be happy to show you on pvt
            </div>
            <img class="iconSend" src="https://creamox.com/images_icam/btn-send.png" data-text="Off course baby i ll be happy to show you on pvt" title="Send"/>
        </div>

        <div class="itemAnswer">
            <div class="text">
                Si me gustaría ser azotada, vamos a pvt
            </div>
            <br>
            <div class="titleGreen">
                Yes i like to be spanked, let s go pvt
            </div>
            <img class="iconSend" src="https://creamox.com/images_icam/btn-send.png" data-text="Yes i like to be spanked, let s go pvt" title="Send"/>
        </div>

        <div class="itemAnswer">
            <div class="text">
                Realmente me excita ser sádica, déjame mostrarte en pvt
            </div>
            <br>
            <div class="titleGreen">
                it really turns me on to be sadistic, let me show you
            </div>
            <img class="iconSend" src="https://creamox.com/images_icam/btn-send.png" data-text="it really turns me on to be sadistic, let me show you" title="Send"/>
        </div>
    </div>';

          
             

               
             
              
           
    
                    $arrResponse = array('status' => true, 'msg' => 'ok', 'html'=>$html ); 
            
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
     
        die();
    }

}



