<?php
session_start();
error_reporting(0);
if ( 
	 isset( $_POST['id'] )
	 && !empty( $_POST['id'] )
) {
if ( isset( $_SESSION['authenticated'] ) ) {
	if( isset( $_POST ) && $_SERVER['REQUEST_METHOD'] == "POST"){
		
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
	$obj            = new AjaxRequest();
	$admin          = $obj->getSettings();
	$_POST['id']    = trim( $_POST['id'] );
	$explode        = explode( '-', $_POST['id'] );
	$_POST['id']    = (int)$explode[1];
	$infoUser       = $obj->infoUserLive( $_SESSION['authenticated'] );
	$verifiedUser   = $obj->checkUser( $_POST['id'] ) ? 1 : 0;
	
	if( $verifiedUser == 1 ) {
		$infoUserFollow = $obj->infoUserLive( $_POST['id'] );
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
						</strong> is following you
				</p>
				
				<p style="text-align: center; font-size: 12px; padding: 5px 0 0 0;">
					<a style="color: #FFF; font-weight: bold; padding: 5px 10px; background: #FF7000; border-radius: 3px; -webkit-border-radius: 3px;" rel="nofollow" href="'. URL_BASE .$infoUserFollow->username.'/followers" target="_blank">
						View your followers &raquo;
					</a>

					<p style="text-align: center; font-size: 11px; padding: 5px 0 0 0;">
						© '.date('Y') .' '. $admin->title .'
					</p>
			</td>
		</tr>
	</tbody>
</table>'; 
	
	//*** DATABASE
	$query = $obj->follow();
	
	if( $query == 1 ) {
		
		if( $infoUserFollow->email_notification_follow == 1 ) {
			
			_Function::send_mail(
					$admin->title.' <'.EMAIL_NOTIFICATIONS.'>', 
					$infoUserFollow->email,
					'@'.$infoUser->username.' is following you',
					$messageEmail
					); 
		}
		 echo json_encode( array( 'status' => 1 ) );
		 
	} else if( $query == 2 ){
		 echo json_encode( array( 'status' => 2 ) );
	} else if( $query == 3 ){
		 echo json_encode( array( 'status' => 3 ) );
	} else {
		echo json_encode( array( 'status' => 0, 'error' => $_SESSION['LANG']['error'] ) );
	}
		}//<-- POST ISSET
  }//<-- SESSION
}//<-- if token id
?>