<div class="row">
	<div class="col-md-8" style="width: 100%;">
	<?php if( isset( $this->pageId->title ) ): ?>
		<h4>
			<a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; <a id="link_to_pages" href="<?php echo URL_BASE ?>admin/?id=pages"">Pages</a> &raquo; <?php echo stripslashes( $this->pageId->title ) ?>
		<a data-id="<?php echo $_GET['edit'] ?>" id="delete_page" class="btn btn-primary" href="javascript:void(0);">
          	<i class="glyphicon glyphicon-remove"></i> Delete page
          </a>
		</h4>
		<hr />
		
		<form action="" method="post" enctype="multipart/form-data" id="upload">
			
			<div class="form-group">
			<label>Title:</label>
			<input class="form-control" type="text" value="<?php echo stripslashes( $this->pageId->title ) ?>" name="title" id="title" />
			</div>
			
			<div class="form-group">
			<label>Content:</label>
			<textarea class="form-control" rows="10" id="content" name="content"><?php echo stripslashes( $this->pageId->content ) ?></textarea>
			</div>
			
			<input type="submit" name="submit" value="Save" id="button_update" class="btn btn-primary bt_update button_edit_pages" />
			<input type="hidden" name="id" value="<?php echo $_GET['edit'] ?>" />
			<p class="error_edit" id="errors"></p>
			<p class="success_edit" id="edit_success"></p>
		</form><!-- Form -->
	<?php
else:
	?>
	 <div class="alert alert-danger">
          	<i class="glyphicon glyphicon-remove"></i> There are no results
      </div>
	<?php endif; ?>
	</div>
</div><!-- End row -->
