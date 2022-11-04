<?php

// No direct access
defined('_DIACCESS') or die;

$site["title"] = "Error";

// load the header
require_once (BASE_PATH."header-admin.php");
?>
<div class="row text-center">
	<h1>Not found</h1>
</div>
<?php
// load the footer
	require_once (BASE_PATH."footer-admin.php");
	die();
?>