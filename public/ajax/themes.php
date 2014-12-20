<?php
session_start();
error_reporting(0);

if ( $_POST['theme_id'] != '' )
{
if ( isset( $_SESSION['authenticated'] ) )
	{
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
		$obj       = new AjaxRequest();	
		$root      = '../backgrounds/';
		$infoUser  = $obj->infoUserLive( $_SESSION['authenticated'] );
		$themeOld  = $root.$infoUser->bg;
		$ext       = ".jpg";
		$theme_id  = $_POST['theme_id'].$ext;
		$defaults  = array( '0.jpg', '1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg','10.jpg','11.jpg' );
		
		/*
		 * --------------------------
		 *   folder permissions
		 * -------------------------
		 */
		chmod( $root.$theme_id, 0777 );
			
			if ( file_exists( $themeOld ) && !in_array( $infoUser->bg, $defaults ) && $infoUser->bg != '' ) {
				 	
				 unlink( $themeOld );
			 }
			 
			 if ( file_exists( $root.$theme_id ) ) {
				 	
				 $obj->updateTheme( $theme_id );
				 
				 echo json_encode( array( 'theme' => $theme_id ) );
			 }
		   }//<-- session
else {
	echo json_encode( array( 'session' => 0 ) );
}
}//<-- if token id
else {
	return false;
}
?>