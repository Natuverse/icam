<?php

$message  = "hello baby";

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

print_r($array['traduccion']['text']);

?>