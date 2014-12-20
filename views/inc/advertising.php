<?php
	//authenticated
	if( !Session::get( 'authenticated' ) ) :
	 ?>
<div class="grid_1">
	<div class="container_grid">
		<h3 style="font-size: 14px; text-align: center;"><?php echo $_SESSION['LANG']['title_sign_up']; ?></h3>
		  <form style="padding: 20px 5px;" action="" method="post" name="form" id="signup_form">
			<input type="text" name="full_name" id="full_name" placeholder="<?php echo $_SESSION['LANG']['full_name']; ?>" title="<?php echo $_SESSION['LANG']['full_name']; ?>" />
		    					<input type="text" name="username" id="username" placeholder="<?php echo $_SESSION['LANG']['username']; ?>" title="<?php echo $_SESSION['LANG']['username']; ?>" />
		    					<input type="text" name="email" id="email" placeholder="<?php echo $_SESSION['LANG']['mail']; ?>" title="<?php echo $_SESSION['LANG']['mail']; ?>" />
		    					<input type="password" name="password" id="password" placeholder="<?php echo $_SESSION['LANG']['placeholder_pass']; ?>" title="<?php echo $_SESSION['LANG']['placeholder_pass']; ?>" />
		    					<input type="text" name="captcha" id="lcaptcha" placeholder="" title="" />
		    					<input type="checkbox" value="1" name="terms" id="terms" tabindex="3" checked="checked">
		    					<a href="<?php echo URL_BASE; ?>terms/" class="recover_pass termsLegal" target="_blank"><?php echo $_SESSION['LANG']['terms']; ?></a>
		    					<span id="errorSignUp"></span>
		    					<span id="success"></span>
		    					<button type="submit" id="buttonSubmit"><span><?php echo $_SESSION['LANG']['sign_up']; ?></span></button>
		 </form>
  </div>
</div>
<?php endif; //<<--- SESSION NULL

 if( isset( $this->settings->ad ) && $this->settings->ad != '' ): ?>
<!-- Grid 1 -->
				   <div class="grid_1">
				   		<!-- container_grid -->
				   		<div class="container_grid grid_ad">
				   			<span class="grid_title_small"><?php echo $_SESSION['LANG']['advertising']; ?></span>
				   			<?php echo stripslashes( $this->settings->ad ); ?>
				   		</div><!-- container_grid -->
				   </div><!-- Grid 1 -->
				   <?php endif; ?>