<?php

// No direct access
defined('_DIACCESS') or die;

$site["title"] = "Result";

// load the header
require_once (BASE_PATH."header-admin.php");
?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $site["title"]; ?></h1>
	</div>
	<!-- /.col-lg-12 --> 
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		Aqui va la respuesta
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php
    // load the footer
    require_once(BASE_PATH."footer-admin.php");
?>