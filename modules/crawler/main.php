<?php

// No direct access
defined('_DIACCESS') or die;

$include = "";

// Route the request to the specific section
if(isset($_REQUEST["section"]) && $_REQUEST["section"] == "scan"){
	$include = "scan.php";
}elseif(isset($_REQUEST["section"]) && $_REQUEST["section"] == "result"){
	$include = "result.php";
}else{
    // Form to set the URL to create the crawler
	$include = "form.php";
}

// Load the section file
if($include != ""){
    if(file_exists(dirname(__FILE__)."/".$include)){
        require_once(dirname(__FILE__)."/".$include);
        exit;
    }else{
        // Show 404 error when the section not exists
        require_once (BASE_PATH."error_404.php");
    }
}else{
    site::redirect(BASE_URL);
}
	
?>