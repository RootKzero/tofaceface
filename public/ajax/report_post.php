<?php
session_start();
error_reporting(0);
if ( 
	isset( $_POST['_postId'] ) 
	&& !empty( $_POST['_postId'] ) 
	&& isset( $_POST['_token'] ) 
	&& !empty( $_POST['_token'] )
)
{
  if ( isset( $_SESSION['authenticated'] ) )
	{
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
	$obj             = new AjaxRequest();
	$_POST['_token']  = trim( $_POST['_token'] );
	$_POST['_postId'] = is_numeric( $_POST['_postId'] ) ? $_POST['_postId'] : die();
	
	$query = $obj->reportPost();
	
	if( $query == 1 ){
		 echo json_encode( array( 'status' => 'ok', 'res' => $_SESSION['LANG']['successfully_reported'] ) );
	} else if( $query == 2 ){
		 echo json_encode( array( 'status' => 'ok', 'res' => $_SESSION['LANG']['error'] ) );
	} else if( $query == 3 ){
		 echo json_encode( array( 'status' => 'ok', 'res' => $_SESSION['LANG']['already_report'] ) );
	} else {
		echo json_encode( array( 'status' => 'error', 'res' => $_SESSION['LANG']['error'] ) );
	}
  }//<-- SESSION
}//<-- if token id
?>