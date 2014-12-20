<?php
	//authenticated
	if( Session::get( 'authenticated' ) ) : 
		
		/* Notifications Messages */
		if( $this->notiMsg->total != 0 ) {
			$displayBlock  = ' style="display: block;"';
			$iNotification = ' style="display: inline-block;"';
		} else {
			$displayBlock  = null;
			$iNotification = null;
		}
		
		/* Notifications Interactions */
		if( $this->notiIntera->total != 0 ) {
			$_displayBlock = ' style="display: block;"';
			$_iNotification = ' style="display: inline-block;"';
		} else {
			$_displayBlock = null;
			$_iNotification = null;
		}
?>
<!-- navegation -->	
					<nav id="navegation">
						<div class="quick_search">
						   <form action="search/" method="get" id="search_engine" accept-charset="UTF-8">
						   	<div class="wrap_autocomplete">
						   		<input id="btnItems" name="q" class="mention" type="text" placeholder="<?php echo $_SESSION['LANG']['search_word']; ?>" maxlength="100">	
						   <div id="boxLogin" class="boxSearch" style="width: 315px; right: 10px;">
						    <i class="arrowUp"></i>
						     <ul class="toogle_search">
										<li class="searchGlobal" style="margin-bottom: 5px;"></li>
										<span class="load_search"></span>
									</ul>
									</div><!-- BOX -->
						   	</div>
							       <button type="submit" id="buttonSearch">Search</button>
						      </form>
						      
						</div><!-- quick_search -->	
						
						<!-- nav_user -->	
						<ul class="nav_user">
							<li>
								<span class="notify" id="noti_msg"<?php echo $displayBlock; ?>><?php echo $this->notiMsg->total; ?></span>
								<a href="<?php echo URL_BASE; ?>messages/" class="messages" title="<?php echo $_SESSION['LANG']['messages']; ?>">messages</a>
							</li>
								<li>
									<a href="<?php echo URL_BASE; ?>discover/" class="hashtag" title="<?php echo $_SESSION['LANG']['discover']; ?>">Discover</a>
								</li>
									<li>
										<span class="notify" id="noti_connect"<?php echo $_displayBlock; ?>><?php echo $this->notiIntera->total; ?></span>
										<a href="<?php echo URL_BASE; ?>interactions/" class="connect" title="<?php echo $_SESSION['LANG']['interactions']; ?>">Connect</a>
									</li>
									
									<li>
										<a href="<?php echo URL_BASE.$this->infoSession->username; ?>" class="userAvatar myprofile">
											<img src="<?php echo URL_BASE.'thumb/25-25-public/avatar/'.$this->infoSession->avatar; ?>" />
											</a>
									</li>
									
										<li class="listLast">
											<a href="" class="settings toogle">settings</a>
								<div id="boxLogin" class="boxLogin" style="width: 180px; right: -4px;">
									<i class="arrowUp"></i>
									<ul class="options_toogle">
										<li><a href="<?php echo URL_BASE.$this->infoSession->username; ?>" class="myprofile"><?php echo $_SESSION['LANG']['my_profile']; ?></a></li>
										<li><a href="<?php echo URL_BASE; ?>profile/"><?php echo $_SESSION['LANG']['edit_profile']; ?></a></li>
										<li><a href="<?php echo URL_BASE; ?>settings/"><?php echo $_SESSION['LANG']['settings']; ?></a></li>
										<li style="border-top: 1px solid #DDD;" class="bottomList"><a class="logout"><?php echo $_SESSION['LANG']['log_out']; ?></a></li>
									</ul>
								</div><!-- boxLogin -->
										</li>
						</ul><!-- nav_user -->	
					</nav><!-- navegation -->
					
	<!-- Navegation 2 -->
	<nav id="navegation_2">
		<!-- nav_user -->	
		<ul class="nav_user">
		<li class="listLast">
			  <a href="" class="settings_2 toogle">settings</a>
				<div id="boxLogin" class="boxLogin" style="width: 180px; right: -4px;">
					<i class="arrowUp"></i>
					<ul class="options_toogle">
						<li><a href="<?php echo URL_BASE.$this->infoSession->username; ?>" class="myprofile"><?php echo $_SESSION['LANG']['my_profile']; ?></a></li>
						<li><a href="<?php echo URL_BASE; ?>messages/"><?php echo $_SESSION['LANG']['messages']; ?> 
							<i class="iNotification"<?php echo $iNotification; ?>></i>
							</a>
			            </li>
				<li>
					<a href="<?php echo URL_BASE; ?>discover/"><?php echo $_SESSION['LANG']['discover']; ?></a>
				</li>
					<li>
						<a href="<?php echo URL_BASE; ?>interactions/"><?php echo $_SESSION['LANG']['interactions']; ?> 
							<i class="iNotification"<?php echo $_iNotification; ?>></i>
							</a>
					</li>
						<li><a href="<?php echo URL_BASE; ?>profile/"><?php echo $_SESSION['LANG']['edit_profile']; ?></a></li>
						<li><a href="<?php echo URL_BASE; ?>settings/"><?php echo $_SESSION['LANG']['settings']; ?></a></li>
						<li style="border-top: 1px solid #DDD;" class="bottomList"><a class="logout"><?php echo $_SESSION['LANG']['log_out']; ?></a></li>
					</ul>
				</div><!-- boxLogin -->
						</li>
		</ul><!-- nav_user -->	
	</nav><!-- navegation -->
					
