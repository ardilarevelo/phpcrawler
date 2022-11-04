<?php

// No direct access
defined('_DIACCESS') or die;

// Set the inputs
$data = $_POST["data"];
$url = isset($data["url"]) ? $data["url"] : "";
$maxPages = isset($data["maxPages"]) ? $data["maxPages"] : 10;

// Create the Crawler
$crawler = new crawler($url,$maxPages);

// Check is valid URL
if($crawler->isValidURL()){
    
    // Array to store the data
    $response = array();
    $response["id"] = date("YmdHis"); // generate the request ID
    
    // Create connection
    $crawler->connect();
    // Request the URL
    $crawler->request();
    
    // Store the initial response
    $response["root"] = $url;
    $response["http_code"] = $crawler->getInfo("http_code");
    
    // Check the response and store more info
    if($crawler->getInfo("http_code") === 200){
        // Get info about the response
        $response["total_time"] = $crawler->getInfo("total_time");
    }
    
    // Save the data
    $crawler->saveResponse($response);
    
    site::redirect("crawler/result");
}else{
    site::setSessionMessage("The URL is not valid","error");
    site::redirect("/");
}


?>
