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
    list($stats,$donutChart_HTTPCode,$areaCharLink) = $page->getStats();
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

<!-- Morris Charts CSS -->
<link href="<?php echo BASE_URL; ?>/template/js-admin/morrisjs/morris.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo BASE_URL; ?>/template/js-admin/raphael/raphael.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/template/js-admin/morrisjs/morris.min.js"></script>
<script type="text/javascript">
$(function() {
	Morris.Donut({
		element: 'morris-donut-chart',
		data: <?php echo json_encode($donutChart_HTTPCode); ?>,
		resize: true,
		colors: ['#3c763d', '#31708f', '#8a6d3b', '#a94442']
	});
	
	Morris.Bar({
        element: 'morris-area-chart-time',
        data: <?php echo json_encode($areaCharLink); ?>,
        xkey: 'idx',
        ykeys: ['total_time'],
        labels: ['Total Time'],
        pointSize: 2,
        hideHover: 'auto',
        axes: false,
        barColors: ['#a94442'],
        resize: true
    });
    
    Morris.Bar({
        element: 'morris-area-chart-numWords',
        data: <?php echo json_encode($areaCharLink); ?>,
        xkey: 'idx',
        ykeys: ['numWords'],
        labels: ['Words in content'],
        pointSize: 2,
        hideHover: 'auto',
        axes: false,
        barColors: ['#31708f'],
        resize: true
    });
    
    Morris.Bar({
        element: 'morris-area-chart-numWordsTitle',
        data: <?php echo json_encode($areaCharLink); ?>,
        xkey: 'idx',
        ykeys: ['numWordsTitle'],
        labels: ['Words in title'],
        pointSize: 2,
        hideHover: 'auto',
        axes: false,
        barColors: ['#8a6d3b'],
        resize: true
    });
});
</script>

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
		<div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    HTTP Code
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-donut-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Time Response (seconds)
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-area-chart-time"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
	</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Words in Content
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-area-chart-numWords"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-6 -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Words in Title
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-area-chart-numWordsTitle"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-6 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
    	<div class="panel panel-default">
            <div class="panel-heading">
                Details of internal links
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
            	<div class="table-scroller">
                <table width="100%" class="table table-striped table-bordered table-hover standings" id="dataTables-example">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col" style="width:15%">URL</th>
                            <th scope="col">Type</th>
                            <th scope="col">Scanned</th>
                            <th scope="col">HTTP status Code</th>
                            <th scope="col">Source<br/></th>
                            <th scope="col">Ocurrences<br/><small>(entry point + deep)</small></th>
                            <th scope="col">Load Time</th>
                            <th scope="col">Title</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
                            if(isset($page->json["UniqueLinks"])){
                                $contScans = 0;
                                foreach($page->json["UniqueLinks"] as $key => $link){
                                    $colorTR = "";
                                    if(isset($link["scan"])){
                                        $contScans ++;
                                        $idURL = $contScans;
                                        $scan = "Yes";
                                    }else{
                                        $idURL = "-";
                                        $scan = "No";
                                    }
                                    if(isset($link["scan"]["http_code"]) && $link["scan"]["http_code"] === 200){
                                        $colorTR = " success";
                                    }elseif(isset($link["scan"]["http_code"]) && $link["scan"]["http_code"] === 404){
                                        $colorTR = " danger";
                                    }elseif(isset($link["scan"]["http_code"]) && $link["scan"]["http_code"] === 301){
                                        $colorTR = " info";
                                    }
                        ?>
                        <tr class="odd gradeX<?php echo $colorTR; ?>">
                            <th scope="row"><?php echo $idURL; ?></th>
                            <td><?php echo $link["href"]; ?></td>
                            <td class="center"><?php echo $link["type"]; ?></td>
                            <td class="center"><?php echo $scan; ?></td>
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
                            <td colspan="9">Not data</td>
                        </tr>
                        <?php } ?>
    				</tbody>
    			</table>
    			</div>
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