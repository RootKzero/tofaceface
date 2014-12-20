<?php
session_start();
error_reporting(0);
if ( 
		isset ( $_POST['name_admin'] ) 
		&& !empty( $_POST['name_admin'] ) 
		&& isset ( $_POST['user_admin'] ) 
		&& !empty( $_POST['user_admin'] ) 
		&& isset ( $_POST['pass_new'] ) 
		&& isset ( $_POST['repeat_pass'] ) 
		&& isset ( $_POST['repeat_pass'] ) 
) {
	
	/*
	 * --------------------------
	 *   Require/Include Files
	 * -------------------------
	 */
	require_once('../../class_ajax_request/classAjaxAdmin.php');
    include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');	
	/*
	 * ----------------------
	 *   Instance Class
	 * ----------------------
	 */
	$obj = new AjaxRequestAdmin();

	  $_POST['name_admin']  = _Function::spaces( trim( $_POST['name_admin']) );
	  $_POST['user_admin']   = _Function::spaces( trim( $_POST['user_admin'] ) );
	  $_POST['pass_new']    = _Function::spaces( trim( $_POST['pass_new'] ) );
	  $_POST['repeat_pass'] = trim( $_POST['repeat_pass']);
		
		
		if ( $_POST['name_admin'] == '' || mb_strlen( $_POST['name_admin'], 'utf8' ) < 2 )
		{
			echo json_encode( array( 'res' => 'Name too short...', 'focus' => 'name_admin' ) );
			
		} else if ( preg_match( '/[^a-z0-9\_]/i',$_POST['user_admin'] ) ) {
			
			echo json_encode( array( 'res' => 'Username not valid', 'focus' => 'user_admin' ) );
			
		} else if ( mb_strlen( $_POST['pass_new'], 'utf8' ) < 5 ) {
			
			echo json_encode( array( 'res' => 'Password too short', 'focus' => 'pass_new' ) );
			
		}  else if ( $_POST['pass_new'] !== $_POST['repeat_pass'] ) {
			
			echo json_encode( array( 'res' => 'Passwords do not match' ) );
		} else {
			
			/* INSERT DATABASE */
			$res = $obj->addUser();

			if( $res == 1 ) {
			
		  	echo json_encode( array( 'res' => 'User added successfully', 'success' => 1 ) );
		
		  } else if ( $res == 2 ) {
		  	
			echo json_encode( array( 'res' => '<strong>'. $_POST['user_admin'] .'</strong> Username not available ' ) );
	    } 
   }// ELSE
 } else {
	echo json_encode( array( 'res' => 'Error' ) );
}
 ?>