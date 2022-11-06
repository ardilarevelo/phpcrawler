<?php

// No direct access
defined('_DIACCESS') or die;

$site["title"] = "Previous URLs scanned";

$files = scandir(BASE_PATH."data/", 1);

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
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>URL</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(count($files) > 3){
					    foreach($files as $file){
					        if($file != '..' && $file != '.' && $file != 'index.html'
					            && strpos($file,'_') === false && strpos($file,'.html') > 0){
					            list($id,$ext) = explode(".",$file);
					            // Read result according the ID
					            $page = new page($id);
					?>
						<tr>
							<td><?php echo $id; ?></td>
							<td><?php echo $page->getError() == "" ? $page->json["root"] : "-"; ?></td>
							<td><a href="/crawler/result/<?php echo $id; ?>" title="See details"><i class="fa fa-money fa-fw"></i></a></td>
						</tr>
						<?php
					           }
                            }
						?>
					<?php
						}else{
					?>
						<tr><td colspan="3" align="center">No previous files</td></tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<!-- /.table-responsive -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php require_once(BASE_PATH."footer-admin.php"); ?>