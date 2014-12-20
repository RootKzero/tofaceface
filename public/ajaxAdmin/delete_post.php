<?php
session_start();
error_reporting(0);

if ( 
	!empty( $_POST['id'] ) 
	&& isset ( $_POST['id']) 
) {
if ( isset( $_SESSION['id_admon'] ) ) {
	$_POST['id']    = is_numeric( $_POST['id'] ) ? $_POST['id'] : die();
	
	
	//<---  * REQUIRE * ----->
	require_once('../../class_ajax_request/classAjaxAdmin.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');

   //INSTANCE
$obj               = new AjaxRequestAdmin();
$root              = '../../upload/';
$_photo            = $obj->getPhotoPost( $_POST['id'] );
$photo_id          = $_photo->photo;

     //UPDATE BD
	 $res = $obj->deletePost();
	 
 	 if( $res == 1 ) {
	  	chmod( $root.$photo_id, 0777 );
		
		 //==== Delete image if exists
		 if ( file_exists( $root.$photo_id ) && $photo_id != '' ) {
			 unlink( $root.$photo_id );
		 }
	  	echo 'ok';
	  }
   }// IF POST ISSET
}// END IF SESSION ACTIVE
 ?>