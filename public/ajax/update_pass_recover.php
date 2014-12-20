<?php
session_start();
error_reporting(0);
if ( 
		isset( $_POST['idhash'] ) 
		&& isset ( $_POST['pass_1']) 
		&& isset( $_POST['pass_2'] ) 
) {
	if ( !isset( $_SESSION['authenticated'] ) ) {
		/*
		 * --------------------------
		 *   Require File
		 * -------------------------
		 */
		require_once('../../class_ajax_request/classAjax.php');
		/*
		 * ----------------------
		 *   Instance Class
		 * ----------------------
		 */
		$obj         = new AjaxRequest();
		include('../../application/functions.php'); 
		include('../../application/DataConfig.php');
		$_POST['idhash'] = trim( $_POST['idhash'] );
		 		
		if ( mb_strlen( $_POST['pass_1'], 'utf8' ) < 5 || mb_strlen( $_POST['pass_1'], 'utf8' ) > 20 ) {
			echo json_encode( array( 'response' => $_SESSION['LANG']['pass_length'], 'focus' => 'pass_1' ) );
			
		} else if ( mb_strlen( $_POST['pass_2'], 'utf8' ) < 5 || mb_strlen( $_POST['pass_2'], 'utf8' ) > 20 ) {
			echo json_encode( array( 'response' => $_SESSION['LANG']['pass_confirm_length'], 'focus' => 'pass_2' ) );
			
		} else if ( $_POST['pass_2'] !== $_POST['pass_1'] ) {
			echo json_encode( array( 'response' => $_SESSION['LANG']['pass_match'], 'focus' => 'pass_2' ) );
			
		} else {
			 $res = $obj->updatePasswordRecover(); 
			 if( $res == 1 ) {
		     echo json_encode( array( 'response' => 'true', 'success' => $_SESSION['LANG']['success_pass_update'] ) );
				 
		  } else {
		 echo json_encode( array( 'response' => $_SESSION['LANG']['error'] ) );
	 }// ELSE
	 
   }// ELSE
 }//<-- SESSION
 else {
		echo json_encode( array( 'reload' => 1 ) );
	}
}// IF POST ISSET
else {
	echo json_encode( array( 'response' => 'All fields required.' ) );
}
 ?>