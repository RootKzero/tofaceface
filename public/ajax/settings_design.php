<?php
session_start();
error_reporting(0);
if ( 
		isset ( $_POST['pos']) 
		&& !empty( $_POST['pos'] ) 
		&& isset ( $_POST['link']) 
		&& isset ( $_POST['bg_color'])
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
	   $obj = new AjaxRequest();
	  include('../../application/functions.php'); 
	  include('../../application/DataConfig.php');	
	 
	  if( !isset ( $_POST['mosaic'] )  ){
	  	 $_POST['mosaic'] = 'scroll';
	  } else {
		  $_POST['mosaic'] = $_POST['mosaic'];
	  }
	  $_POST['pos']      = trim( $_POST['pos']);
	  $_POST['mosaic']   = trim( $_POST['mosaic']);
	  $_POST['link']     = trim( $_POST['link']);
	  $_POST['bg_color'] = trim( $_POST['bg_color']);

	
	 $res = $obj->updateDesignUser();
	 
	  echo json_encode( array( 'action' => 'true', 'save_success' => $_SESSION['LANG']['saved_successfully'] ) );
		
	}//<<-- Session
	else {
	 echo json_encode( array( 'action' => $_SESSION['LANG']['error'], 'session' => 0 ) );
}
}// IF POST ISSET
else {
	 echo json_encode( array( 'action' => $_SESSION['LANG']['error'] ) );
}
 ?>