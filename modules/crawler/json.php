<?php

// No direct access
defined('_DIACCESS') or die;

// Get the ID
$id = isset($site["action"]) ? $site["action"] : "";

// Read result according the ID
$page = new page($id);
// If page was processed
if($page->getError() == ""){
    $response = json_encode($page->json);
    header('Content-Type: application/json; charset=utf-8');
    echo $response;
    die;
}else{
    site::setSessionMessage("ID not valid","error");
    site::redirect("/");
}
?>