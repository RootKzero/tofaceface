<!-- row of columns -->
  <div class="row">
  	<?php if( $_SESSION['id_admon'] == 1 ) : ?>
        <div class="col-lg-6">
          <h4><a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> 
          	<a href="<?php echo URL_BASE ?>admin/?id=users_admin">Users</a> &raquo; Add User</h4>
          <hr />
          
          <form action="" method="post" enctype="multipart/form-data" id="add_user_form">
          	
          	<div class="form-group">
				<label for="exampleInputEmail1">Name:</label>
				<input type="text" value="" name="name_admin" id="name_admin" class="form-control" />
         	</div>
         	
         	<div class="form-group">
				<label for="exampleInputEmail1">Username:</label>
				<input type="text" value="" name="user_admin" id="user_admin" class="form-control" />
         	</div>
         	
			<div class="form-group">
				<label for="exampleInputEmail1">Password:</label>
				<input type="password" value="" name="pass_new" id="pass_new" class="form-control" />
         	</div>
         	
         	<div class="form-group">
				<label for="exampleInputEmail1">Repeat Password:</label>
				<input type="password" value="" name="repeat_pass" id="repeat_pass" class="form-control" />
         	</div>
         	
			<input type="submit" name="submit" value="Save" id="button_update" class="btn btn-primary bt_update button_new_admin" />
			
			<div class="alert alert-success alerts_boxes" id="success_add"></div>
			<div class="alert alert-danger alerts_boxes"  id="error_add"></div>
			
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
<?php

	  else:
		  ?>
		  <div class="alert alert-warning">
          	<i class="glyphicon glyphicon-warning-sign"></i> You do not have permission to access this section
      </div>
		  <?php
		   endif; ?>
      </div><!-- row -->
      