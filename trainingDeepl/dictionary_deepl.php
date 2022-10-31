<?php

class dictionary_deepl{

    function addWords($file_path){
        $myfile = fopen($file_path, "r") or die("Unable to open file!");
        
        while(!feof($myfile)) {
            var_dump($this->sendWord(fgets($myfile)));
        }
        
        fclose($myfile);
    }
    
    function sendWord($word){
        $url = "https://api.deepl.com/v2/glossaries";

        $ch = curl_init($url);

        $header = array(
            'User-Agent: YourApp/1.2.3',
            'Authorization: DeepL-Auth-Key d15a8e8e-94a7-9e17-547d-9331610be21c',
            'Accept: text/tab-separated-values');
        
        $post = array(
            'name' => 'icamGlossary',
            'entries' => 'thx%09gracias\npvt%09privado',
            'target_lang' => 'ES',
            'source_lang' => 'EN',
            'entries_format' => 'tsv',
            'auth_key' => 'd15a8e8e-94a7-9e17-547d-9331610be21c');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                'name=icamGlossary&entries=PVT%09privadi&source_lang=EN&target_lang=ES&entries_format=tsv&auth_key=d15a8e8e-94a7-9e17-547d-9331610be21c');

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        header('Content-Type: text/html');

        $array = json_decode($server_output, true);
        
        curl_close ($ch);

        return $array;
    }
    
    function listGlossaries(){
        $url = "https://api.deepl.com/v2/glossaries";

        $ch = curl_init($url);

        $header = array(
            'User-Agent: YourApp/1.2.3',
            'Authorization: DeepL-Auth-Key d15a8e8e-94a7-9e17-547d-9331610be21c');
        
        //curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //curl_setopt($ch, CURLOPT_POSTFIELDS,
               // 'DeepL-Auth-Key d15a8e8e-94a7-9e17-547d-9331610be21c&User-Agent=YourApp/1.2.3');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        header('Content-Type: text/html');

        $array = json_decode($server_output, true);
        
        curl_close ($ch);

        return $array;
    }
}



$dic = new dictionary_deepl();

//var_dump($dic->listGlossaries());
$dic->addWords("dictionary.txt");

?>