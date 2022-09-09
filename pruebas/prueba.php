<?php 


$message  = "hola mundo";


         

         
$params=['message'=>  $message];
$defaults = array(
CURLOPT_URL => 'http://192.168.1.68:5000',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_POST => true,
CURLOPT_POSTFIELDS => $params,
);
$ch = curl_init();
curl_setopt_array($ch, $defaults);

$result = curl_exec($ch);

curl_close($ch);
//$str = substr($result, 1, -1);
//print_r($result);


$array = json_decode($result, true);
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

print_r($array[$max]);