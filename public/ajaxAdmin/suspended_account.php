<?php
session_start();
error_reporting(0);

if ( 
	!empty( $_POST['id'] ) 
	&& isset ( $_POST['id']) 
) {
if ( isset( $_SESSION['id_admon'] ) ) {
	$_POST['id']    = is_numeric($_POST['id']) ? $_POST['id'] : die();
	
	
	//<---  * REQUIRE * ----->
	require_once('../../class_ajax_request/classAjaxAdmin.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');

   //INSTANCE
$obj = new AjaxRequestAdmin();
	
     //UPDATE BD
	 $res = $obj->suspendedAccount();
	 
 	 if( $res == 1 ) {
	  	echo 'ok';
	  }
   }// IF POST ISSET
}// END IF SESSION ACTIVE
 ?>