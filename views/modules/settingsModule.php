<div class="containerForm">
	
	<form class="formAjax" action="" method="POST" id="formSettings">
	<!-- Grid Form  -->
	<div class="grid-form" style="padding-top: 15px;">
		<span id="checkusername"></span>
		<label><?php echo $_SESSION['LANG']['username']; ?></label>
		<input type="text" data-username="<?php echo $this->infoSession->username ?>" name="username" id="username" value="<?php echo $this->infoSession->username ?>" />
	</div><!-- Grid Form  -->
		
		<!-- Grid Form  -->
	<div class="grid-form">
		<label><?php echo $_SESSION['LANG']['mail']; ?></label>
		<input type="text" data-email="<?php echo $this->infoSession->email ?>" name="email" id="email" value="<?php echo $this->infoSession->email ?>" />
	</div><!-- Grid Form  -->
	
	<!-- Grid Form  -->
	<div class="grid-form">
		<label><?php echo $_SESSION['LANG']['account'] ?></label>
		<div class="select">
			<select name="mode" id="mode">
			<option class="mod_1" value="1"><?php echo $_SESSION['LANG']['option_public']; ?></option>
			<option class="mod_0" value="0"><?php echo $_SESSION['LANG']['option_private']; ?></option>
		</select>
		</div>
		
	</div><!-- Grid Form  -->
	
	<!-- Grid Form  -->
	<div class="grid-form bioGrid">
		<label><?php echo $_SESSION['LANG']['country']; ?></label>
		<div class="select">
		<select name="country" id="country">
			<option class="country_xx" value="xx"><?php echo $_SESSION['LANG']['worldwide']; ?></option>
                <?php
                foreach ( $this->countries as $key ) {
                    ?>
                    <option class="country_<?php echo $key['short']; ?>" value="<?php echo $key['short']; ?>"><?php echo $key['country']; ?></option>
                    <?php
                }
                 ?>
		</select>
		</div>
	</div><!-- Grid Form  -->
	
	<!-- Grid Form  -->
	<div class="grid-form bioGrid">
		<label><?php echo $_SESSION['LANG']['lang_title']; ?></label>
		<div class="select">
		<select name="lang" id="lang">
			<?php foreach ( _Function :: arrayLang() as $key => $value ) : ?>
				<option class="<?php echo $value; ?>" value="<?php echo $value; ?>"><?php echo $key; ?></option>
			<?php endforeach;  ?>

		</select>
		</div>
	</div><!-- Grid Form  -->
	
	<h4 class="titleBar" style="margin-bottom: 20px;" data-title="Settings"><?php echo $_SESSION['LANG']['privacy']; ?></h4>
	
	<!-- Grid Form  -->
	<div class="grid-form">
		<label style="margin-right: 25px; line-height: 14px; width: 24.215%"><?php echo $_SESSION['LANG']['msg_private']; ?></label>
		
		<label class="radioButton">
			<input style="width:auto; float: left;" id="radio_0" type="radio" value="0" name="msg_private" />
			<?php echo $_SESSION['LANG']['msg_private_1']; ?>
		</label>
		
		<label class="radioButton">
			<input style="width:auto; float: left;" type="radio" id="radio_1" value="1" name="msg_private" />
			<?php echo $_SESSION['LANG']['msg_private_2']; ?>
		</label>
		
		<label class="radioButton">
			<input style="width:auto; float: left;" type="radio" id="radio_2" value="2" name="msg_private" />
			<?php echo $_SESSION['LANG']['msg_private_3']; ?>
		</label>
	</div><!-- Grid Form  -->
	
	<?php 
	if( $this->infoSession->email_notification_msg === '1' ) {
		$check_0 = 'checked="checked"';
	} else {
		$check_0 = null;
	}
	
	if( $this->infoSession->email_notification_follow === '1' ) {
		$check_1 = 'checked="checked"';
	} else {
		$check_1 = null;
	}
	?>
		
	<!-- Grid Form  -->
	<div class="grid-form">
		<label style="margin-right: 25px; line-height: 14px; width: 24.215%"><?php echo $_SESSION['LANG']['email_notification']; ?></label>
		
		<label class="radioButton label_auto">
			<input style="width:auto; float: left;" id="check_0" <?php echo $check_0; ?> type="checkbox" value="1" name="check_0" />
			<?php echo $_SESSION['LANG']['msg_private']; ?>
		</label>
		
		<label class="radioButton label_auto">
			<input style="width:auto; float: left;" type="checkbox" <?php echo $check_1; ?> id="check_1" value="1" name="check_1" />
			<?php echo $_SESSION['LANG']['follow_me']; ?>
		</label>

	</div><!-- Grid Form  -->
	
	<div class="error-update"></div>
	
	<div id="counter"></div>
	  <button id="editProfile" class="profile-settings-account" disabled="disabled" style="opacity: 0.5; cursor: default;" type="submit"><?php echo $_SESSION['LANG']['save']; ?></button>
	</form>
	
	<div class="delete-account"><a><?php echo $_SESSION['LANG']['delete_account']; ?></a></div>
</div>