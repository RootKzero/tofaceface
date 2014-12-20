<div class="containerForm">
	
	<form class="formAjax" action="" method="POST" id="formSettings">
	<!-- Grid Form  -->
	<div class="grid-form" style="padding-top: 15px;">
		<span id="checkusername"></span>
		<label><?php echo $_SESSION['LANG']['current_pass']; ?></label>
		<input type="password" name="current" id="current" value="" />
	</div><!-- Grid Form  -->
		
		<!-- Grid Form  -->
	<div class="grid-form">
		<label><?php echo $_SESSION['LANG']['new_pass']; ?></label>
		<input type="password" name="new" id="new" value="" />
	</div><!-- Grid Form  -->
	
	<!-- Grid Form  -->
	<div class="grid-form">
		<label style="line-height: 15px;"><?php echo $_SESSION['LANG']['confirm_pass']; ?></label>
		<input type="password" name="confirm" id="confirm" value="" />
	</div><!-- Grid Form  -->
	
	
	<div class="error-update"></div>
	
	<div id="counter"></div>
	  <button id="editProfile" class="profile-settings-password" disabled="disabled" style="opacity: 0.5; cursor: default;" type="submit">
	  	<?php echo $_SESSION['LANG']['save']; ?>
	  	</button>
	</form>
	

</div><!-- Container Form -->
