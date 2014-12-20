<?php
session_start();
error_reporting(0);

if ( 
	isset( $_POST['token'] ) 
	&& !empty( $_POST['token'] ) 
	&& isset( $_POST['id'] ) 
	&& !empty( $_POST['id'] )
) {
if ( isset( $_SESSION['authenticated'] ) ) {
	
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
	$_POST['token']    = trim( $_POST['token'] );
	$_POST['id']       = (int)trim( $_POST['id'] );
	
	$query = $obj->favorites();
	
	if( $query == 1 ){
		 echo '1';
	} else if( $query == 2 ){
		 echo '2';
	} else if( $query == 3 ){
		 echo '3';
	} else {
		return false;
	}
	
  }//<-- SESSION
}//<-- if token id
?>