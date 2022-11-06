<?php

// No direct access
defined('_DIACCESS') or die;

// Class to manage the crawler
class crawler{
    
    private $url = "";
    private $maxPages = 0;
    private $error = array();
    private $ch;
    private $connResponse = array();
    private $htmlString = "";
    private $scheme = "";
    private $host = "";
    private $baseURL = "";
    
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
            $url = curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);
            $url_parts = parse_url($url);
            $this->scheme = $url_parts['scheme'];
            $this->host = $url_parts['host'];
            $this->baseURL = $this->scheme.'://'.$this->host;
        }
    }
    
    // Get max pages to scan
    public function getMaxPagesToScan(){
        return $this->maxPages;
    }
    
    // Get HTML
    public function getHTML(){
        return $this->htmlString;
    }
    
    // Get Schema
    public function getScheme(){
        return $this->scheme;
    }
    
    // Get Host
    public function getHost(){
        return $this->host;
    }
    
    // Get base url
    public function getBaseURL(){
        return $this->baseURL;
    }
    
    // Get request info
    public function getInfo($type){
        return isset($this->connResponse[$type]) ? $this->connResponse[$type] : "";
    }
    
    // Save the data
    public function saveResponse($id){
        
        // Save the specific details
        $response = array("id" => $id);
        
        // Store the initial response
        $response["root"] = $this->url;
        $response["maxPages"] = $this->maxPages;
        $response["http_code"] = $this->getInfo("http_code");
        $response["scheme"] = $this->getScheme();
        $response["host"] = $this->getHost();
        $response["baseURL"] = $this->getBaseURL();
        
        // Get info about the response
        $response["total_time"] = $this->getInfo("total_time");
        
        // Store the HTML
        $response["htmlString"] = $response["id"].".html";
        
        // Save the content html in file
        $fp = fopen(BASE_PATH."data/".$response["id"].".html","w");
        fwrite($fp,$this->getHTML());
        fclose($fp);
        
        // Save the response in json file to have in local
        $fp = fopen(BASE_PATH."data/".$response["id"].".json","w");
        fwrite($fp,json_encode($response));
        fclose($fp);
        
        return $response["id"].".json";
    }
}

