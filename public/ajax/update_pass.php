<?php
session_start();
error_reporting(0);
if ( 
		isset ( $_POST['current']) 
		&& isset ( $_POST['new']) 
		&& isset( $_POST['confirm'] ) 
) {
	if ( isset( $_SESSION['authenticated'] ) ) {
		/*
		 * --------------------------
		 *   Require File
		 * -------------------------
		 */
		require_once('../../class_ajax_request/classAjax.php');
		/*
		 * --------------------------
		 *  Instance Class
		 * -------------------------
		 */
		$obj         = new AjaxRequest();
		$passCurrent = $obj->infoUserLive( $_SESSION['authenticated'] );
		include('../../application/functions.php'); 
		include('../../application/DataConfig.php');	
 		
		if ( sha1( $_POST['current'] ) != $passCurrent->password )
		{
			echo json_encode( array( 'response' => $_SESSION['LANG']['pass_incorrect'], 'focus' => 'current' ) );
		}
		
		else if ( mb_strlen( $_POST['new'], 'utf8' ) < 5 || mb_strlen( $_POST['new'], 'utf8' ) > 20 )
		{
			echo json_encode( array( 'response' => $_SESSION['LANG']['pass_length'], 'focus' => 'new' ) );
		}
		else if ( mb_strlen( $_POST['confirm'], 'utf8' ) < 5 || mb_strlen( $_POST['confirm'], 'utf8' ) > 20 )
		{
			echo json_encode( array( 'response' => $_SESSION['LANG']['pass_confirm_length'], 'focus' => 'confirm' ) );
		}
		else if ( $_POST['confirm'] !== $_POST['new'] )
		{
			echo json_encode( array( 'response' => $_SESSION['LANG']['pass_match'], 'focus' => 'confirm' ) );
		}		
else{
	
	 $res = $obj->updatePassword();
	 if( $res == 1 )
		  {
		     echo json_encode( array( 'response' => 'true', 'save_success' => $_SESSION['LANG']['saved_successfully'] ) );
			
		  }// $RES == 1
	 
	 else {
		 echo json_encode( array( 'response' => $_SESSION['LANG']['error'] ) );
		
	 }// ELSE
	 
   }// ELSE
 }//<-- SESSION
}// IF POST ISSET
 ?>