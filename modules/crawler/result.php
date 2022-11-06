<?php

// No direct access
defined('_DIACCESS') or die;

// Get the ID
$id = isset($site["action"]) ? $site["action"] : "";

// Read result according the ID
$page = new page($id);
// If page was processed
if($page->getError() == ""){
    $site["title"] = "Scan: ".$page->json["root"];
    // Get stats
    $stats = $page->getStats();
}else{
    site::setSessionMessage("ID not valid","error");
    site::redirect("/");
}

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
		<a href="/crawler/json/<?php echo $id; ?>" class="btn btn-primary" target="_blank">Click here to see all data in json format.</a>
		<br /><br />
		<ul>
			<li><strong>Number of pages requested: </strong><?php echo $stats["maxPages"]; ?></li>
			<li><strong>Number of pages crawled: </strong><?php echo $stats["numScan"]; ?></li>
			<li><strong>Number of a unique images: </strong><?php echo $stats["numUniqueImages"]; ?></li>
			<li><strong>Number of unique internal links: </strong><?php echo $stats["numInternalLinks"]; ?></li>
			<li><strong>Number of unique external links: </strong><?php echo $stats["numExternalLinks"]; ?></li>
			<li><strong>Average page load in seconds: </strong><?php echo $stats["avgLoadTime"]; ?></li>
			<li><strong>Average word count: </strong><?php echo $stats["avgWords"]; ?></li>
			<li><strong>Average title length: </strong><?php echo $stats["avgTitle"]; ?></li>
		</ul>
	</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
    	<div class="panel panel-default">
            <div class="panel-heading">
                Details
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th style="width:25%">URL</th>
                            <th>Type</th>
                            <th>Scanned</th>
                            <th>HTTP status Code</th>
                            <th>Source<br/></th>
                            <th>Ocurrences<br/><small>(entry point + deep)</small></th>
                            <th>Load Time</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
                            if(isset($page->json["UniqueLinks"])){
                                foreach($page->json["UniqueLinks"] as $link){
                        ?>
                        <tr class="odd gradeX<?php echo isset($link["scan"]["http_code"]) && $link["scan"]["http_code"] === 200 ? " success" : "" ;?>">
                            <td><?php echo $link["href"]; ?></td>
                            <td class="center"><?php echo $link["type"]; ?></td>
                            <td class="center"><?php echo isset($link["scan"]) ? "Yes" : "No"; ?></td>
                            <td class="center"><?php echo isset($link["scan"]["http_code"]) ? $link["scan"]["http_code"] : "-"; ?></td>
                            <td class="center"><?php echo $link["source"] == "root" ? "Entry Point" : "Deep"; ?></td>
                            <td class="center"><?php echo $link["occurrences"]; ?></td>
                            <td class="center"><?php echo isset($link["scan"]["total_time"]) ? $link["scan"]["total_time"] : "-"; ?></td>
                            <td class="center"><?php echo isset($link["scan"]["title"]) ? $link["scan"]["title"] : "-"; ?></td>
                        </tr>
                        <?php
                                }
                            }else{
                        ?>
                        <tr class="odd gradeX">
                            <td colspan="6">Not data</td>
                        </tr>
                        <?php } ?>
    				</tbody>
    			</table>
    			<!-- /.table-responsive -->
    		</div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
	</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<?php
    // load the footer
    require_once(BASE_PATH."footer-admin.php");
?>