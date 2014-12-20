<!-- row of columns -->
  <div class="row">
  	
  	 <?php 
  	 
  	 /*************
	 * Mode
	 * ***********
	 */
	if( $this->infoUser->mode == 1 ) {
		$mode = 'Public';
	} else {
		$mode = 'Private';
	}
  	 
  	 if( $this->infoUser->name != '' ) : ?>
  	 	
        <div class="col-xs-4">
          <h4><a href="<?php echo URL_BASE ?>admin/"><i class="glyphicon glyphicon-home"></i></a> &raquo; <a href="<?php echo URL_BASE ?>admin/?id=users">Users</a> &raquo; <?php echo stripslashes( $this->infoUser->name  ) ?></h4>
          <hr />
          <?php if( file_exists( 'public/avatar/large_'.$this->infoUser->avatar ) ) : ?>
         <img class="img-thumbnail img-responsive" src="<?php echo URL_BASE ?>public/avatar/large_<?php echo $this->infoUser->avatar ?>" />
        <?php
else:
	?>
	<img class="img-thumbnail img-responsive" src="<?php echo URL_BASE ?>public/avatar/<?php echo $this->infoUser->avatar ?>" />
	<?php
         endif; ?>
        
        </div><!-- col-lg-6 -->
        
        <div class="col-xs-8">
          <h4>User information</h4>
          <hr />
         <dl>
         	<?php if( $this->infoUser->name != '' ) : ?>
         	<dt>Name: <span style="font-weight: normal"><?php echo stripslashes( $this->infoUser->name  ); ?></span></dt>
         	<?php endif; ?>
         	
         	<?php if( $this->infoUser->username != '' ) : ?>
         	<dt>Username: <span style="font-weight: normal">@<?php echo $this->infoUser->username; ?></span></dt>
         	<?php endif; ?>
         	
         	<?php if( $this->infoUser->location != '' ) : ?>
         	<dt>Location: <span style="font-weight: normal"><?php echo $this->infoUser->location; ?></span></dt>
         	<?php endif; ?>
         	
         	<?php if( $this->infoUser->country != '' ) : ?>
         	<dt>Country: <span style="font-weight: normal"><?php echo $this->infoUser->country; ?></span></dt>
         	<?php endif; ?>
         	
         	<?php if( $this->infoUser->email != '' ) : ?>
         	<dt>Email: <span style="font-weight: normal"><?php echo $this->infoUser->email; ?></span></dt>
         	<?php endif; ?>
         	
         	<?php if( $this->infoUser->date != '' ) : ?>
         	<dt>Date: <span style="font-weight: normal"><?php echo date('Y/m/d', strtotime( $this->infoUser->date )); ?></span></dt>
         	<?php endif; ?>
         	
         	<?php if( $this->infoUser->website != '' ) : ?>
         	<dt>Website: <span style="font-weight: normal"><?php echo _Function:: linkText( $this->infoUser->website ); ?></span></dt>
         	<?php endif; ?>
         	
         	<?php if( $this->infoUser->bio != '' ) : ?>
         	<dt>Bio: <span style="font-weight: normal"><?php echo htmlentities( $this->infoUser->bio, ENT_QUOTES,'UTF-8' ); ?></span></dt>
         	<?php endif; ?>
         	
         	<dt>Mode: <span style="font-weight: normal"><?php echo $mode; ?></span></dt>
         	
         	<dt>Status: <span style="font-weight: normal"><?php echo ucfirst( $this->infoUser->status ); ?></span></dt>
         	
         	<dt style="float: left; width: 100%;">
         		<span style="float: left; margin-right: 5px;">Actions:</span> 
         		<?php if( $this->infoUser->status != 'delete' && $this->infoUser->status == 'active'  ): ?>
               	 	<a data-id="<?php echo $this->infoUser->id ?>" class="icons suspended" title="Suspended">Suspended</a>
               	 	<a id="delete" data-id="<?php echo $this->infoUser->id ?>" class="icons delete" title="Delete">Delet</a>
               	 	<?php endif; ?>
               	 	
               	 	<?php if( $this->infoUser->status != 'delete' 
	               	 	&& $this->infoUser->status == 'suspended' 
	               	 	|| $this->infoUser->status != 'delete' 
	               	 	&& $this->infoUser->status == 'pending'  
						): ?>
               	 	<a data-id="<?php echo $this->infoUser->id ?>" class="icons active" title="Activate">Activate</a>
               	 	<?php endif; ?>
               	 	
               	 	<?php if( $this->infoUser->status != 'delete' && $this->infoUser->status == 'pending'  ): ?>
               	 	<a data-id="<?php echo $this->infoUser->id ?>" class="icons delete" title="Delete">Delet</a>
               	 	<?php endif; ?>
               	 	
         	</dt>
         	
         	<?php if( $this->infoUser->status != 'delete' ): ?>
         	<dt><a target="_blank" class="btn btn-primary" href="<?php echo URL_BASE.$this->infoUser->username ?>">View Profile <i class="glyphicon glyphicon-new-window"></i></a></dt>
         	<?php endif; ?>
         	
         </dl>
        
        </div><!-- col-lg-6 -->
<?php

else:
	?>
	<div class="alert alert-danger">
          	<i class="glyphicon glyphicon-remove"></i> User does not exist
      </div>
	<?php endif; ?>

      </div><!-- row -->