<!-- Grid 1 -->
 <div class="grid_1">
	<!-- container_grid -->
	<div class="container_grid">
		<span id="avatar-min">
			<a href="<?php echo URL_BASE.$this->infoSession->username; ?>" id="avatar_link">
			<img class="avatar_user" src="<?php echo URL_BASE; ?>thumb/48-48-public/avatar/<?php echo $this->infoSession->avatar; ?>">
		</a>
		</span>
		
		<span class="detail_grid_right">
			<a style="border: none;" class="username_right myprofile" href="<?php echo URL_BASE.$this->infoSession->username; ?>">
				<?php echo stripslashes( $this->infoSession->name ); ?>
				</a>
			<a class="link_small myprofile" href="<?php echo URL_BASE.$this->infoSession->username; ?>">
				<?php echo $_SESSION['LANG']['see_profile']; ?> &rarr;
				</a>
		
		</span>
		
		<ul class="user_data_profile">
   					<li>
   						<span class="container_data_profile_2 grid_first">
   							<a href="<?php echo URL_BASE.$this->infoSession->username; ?>" >
   							<span class="countDataProfile"><?php echo _Function::formatNumber(  $this->infoSession->totalPost  ); ?></span>
   							<span class="title_data_profile"> <?php echo $_SESSION['LANG']['posts']; ?></span>
   							</a>
   						</span>
   					</li>
   					
   					<li>
   						<span class="container_data_profile_2">
   							<a href="<?php echo URL_BASE.$this->infoSession->username.'/followers'; ?>" >
   							<span class="countDataProfile"><?php echo _Function::formatNumber( $this->infoSession->totalFollowers ); ?></span>
   							<span class="title_data_profile"> <?php echo $_SESSION['LANG']['followers']; ?></span>
   							</a>
   						</span>
   					</li>
   					
   					<li class="last_li">
   						<span class="container_data_profile_2">
   							<a href="<?php echo URL_BASE.$this->infoSession->username.'/following'; ?>" >
   								<span class="countDataProfile"><?php echo _Function::formatNumber( $this->infoSession->totalFollowing ); ?></span>
								<span class="title_data_profile"> <?php echo $_SESSION['LANG']['following']; ?></span>
   							</a>
   							
   						</span>
   					</li>
 
   				</ul><!-- user_data -->
   				
	</div><!-- container_grid -->
</div><!-- Grid 1 -->