<?php
session_start();
error_reporting(0);

if ( 
	isset ( $_POST['pass'])
) {
if ( isset( $_SESSION['id_admon'] ) ) {
	
	//<---  * REQUIRE * ----->
	require_once('../../class_ajax_request/classAjaxAdmin.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');

   //INSTANCE
	$obj = new AjaxRequestAdmin();
	
     //UPDATE BD
	 $res = $obj->passwordChange();
	 
 	 if( $res == 1 ) {
	  	echo 'ok';
	  }
   }// IF POST ISSET
}// END IF SESSION ACTIVE
 ?>