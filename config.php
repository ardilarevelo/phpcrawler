<?php

// No direct access
defined('_DIACCESS') or die;

// Path
define("BASE_PATH",dirname(__FILE__)."/");
define("BASE_PATH_CLASS",BASE_PATH."class/");
define("BASE_URL","http://".$_SERVER["HTTP_HOST"]);

// Global
define("SITE_TAG","Crawler");
?>