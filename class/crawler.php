<?php

// No direct access
defined('_DIACCESS') or die;

// Class to manage the admin menu
class crawler{
    
    private $url = "";
    private $maxPages = 0;
    private $error = array();
    private $ch;
    private $connResponse = array();
    private $htmlString = "";
    
    // Constructor to define the URL
    public function __construct($url,$maxPages){
        $this->url = $url;
        $this->maxPages = $maxPages;
    }
    
    // Check if the string is a valid URL
    public function isValidURL(){
        if(preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$this->url)){
            return true;
        }
        else{
            return false;
        }
    }
    
    // Create the connection
    public function connect(){
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    }
    
    // Close connection
    public function disconnect(){
        curl_close($this->ch);
    }
    
    // Request url
    public function request(){
        $this->htmlString = curl_exec($this->ch);
        if($this->htmlString != ""){
            $this->connResponse = curl_getinfo($this->ch);
        }
    }
    
    // Get HTML
    public function getHTML(){
        return $this->htmlString;
    }
    
    // Get request info
    public function getInfo($type){
        return isset($this->connResponse[$type]) ? $this->connResponse[$type] : "";
    }
    
    // Save the data
    public function saveResponse($result){
        $result["htmlString"] = $this->getHTML();
        $fp = fopen(BASE_PATH."data/".$result["id"].".json","w+");
        fwrite($fp,json_encode($result));
        fclose($fp);
    }
}

