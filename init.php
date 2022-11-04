<?php

// No direct access
defined('_DIACCESS') or die;

// Load class
function my_own_autoload($class_name) {
	require_once BASE_PATH_CLASS . strtolower($class_name) . '.php';
}

spl_autoload_register('my_own_autoload');

?>