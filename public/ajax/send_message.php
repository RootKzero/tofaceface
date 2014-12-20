<?php
session_start();
error_reporting(0);
if ( 
	 isset( $_POST['id_user'] ) 
	 && !empty( $_POST['id_user'] ) 
	 && isset( $_POST['message'] )
) {
if ( isset( $_SESSION['authenticated'] ) ) {
		/*
		 * --------------------------
		 *   Require File
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
		$obj                  = new AjaxRequest();
		$_POST['id_user']     = is_numeric( $_POST['id_user'] ) ? $_POST['id_user'] : die();
		$_POST['message']     = trim( $_POST['message'] );
		$infoUser             = $obj->infoUserLive( $_SESSION['authenticated'] );
		$admin                = $obj->getSettings();
		$verifiedUserBlock    = $obj->checkUserBlock( $_POST['id_reply'], $_SESSION['authenticated'] );
		
		$verifiedUser   = $obj->checkUser( $_POST['id_user'] ) ? 1 : 0;
		
		// Verified User
		if( $verifiedUser == 1 ) {
			$infoUserMsg = $obj->infoUserLive( $_POST['id_user'] );
		}
		// IF Message is Null
		if( mb_strlen( trim( $_POST['message'] ), 'utf8' ) == 0 ) {
			return false;
		}
		
		//Knowing whether the user is locked
		if( $verifiedUserBlock[0]['status'] == 1 ) {
			return false;
		}
		
		//<-------- *  * --------->
		if( mb_strlen( $_POST['message'], 'utf8' )  > $admin->message_length  )
		{
			$_POST['message'] = _Function::cropStringLimit( $_POST['message'], $admin->post_length );
			
		}
		
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
					<strong>
						<a style="color: #FF7000;" rel="nofollow" href="'. URL_BASE .$infoUser->username.'" target="_blank">
						@'.$infoUser->username.'
						</a>
						</strong> has sent you a message
				</p>
				
				<p style="text-align: center; font-size: 12px; padding: 5px 0 0 0;">
					<a style="text-decoration: none; color: #FFF; font-weight: bold; padding: 5px 10px; background: #FF7000; border-radius: 3px; -webkit-border-radius: 3px;" rel="nofollow" href="'. URL_BASE .'messages/" target="_blank">
						Go to messages &raquo;
					</a>

					<p style="text-align: center; font-size: 11px; padding: 5px 0 0 0;">
						© '.date('Y') .' '. $admin->title .'
					</p>
			</td>
		</tr>
	</tbody>
</table>';

		//<<-- DATABASE
		$query = $obj->sendMessage();
		
		if( $query == 1 ){
			
			if( $infoUserMsg->email_notification_msg == 1 ) {
			
			_Function::send_mail(
					$admin->title.' <'.EMAIL_NOTIFICATIONS.'>', 
					$infoUserMsg->email,
					'@'.$infoUser->username.'  has sent you a message',
					$messageEmail
					); 
		}
			
			 echo 'true';
		} else {
			return false;
		}
	
  }//<-- SESSION
}//<-- if token id
?>