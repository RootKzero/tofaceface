 <!-- row of columns -->
  <div class="row">
  	<div class="col-lg-6">
  		<h4>Statistics registered users</h4>
  		<hr />
  		<div id="chart_div" style="width: 100%; height: 500px;"></div>
  	</div>
  	
  	<div class="col-lg-6">
  		<h4>Statistics registered users - Profiles</h4>
  		<hr />
  		<div id="piechart" style="width: 100%; height: 500px;"></div>
  	</div> 	
</div>

  	<div class="row">
        <div class="col-lg-6">
          <h4>General Settings &raquo; <a target="_blank" href="<?php echo URL_BASE; ?>">View Page <i class="glyphicon glyphicon-new-window"></i></a></h4>
          <hr />
         <form action="" method="post" enctype="multipart/form-data" id="upload">
         
         	<div class="form-group">
         		<label for="exampleInputEmail1">Name Site</label>
         		<input type="text" value="<?php echo stripslashes( $this->settings->title ); ?>" name="title" id="title" class="form-control">
         	</div>
         	
         	<div class="form-group">
         	<label for="exampleInputEmail1">Keywords</label>
         	<input type="text" value="<?php echo stripslashes( $this->settings->keywords ); ?>" name="Keywords" id="Keywords" class="form-control">
         	</div>
         	
         	<div class="form-group">
         	<label for="exampleInputEmail1">Message length</label>
         	<input class="form-control" type="text" value="<?php echo $this->settings->message_length; ?>" placeholder="Eg: 140" name="message_length" id="message_length">
         	</div>
         	
         	<div class="form-group">
         	<label for="exampleInputEmail1">Post length</label>
         	<input class="form-control" type="text" placeholder="Eg: 140" value="<?php echo $this->settings->post_length; ?>" name="post_length" id="post_length">
         	</div>
         	
         	<div class="form-group">
         	<label for="exampleInputEmail1">Description</label>
         	<textarea  id="Description" class="form-control" rows="3" name="Description"><?php echo stripslashes( $this->settings->description ); ?></textarea>
         	</div>
         	
         	 <button type="submit" id="button_update" class="btn btn-primary button_save_general">Save</button>
         	 
         	 <p class="error_edit" id="errors"></p>
         	 <p class="success_edit" id="edit_success"></p>
			
         	</form>
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