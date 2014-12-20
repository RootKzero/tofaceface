<?php
session_start();
error_reporting(0);
if ( 
	isset ( $_POST['email_recover'] ) 
	&& !empty( $_POST['email_recover'] )

) {
if ( !isset( $_SESSION['authenticated'] ) ) {
	/*
	 * --------------------------
	 *   Require/Include Files
	 * -------------------------
	 */
	require_once('../../class_ajax_request/classAjax.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');	
	/*
	 * --------------------------
	 *   Instance Class
	 * -------------------------
	 */
	$obj               = new AjaxRequest();
	$admin             = $obj->getSettings();
	  
	  $linkHash     = sha1 ( $_SERVER['REMOTE_ADDR'] . microtime() . mt_rand ( 1,100000 ).'%(asqWas8*)' );
	  $link         = _Function::idHash( $linkHash )._Function::randomString( 40, TRUE, TRUE, TRUE );
	  $linkRecover  = ''. URL_BASE .'recover/?c='.$link .'';
	  
	  // <------------------ DATA ----------->
	  $_POST['email_recover'] = trim( $_POST['email_recover'] );	 
	  $_POST['id_hash']       = $link;
	  $emailAddress           = $_POST['email_recover'];
		
       //================ * EMAIL * =================//
		if ( !filter_var( $emailAddress, FILTER_VALIDATE_EMAIL ) ) {
			
			echo json_encode( array( 'status' => 'false', 'html' => $_SESSION['LANG']['email_not_valid'] ) );
		} else {
			
			 //<<<--- DATABASE
			 $res = $obj->recoverPass();
			 
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
					<strong>Recover Pass:</strong>
				</p>
				
				<p style="margin-bottom: 10px;">
					<a style="text-decoration: none; color: #FFF; padding: 5px 10px; background: #FF7000; border-radius: 3px; -webkit-border-radius: 3px;" rel="nofollow" href="'. $linkRecover.'" target="_blank">
					<strong>
						Click here to recover your password
					</strong></a>
				</p>
				
				<p style="text-align: center; font-size: 12px; padding: 5px 0 0 0;">
					PS: If you did not request the password change, please disregard this email.
					</p>
					
					<p style="text-align: center; font-size: 11px; padding: 5px 0 0 0;">
						© '.date('Y') .' '. $admin->title .'
					</p>
			</td>
		</tr>
	</tbody>
</table>'; 
			 
			 if( $res == 1 ) {
					
					echo json_encode( array( 'status' => 'true', 'html' => $_SESSION['LANG']['send_success'] ) ); 
					
					_Function::send_mail(
					$admin->title.' <'.EMAIL_PASS_RECOVER.'>', 
					$_POST['email_recover'],
					'Recover passwords',
					$messageEmail
					); 
} else {
		 echo json_encode( array( 'status' => 'false', 'html' => $_SESSION['LANG']['email_no_exist'] ) );
	 }// END ELSE
   }// END ELSE 
  }// IF SESSION 
}// END IF POST ISSET

 ?>