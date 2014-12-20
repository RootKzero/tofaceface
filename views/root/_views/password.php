<!-- row of columns -->
  <div class="row">
        <div class="col-lg-6">
          <h4><a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; Change Password</h4>
          <hr />
          
          <form action="" method="post" enctype="multipart/form-data" id="upload">
	
			<div class="form-group">
				<label for="exampleInputEmail1">New Password:</label>
				<input type="password" value="" name="pass" id="pass" class="form-control" />
         	</div>
         	
			<input type="submit" name="submit" value="Save" id="button_update" class="btn btn-primary bt_update button_pass" />
			
			<p class="error_edit" id="errors"></p>
			<p class="success_edit" id="edit_success"></p>
		</form><!-- Form -->

        </div><!-- col-lg-6 -->
       
        <div class="col-lg-6">
          <h4>Last Users &raquo;</h4>
          
          <?php if( $this->countUser == 0 ) { ?>
          <div class="alert alert-info">
          	<i class="glyphicon glyphicon-info-sign"></i> There are no results
      </div>
      <?php }// 
      
      if( $this->countUser != 0 ) { ?>
      
          <ul class="list-inline">
          	<?php foreach( $this->users as $a ) { ?>
          	<li>
          		<a href="admin/?info_user=<?php echo $a['id'] ?>" title="<?php echo stripslashes( $a['name'] )." @".$a['username'] ?>">
          			<img class="img-thumbnail img-responsive" src="<?php echo URL_BASE ?>public/avatar/<?php echo $a['avatar'] ?>" />
          		</a>
          	</li>
          	  <?php }//  ?>
          </ul>
          <p><a class="btn btn-primary" href="<?php echo URL_BASE ?>admin/?id=users">Go to Users  &raquo;</a></p>
          
          <?php }//  ?>
       </div><!-- col-lg-6 -->

      </div><!-- row -->
      