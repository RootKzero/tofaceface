<?php
session_start();
error_reporting(0);

if( 
	isset( $_POST['_msgId'] ) 
	&& !empty( $_POST['_msgId'] )
)
{
  if ( isset( $_SESSION['authenticated'] ) ){
  	
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
	$obj              = new AjaxRequest();
	$_POST['_msgId']  = is_numeric( $_POST['_msgId'] ) ? $_POST['_msgId'] : die();
	
	$query = $obj->deleteMsg();
	
	if( $query == 1 ){
		 echo json_encode( array( 'status' => 1 ) );
	} else {
		 echo json_encode( array( 'status' => 0, 'error' => $_SESSION['LANG']['error'] ) );
	}
  }//<-- SESSION
}//<-- if token id
?>