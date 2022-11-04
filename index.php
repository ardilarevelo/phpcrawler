<?php

session_start();

// Allow access
define('_DIACCESS', 1);

// Config files
require_once (dirname(__FILE__)."/config.php");
require_once (dirname(__FILE__)."/init.php");

// Get the URI to route the request
$url = substr($_SERVER["REQUEST_URI"],1);

// Ignore GET params
if(strpos($url,"?") !== false){
	$url = substr($url,0,strpos($url,"?"));
}

// Split the uri in module, section and action to route the request
if($url != ""){
	$exp_url = explode("/",$url);
	foreach($exp_url as $key => $e_url){
		if($key == 0){
			$_REQUEST["module"] = $e_url;
		}elseif($key == 1){
			$_REQUEST["section"] = $e_url;
		}elseif($key == 2){
			$_REQUEST["action"] = $e_url;
		}else{
			break;
		}
	}
}

// Set route request
$site["module"] = isset($_REQUEST["module"]) ? $_REQUEST["module"] : "start"; // start: default entry point
$site["section"] = isset($_REQUEST["section"]) ? $_REQUEST["section"] : "";
$site["action"] = isset($_REQUEST["action"]) ? $_REQUEST["action"] : "";

// Load the main file for the specific module
$main_module = dirname(__FILE__)."/modules/".$site["module"]."/main.php";
if(file_exists($main_module)){
	require_once ($main_module);
}else{
    // Show 404 error when the module not exists
	require_once (dirname(__FILE__)."/error_404.php");
}
?>