<?php

// No direct access
defined('_DIACCESS') or die;

$site["title"] = "Set the URL";

?>
<script type="text/javascript">
	$(function() {
		$("#btnSubmitScan").click(function() {
			$("#btnSubmitScan").hide();
			$("#btnAjaxLoader").show();
		});
	});
</script>
<form role="form" method="post" action="/crawler/scan" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $site["title"]; ?></h4>
    </div>
    <div class="modal-body">
        <div class="form-group has-success">
            <label class="control-label" for="inputSuccess">URL:</label>
            <input type="text" name="data[url]" class="form-control" id="inputSuccess">
        </div>
        <div class="form-group">
        	<label>Pages to scan</label>
            <select name="data[maxPages]" class="form-control">
            	<?php for($i=100;$i>0;$i--){ ?>
            	<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            	<?php } ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="btnSubmitScan" class="btn btn-primary">Scan</button>
        <span id="btnAjaxLoader" style="display:none;"><img src="template/images/admin/ajax-loader.gif" width="24" height="24" /></span>
    </div>
</form>