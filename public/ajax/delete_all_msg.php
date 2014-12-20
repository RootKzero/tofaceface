<?php
session_start();
error_reporting(0);

if( 
	isset( $_POST['_userId'] ) 
	&& !empty( $_POST['_userId'] )
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
	$_POST['_userId']  = is_numeric( $_POST['_userId'] ) ? $_POST['_userId'] : die();
	
	$query = $obj->deleteAllMsg();
	
	if( $query == 1 ){
		 echo json_encode( array( 'status' => 1 ) );
	} else {
		 echo json_encode( array( 'status' => 0, 'error' => $_SESSION['LANG']['error'] ) );
	}
  }//<-- SESSION
}//<-- if token id
?>