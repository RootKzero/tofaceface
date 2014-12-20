<?php
session_start();
error_reporting(0);
if ( 
	isset( $_GET['_replyId'] ) 
	&& !empty( $_GET['_replyId'] )
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
		$obj               = new AjaxRequest();
		$_GET['token_id'] = trim( $_GET['token_id'] );
		$_GET['id']       = is_numeric( $_GET['_replyId'] ) ? $_GET['_replyId'] : die();
		
		$query = $obj->deleteReply();
		
		if( $query == 1 )
		{
			
			 echo( 1 );
		}//<--- $QUERY
  }//<-- SESSION
}//<-- if token id
?>