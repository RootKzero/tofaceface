<div class="row">
	<div class="col-md-8" style="width: 100%;">
		
		<h4>
			<a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; 
			<a href="<?php echo URL_BASE ?>admin/?id=pages"">Pages</a> &raquo; Add page
		</h4>
		<hr />
		
		<form action="" method="post" enctype="multipart/form-data" id="upload">
			
			<div class="form-group">
			<label>Title:</label>
			<input class="form-control" type="text" value="" name="add_title" id="add_title" />
			</div>
			
			<div class="form-group">
			<label>Url <small style="color: #999;">(Link which can access the page)</small></label>
			<input class="form-control" type="text" value="" name="add_url" id="add_url" />
			</div>
			
			<div class="form-group">
			<label>Content:</label>
			<textarea class="form-control" rows="10" id="add_content" name="add_content"></textarea>
			</div>
			
			<input type="submit" name="submit" value="Save" id="button_update" class="btn btn-primary bt_update button_add_pages" />
			<p class="error_edit" id="errors"></p>
			<p class="success_edit" id="edit_success"></p>
		</form><!-- Form -->
	</div>
</div><!-- End row -->
