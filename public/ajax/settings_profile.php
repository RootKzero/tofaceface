<?php
session_start();
error_reporting(0);
if ( 
		isset ( $_POST['name'] ) 
		&& !empty( $_POST['name'] )
)
{
	
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
		
	  $_POST['name']           = _Function::spaces( trim( $_POST['name']) );
	  $_POST['location']       = _Function::spaces( trim( strip_tags( $_POST['location'] ) ) );
	  $_POST['website']        = _Function::spaces( trim( $_POST['website'] ) );
	  $url                     = $_POST['website'];
	  $_POST['website']        = trim( $_POST['website'], '/' );
	  $_POST['bio']            = _Function::checkTextDb( trim( $_POST['bio'] ) );
	  $admin                   = $obj->getSettings();
		
		//<-------- * Cutting chain if greater than post_length  * --------->
		if( strlen( utf8_decode( $_POST['bio'] ) ) > $admin->post_length  ) {
			$_POST['bio'] = _Function::cropStringLimit( $_POST['bio'], $admin->post_length );
			
		}
		
		if ( $_POST['name'] == '' 
			|| strlen( utf8_decode( $_POST['name'] ) ) < 2 
			|| strlen( utf8_decode( $_POST['name'] ) ) > 20 
		) {
			echo json_encode( array( 'response' => $_SESSION['LANG']['full_name_error'] ) );
		} else if ( !filter_var( $url, FILTER_VALIDATE_URL ) && $url != '' ) {
			echo json_encode( array( 'response' => $_SESSION['LANG']['url_not_valid'] ) );
		  }  else {
			
			$_POST['name'] = htmlspecialchars( $_POST['name'] );
			$res = $obj->updateProfile();
			 
			 if( $res == 1 ) {
			 	echo json_encode( array( 'response' => 'true', 'save_success' => $_SESSION['LANG']['saved_successfully'] ) );
	 } else {
	 	echo json_encode( array( 'response' => $_SESSION['LANG']['error'] ) );
	 }
  }// ELSE
}// IF POST ISSET
 ?>