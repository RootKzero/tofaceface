<?php
session_start();
error_reporting(0);
if ( 
		isset ( $_POST['full_name'] ) 
		&& !empty( $_POST['full_name'] ) 
		&& isset ( $_POST['username'] ) 
		&& !empty( $_POST['username'] ) 
		&& isset ( $_POST['email'] ) 
		&& !empty( $_POST['email'] ) 
		&& isset ( $_POST['password'] ) 
		&& isset ( $_POST['captcha'] ) 
) {
	
	/*
	 * --------------------------
	 *   Require/Include Files
	 * -------------------------
	 */
	require_once('../../class_ajax_request/classAjax.php');
    include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');	
	/*
	 * ----------------------
	 *   Instance Class
	 * ----------------------
	 */
	$obj = new AjaxRequest();

 
		
	  $_POST['code']           = sha1 ( $_SERVER['REMOTE_ADDR'] . microtime() . mt_rand ( 1,100000 ) )._Function::randomString( 40, TRUE, TRUE, TRUE );
	  $_POST['email']          = trim( $_POST['email']);
	  $_POST['full_name']      = _Function::spaces( trim( $_POST['full_name']) );
	  $_POST['username']       = _Function::spaces( trim( $_POST['username'] ) );
	  $_POST['password']       = _Function::spaces( trim( $_POST['password'] ) );
	  $admin                   = $obj->getSettings();
	  $emailAddress            = $_POST['email'];
		
		if ( $_POST['full_name'] == '' 
			|| mb_strlen( $_POST['full_name'], 'utf8' ) < 2 
			|| mb_strlen( $_POST['full_name'], 'utf8' )  > 20 
		) 
		{
			echo json_encode( array( 'res' => $_SESSION['LANG']['full_name_error'], 'focus' => 'full_name' ) );
			
		} else if ( preg_match( '/[^a-z0-9\_]/i',$_POST['username'] ) ) {
			
			echo json_encode( array( 'res' => $_SESSION['LANG']['username_not_valid'], 'focus' => 'username' ) );
			
		} else if ( strlen( $_POST['username'] ) < 1 || strlen( $_POST['username'] ) > 15 ) {
			
			echo json_encode( array( 'res' => $_SESSION['LANG']['username_not_valid'], 'focus' => 'username' ) );
			
		} else if ( !filter_var( $emailAddress, FILTER_VALIDATE_EMAIL ) ) {
			
			echo json_encode( array( 'res' => $_SESSION['LANG']['email_not_valid'], 'focus' => 'email' ) );
		   
		} else if ( mb_strlen( $_POST['password'], 'utf8' ) < 5 || mb_strlen( $_POST['password'], 'utf8' ) > 20 ) {
			
			echo json_encode( array( 'res' => $_SESSION['LANG']['password'], 'focus' => 'username' ) );
			
		}  else if ( $_POST['terms'] == '' ) {
			
			echo json_encode( array( 'res' => $_SESSION['LANG']['can_not_register'], ) );
		} else {
			
			/* INSERT DATABASE */
			$res = $obj->signUp();
			
			/* EMAIL TEMPLATE */
			
			$messageEmail = '
			<table width="550" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif; font-size: 14px; color: #666;" align="center">
	<tbody>
		<tr>
			<td width="550" height="50" align="center" style="background: #333;">
				<img style="width: 130px;" src="'. URL_BASE .'public/img/logo.png" />
			</td>
		</tr>
		
		<tr>
			<td width="558" align="center" style="background: #FFF; line-height: 18px; padding: 10px;  border-bottom: 1px solid #DDD; border-left: 1px solid #DDD; border-right: 1px solid #DDD;">
				<p style="margin-bottom: 10px;">
					Thanks for signing up on '. $admin->title .' <strong>"'. $_POST['full_name'] .'"</strong>
				</p>
				<p style="margin-bottom: 10px;">
					<a style="text-decoration: none; color: #FFF; padding: 5px 10px; background: #FF7000; border-radius: 3px; -webkit-border-radius: 3px;" rel="nofollow" href="'. URL_BASE .'?validate='. $_POST['code'].'" target="_blank">
					<strong>
						Click here to activate your account
					</strong></a>
				</p>
					<p style="text-align: center; font-size: 11px; padding: 5px 0 0 0;">
						© '.date('Y') .' '. $admin->title .'
					</p>
			</td>
		</tr>
	</tbody>
</table>';
			
			if( $res == 1 ) {
			
		  	echo json_encode( array( 'res' => $_SESSION['LANG']['sign_up_success'], 'success' => 1 ) );
			
			_Function::send_mail(
			$admin->title.' <'.EMAIL_ACTIVE_ACCOUNT.'>', 
			 $_POST['email'],
		     'Activate Account', 
		     $messageEmail
			 );
		  } else if ( $res == 2 ) {
		  	
			echo json_encode( array( 'res' => $_POST['username'].' '.$_SESSION['LANG']['username_already_use'] ) );
	    } else {
	    	echo json_encode( array( 'res' => $_SESSION['LANG']['email_already_use'] ) );
	 }// ELSE
   }// ELSE
 } else {
	echo $_SESSION['LANG']['error'];
}
 ?>