<?php

// No direct access
defined('_DIACCESS') or die;

$include = "profile.php";

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