<div class="containerForm">
	
	<ul class="chooseTheme">
		
		<li>
			<img class="themeChange" data-status="0" data="0" src="<?php echo URL_BASE; ?>public/backgrounds/0.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="1" src="<?php echo URL_BASE; ?>public/backgrounds/1.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="2" src="<?php echo URL_BASE; ?>public/backgrounds/2.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="3" src="<?php echo URL_BASE; ?>public/backgrounds/3.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="4" src="<?php echo URL_BASE; ?>public/backgrounds/4.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="5" src="<?php echo URL_BASE; ?>public/backgrounds/5.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="6" src="<?php echo URL_BASE; ?>public/backgrounds/6.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="7" src="<?php echo URL_BASE; ?>public/backgrounds/7.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="8" src="<?php echo URL_BASE; ?>public/backgrounds/8.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="9" src="<?php echo URL_BASE; ?>public/backgrounds/9.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="10" src="<?php echo URL_BASE; ?>public/backgrounds/10.jpg" />
		</li>
		
		<li>
			<img class="themeChange" data-status="0" data="11" src="<?php echo URL_BASE; ?>public/backgrounds/11.jpg" />
		</li>
		
	</ul>
	
	<h4 class="titleBar" style="padding-left:0;"><?php echo $_SESSION['LANG']['choose_theme']; ?></h4>
	
	<!-- AVATAR -->
	<form action="<?php echo URL_BASE; ?>public/ajax/upload_bg.php" method="POST" id="formBg" accept-charset="UTF-8" enctype="multipart/form-data">
		
		<label class="titleLabel"><?php echo $_SESSION['LANG']['background']; ?> 2MB</label>
		<!-- Grid Form  -->
	<div class="grid-form-bg">
		<?php 
			if( $this->infoSession->bg != '' ):
				$bg = 'background-image: url('.URL_BASE.'thumb_fixed/100-100-public/backgrounds/'.$this->infoSession->bg.');';
				endif;
				?>
				
		<label class="labelAvatar" style="width:100px; height: 70px; background-position: 50% 50%; background-color: #000; <?php echo $bg; ?>">
			
			<?php if( $this->infoSession->bg != '' ): ?>
			<div class="deleteBg" data-id="<?php echo $this->infoSession->bg; ?>" style="background: none; cursor: pointer;" title="<?php echo $_SESSION['LANG']['delete_image']; ?>" id="loader_gif"></div>
			<?php endif; ?>
			</label>
		<input type="file" name="photo" class="typeFile" id="upload_bg" accept="image/*" />
	</div><!-- Grid Form  -->
	</form>
	
	<form action="" method="POST" id="formSettings">
		
		<?php if( $this->infoSession->bg_attachment == 'fixed' ) {
			$checkBox = 'checked="checked"';
		} ?>
	<!-- Grid Form  -->
	<div class="grid-form" style="padding-top: 15px;">
		<span id="checkusername"></span>
		<label style="margin-right: 10px; line-height: 14px; width: 24.215%"><?php echo $_SESSION['LANG']['mosaic_background']; ?></label>
		<input <?php echo $checkBox; ?> style="width:auto; float: left;" type="checkbox" value="fixed" name="mosaic" id="mosaic" value="" />
	</div><!-- Grid Form  -->
	
	<!-- Grid Form  -->
	<div class="grid-form" style="padding-top: 15px;">
		<label style="margin-right: 10px; line-height: 14px; width: 24.215%"><?php echo $_SESSION['LANG']['pos_background']; ?></label>
		
		<label class="radioButton">
			<input style="width:auto; float: left;" class="radioIn" id="radio_left" type="radio" value="left" name="pos" />
			<?php echo $_SESSION['LANG']['left']; ?>
		</label>
		
		<label class="radioButton">
			<input style="width:auto; float: left;" type="radio" id="radio_center" class="radioIn" value="center" name="pos" />
			<?php echo $_SESSION['LANG']['center']; ?>
		</label>
		
		<label class="radioButton">
			<input style="width:auto; float: left;" type="radio" id="radio_right" class="radioIn" value="right" name="pos" />
			<?php echo $_SESSION['LANG']['right']; ?>
		</label>
	</div><!-- Grid Form  -->
	
	<!-- Grid Form  -->
	<div class="grid-form" style="padding-top: 15px;">
		<span id="checkusername"></span>
		<label style="margin-right: 10px; width: 24.215%"><?php echo $_SESSION['LANG']['color_link']; ?></label>
		<input readonly="readonly" style="width:auto; cursor: default; border: 1px solid #DDD; color:#FFF; float: left; background: <?php echo $this->infoSession->color_link; ?>" type="text" class="color" id="link" value="" />
		<input type="hidden" value="<?php echo $this->infoSession->color_link; ?>" id="linkData" name="link" />
	</div><!-- Grid Form  -->
	
	<!-- Grid Form  -->
	<div class="grid-form" style="padding-top: 15px;">
		<span id="checkusername"></span>
		<label style="margin-right: 10px; width: 24.215%"><?php echo $_SESSION['LANG']['color_background']; ?></label>
		<input readonly="readonly" style="width:auto; cursor: default; border: 1px solid #DDD; color:#FFF; float: left; background: <?php echo $this->infoSession->bg_color; ?>" type="text" class="color" id="bg_color" value="" />
		<input type="hidden" value="<?php echo $this->infoSession->bg_color; ?>" id="bgData" name="bg_color" />
	</div><!-- Grid Form  -->
	
	  <button id="editProfile" class="profile-settings-design" type="submit"><?php echo $_SESSION['LANG']['save']; ?></button>
	
	</form>

</div><!-- Container Form -->
