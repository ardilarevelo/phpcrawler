<?php

// No direct access
defined('_DIACCESS') or die;

// Set the web page title
$site["title"] = "Admin panel";

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
	<?php foreach($admin_menu as $admin_m){ ?>
	<div class="col-lg-4">
		<div class="panel <?php echo $admin_m['panel_class']; ?>">
			<div class="panel-heading"> <i class="fa <?php echo $admin_m['class']; ?> fa-fw"></i> <?php echo $admin_m['name']; ?> </div>
			<div class="panel-body">
				<p><?php echo $admin_m['description']; ?></p>
			</div>
			<div class="panel-footer"> <a href="<?php echo $admin_m['panel_url']; ?>"<?php echo isset($admin_m['panel_attributes']) ? $admin_m['panel_attributes'] : ""; ?>><?php echo $admin_m['panel_call']; ?></a> </div>
		</div>
	</div>
	<!-- /.col-lg-4 -->
	<?php } ?>
	
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
	
</div>
<!-- /.row -->
<?php
    // load the footer
    require_once(BASE_PATH."footer-admin.php");
?>