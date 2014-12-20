<?php
session_start();
if( isset( $_SESSION['authenticated'] ) ) {
	/*
	 * --------------------------
	 *   Require/Include Files
	 * -------------------------
	 */
	require_once('../../class_ajax_request/classAjax.php');

if( isset( $_GET ) && $_SERVER['REQUEST_METHOD'] == "GET" ) {
		
	/*
	 * ----------------------
	 *   Instance Class
	 * ----------------------
	 */
	$obj                 = new AjaxRequest();
	$notificationsMsg    = $obj->notificationsMessages();
	$notificationsIntera = $obj->notificationsInteractions();
	
	if( $notificationsMsg->total == null ){
		$notificationsMsg->total = '0';
	}
	
	if( $notificationsIntera->total == null ){
		$notificationsIntera->total = '0';
	}
 
echo json_encode( array ( 'messages' => $notificationsMsg->total, 'interactions' => $notificationsIntera->total ) ); 

 }
} else {
	echo json_encode( array ( 'error' => 1 ) ); 
}
 ?>