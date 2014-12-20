<?php
session_start();
error_reporting(0);

if ( isset( $_GET['token_id'] ) )
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
		$obj         = new AjaxRequest();	
		/*
			 * --------------------------
			 *   Root of Photo
			 * -------------------------
			 */
		$root           = '../cover/';
		$photo_id       = $_GET['token_id'];
		$photo_id_large = 'large_'.$_GET['token_id'];
		$infoUser       = $obj->infoUserLive( $_SESSION['authenticated'] );
		$imgOld         = $infoUser->cover_image;
			
		/*
		 * --------------------------
		 *   Folder permissions
		 * -------------------------
		 */
		 if( $imgOld == $photo_id ) {
		 	
			chmod( $root.$photo_id, 0777 );
			 if ( file_exists( $root.$photo_id ) )  {
				 unlink( $root.$photo_id );
				 unlink( $root.$photo_id_large );
				 
				 /* Update Database */
				 $obj->uploadCover( '' );
				 
				 echo 'TRUE';
			 }
		 }
    }//<-- session
}//<-- if token id
?>