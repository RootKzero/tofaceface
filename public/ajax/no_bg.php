<?php
session_start();
error_reporting(0);

if ( isset( $_POST['bg'] ) )
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
		$obj             = new AjaxRequest();	
		$post_id_session = $_POST['id_session'];
		$root            = '../backgrounds/';
		$photo_id        = $_POST['bg'];
		$infoUser        = $obj->infoUserLive( $_SESSION['authenticated'] );
		$imgOld          = $infoUser->bg;
		$defaults        = array( '0.jpg', '1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg','10.jpg','11.jpg' );
		
		/*
		 * --------------------------
		 *   folder permissions
		 * -------------------------
		 */
		  if( $imgOld == $photo_id ) {
			  	chmod( $root.$photo_id, 0777 );
			 if ( file_exists( $root.$photo_id ) && !in_array($photo_id, $defaults) ) {
				 unlink( $root.$photo_id );
			 }
			 
			 $obj->bottomLess();
			 
			echo 'TRUE';
		  }
		
			
    }//<-- session
}//<-- if token id
?>