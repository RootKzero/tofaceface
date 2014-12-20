<?php 
$countFollow = count( $this->whoToFollow );
if( isset( $this->whoToFollow ) && $countFollow != 0 ) :
	
?>
<!-- Grid 1 -->
   <div class="grid_1">
   		<!-- container_grid -->
   		<div class="container_grid who_follow_grid">
   			<span class="grid_title_small"><?php echo $_SESSION['LANG']['who_to_follow']; ?></span>
   			
   			<?php
   			foreach ( $this->whoToFollow as $key )
   			{
   				//============ VERIFIED
				if( $key['type_account'] == '1' )
				{
					$verfied = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">';
				}
				else 
				{
					$verfied = null;
				}
   			 ?>
   			<!-- whoContainer -->
   			<div class="whoContainer" >
   				<a href="<?php echo URL_BASE.$key['username']; ?>" data-id="<?php echo $key['id'] ?>" class="openModal">
   					<img class="avatar_user" src="<?php echo URL_BASE."thumb/50-50-public/avatar/".$key['avatar']; ?>">
   				</a>
   					<span class="detail_grid_right">
   						<a data-id="<?php echo $key['id'] ?>" class="username_right openModal" href="<?php echo URL_BASE.$key['username']; ?>"><?php echo stripslashes( $key['name'] ); ?> <?php echo $verfied; ?></a>
   					<a data-follow="<?php echo $_SESSION['LANG']['follow']; ?>" data-following="<?php echo $_SESSION['LANG']['following']; ?>" class="link_small whofollow" data-username="<?php echo $key['username']; ?>" data-id="<?php echo _Function::randomString( 10, FALSE, TRUE, FALSE ).'-'.$key['id']; ?>">
   						<?php echo $_SESSION['LANG']['follow']; ?> @<?php echo $key['username']; ?></a>
   				</span>
   			</div><!-- whoContainer -->
   			<?php }//<---FOREACH ?>
   			
   		</div><!-- container_grid -->
   </div><!-- Grid 1 -->
   <?php  endif; ?>