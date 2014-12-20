<?php
session_start();
error_reporting(0);

if ( 
	isset ( $_POST['value']) 
	&& !empty( $_POST['id'] ) 
	&& isset ( $_POST['id']) 
) {
if ( isset( $_SESSION['id_admon'] ) ) {
	$_POST['value'] = is_numeric($_POST['value']) ? $_POST['value'] : die();
	$_POST['id']    = is_numeric($_POST['id']) ? $_POST['id'] : die();
	
	
	//<---  * REQUIRE * ----->
	require_once('../../class_ajax_request/classAjaxAdmin.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');

   //INSTANCE
$obj = new AjaxRequestAdmin();
	
     //UPDATE BD
	 $res = $obj->typeAccount();
	 
 	 if( $res == 1 ) {
	  	echo 'ok';
	  }
   }// IF POST ISSET
}// END IF SESSION ACTIVE
 ?>