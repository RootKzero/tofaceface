<?php
session_start();
error_reporting(0);

if ( 
	!empty( $_POST['id'] ) 
	&& isset ( $_POST['id'] ) 
) {
if ( isset( $_SESSION['id_admon'] ) ) {
	$_POST['id']    = is_numeric($_POST['id']) ? $_POST['id'] : die();
	
	
	//<---  * REQUIRE * ----->
	require_once('../../class_ajax_request/classAjaxAdmin.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');

   //INSTANCE
$obj         = new AjaxRequestAdmin();
$path_avatar = "../avatar/";
$infoUser    = $obj->infoUserLive( $_POST['id'] );
$imgOld      = $path_avatar.$infoUser->avatar;

     //UPDATE BD
	 $res = $obj->deleteAccount();
	 
 	 if( $res == 1 ) {
	  	if ( file_exists( $imgOld ) && $imgOld != $path_avatar.'avatar.png' ) {
				unlink( $imgOld );
			}
	  	echo 'ok';
	  }
   }// IF POST ISSET
}// END IF SESSION ACTIVE
 ?>