<?php
	   else :
		   
		   ?>
		   
		   <!-- navegation -->	
					<nav id="navegationSessionNull">
						<ul>
							<li>
								<span id="signInButton" class="toogle"><?php echo $_SESSION['LANG']['title_sign_in']; ?> <i class="arrow"></i></span>
								<div id="boxLogin" class="boxLogin">
									<i class="arrowUp"></i>
							<form style="display: none;" action="" method="post" name="form" id="recover_pass_form" class="form_login recoverForm">
		    					<input type="text" name="email_recover" id="email_recover" placeholder="<?php echo $_SESSION['LANG']['placeholder_email_recover']; ?>" title="<?php echo $_SESSION['LANG']['placeholder_email_recover']; ?>" />
		    					<a style="cursor: pointer;" class="recover_pass buttonInside forgot buttonBack">&laquo; <?php echo $_SESSION['LANG']['back']; ?></a>
		    					<span id="error_recover"></span>
		    					<span id="success_recover"></span>
		    					<button type="submit" id="buttonRecoverPass"><?php echo $_SESSION['LANG']['send']; ?></button>
		    				</form>
									<form action="" method="post" name="form" id="signin_form" class="form_login signInForm">
				    					<input type="text" name="user" id="user" placeholder="<?php echo $_SESSION['LANG']['placeholder_email_username']; ?>" title="<?php echo $_SESSION['LANG']['placeholder_email_username']; ?>" />
				    					<input type="password" name="password" id="password_signin" placeholder="<?php echo $_SESSION['LANG']['placeholder_pass']; ?>" title="<?php echo $_SESSION['LANG']['placeholder_pass']; ?>" />
				    					<a style="cursor: pointer;" class="recover_pass buttonInside forgot buttonForgot"><?php echo $_SESSION['LANG']['placeholder_forgot_pass']; ?></a>
				    					<span id="error"></span>
		    					        <span id="success_signin"></span>
				    					<button type="submit" id="buttonSignIn" class="button_class" data-wait="<?php echo $_SESSION['LANG']['please_wait']; ?>"><span><?php echo $_SESSION['LANG']['sign_in']; ?></span></button>
		    				       </form>
								</div><!-- boxLogin -->
							</li>
						</ul>
					</nav><!-- navegation -->
<?php endif; ?>