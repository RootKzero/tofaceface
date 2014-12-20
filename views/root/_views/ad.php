<!-- row of columns -->
  <div class="row">
  	<div class="col-md-8" style="width: 100%;">
          <h4>
          	<a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; Advertising </h4>
          <hr />
          
          <form action="" method="post" enctype="multipart/form-data" id="upload">
					
			<div class="form-group">
         	<label for="exampleInputEmail1">Code HTML/Adsense:</label>
         	<textarea  id="ad" class="form-control" rows="3" name="ad"><?php echo stripslashes( $this->settings->ad ); ?></textarea>
         	</div>
			<input type="submit" name="submit" value="Save" id="button_update" class="btn btn-primary bt_update button_ad" />
			
			<p class="error_edit" id="errors"></p>
			<p class="success_edit" id="edit_success"></p>
		 </form><!-- Form -->
    </div>
</div><!-- row -->