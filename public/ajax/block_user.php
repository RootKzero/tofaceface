<?php
session_start();
error_reporting(0);
if ( 
	isset( $_POST['_userId'] ) 
	&& !empty( $_POST['_userId'] )
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
		$obj              = new AjaxRequest();
		$_POST['_userId'] = is_numeric( $_POST['_userId'] ) ? $_POST['_userId'] : die();
		
		$query = $obj->blockUser();
		
		if( $query == 1 ){
		 echo json_encode( array( 'status' => 'ok', 'res' => $_SESSION['LANG']['successfully_blocked'] ) );
	} else if( $query == 2 ){
		 echo json_encode( array( 'status' => 'ok', 'res' => $_SESSION['LANG']['unlocked_success'] ) );
	} else if( $query == 3 ){
		 echo json_encode( array( 'status' => 'ok', 'res' => $_SESSION['LANG']['successfully_blocked'] ) );
	} else {
		echo json_encode( array( 'status' => 'error', 'res' => $_SESSION['LANG']['error'] ) );
	}
  }//<-- SESSION
}//<-- if token id
?>