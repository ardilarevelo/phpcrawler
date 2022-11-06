<?php

// No direct access
defined('_DIACCESS') or die;

// Disable the time limit
ini_set('max_execution_time', 0);

// Set the inputs
$data = $_POST["data"];
$url = isset($data["url"]) ? $data["url"] : "";
$maxPages = isset($data["maxPages"]) && intval($data["maxPages"]) > 0 ? intval($data["maxPages"]) : 10;

// Create the Crawler
$crawler = new crawler($url,$maxPages);

// Check is valid URL
if($crawler->isValidURL()){
    
    // Create an ID for this request
    $response_Id = date("YmdHis");
    // Create connection
    $crawler->connect();
    // Request the URL
    $crawler->request();
    // Save the data
    $crawler->saveResponse($response_Id);
    
    // Check if the URL reponse
    if($crawler->getInfo("http_code") !== 200){
        site::setSessionMessage("The URL is not available (Response: ".$crawler->getInfo("http_code").")","error");
        site::redirect("/");
    }
    
    // Process the page
    $page = new page($response_Id);
    $page->process();
    // Follow and scan the internal links
    $page->processLinks($crawler,$response_Id);
    // Merge root(entry point) and internal links to identify uniques links and images
    $page->mergeRootAndInternalLinks();
    // Save the json data with the result
    $page->saveJson();

    // Redirect to check the result
    site::redirect("crawler/result/".$response_Id);
}else{
    site::setSessionMessage("The URL is not valid","error");
    site::redirect("/");
}


?>
