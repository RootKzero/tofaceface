<?php
session_start();
error_reporting(0);

if ( 
	isset ( $_POST['title']) 
	&& !empty( $_POST['title'] ) 
	&& isset ( $_POST['message_length']) 
	&& isset( $_POST['post_length'] )
) {
if ( isset( $_SESSION['id_admon'] ) ) {
	$_POST['message_length'] = is_numeric($_POST['message_length']) ? $_POST['message_length'] : die();
	$_POST['post_length']    = is_numeric($_POST['post_length']) ? $_POST['post_length'] : die();
	
	
	//<---  * REQUIRE * ----->
	require_once('../../class_ajax_request/classAjaxAdmin.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');

   //INSTANCE
$obj = new AjaxRequestAdmin();
	
     //UPDATE BD
	 $res = $obj->settingsGeneral();
	 
 	 if( $res == 1 ) {
	  	echo 'ok';
	  }
   }// IF POST ISSET
}// END IF SESSION ACTIVE
 ?>