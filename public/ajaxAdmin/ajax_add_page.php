<?php
session_start();
error_reporting(0);
if ( 
	isset ( $_POST['add_title'] ) 
	&& isset ( $_POST['add_url'] )
) {
if ( isset( $_SESSION['id_admon'] ) ) {
	$_POST['add_title'] = trim( ucfirst( $_POST['add_title'] ) );
	$_POST['add_url'] = trim( strtolower( $_POST['add_url'] ) );
	
	//<---  * REQUIRE * ----->
	require_once('../../class_ajax_request/classAjaxAdmin.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');
	
	if ( preg_match( '/[^a-z0-9\_]/i',$_POST['add_url'] ) ) {
			
			echo 'url';
		return false;
		}
	
	if( $_POST['add_content'] == '' && $_POST['add_content'] == 0 ) {
		$_POST['add_content'] = '';
	}

   //INSTANCE
$obj = new AjaxRequestAdmin();
$pagesGeneral = $obj->getAllPagesGeneral();
foreach ( $pagesGeneral as $key) {
			 $loop[] = $key['url']; 
		}

$staticPages = array( 
				    	'discover', 
				    	'connect', 
				    	'settings', 
				    	'profile', 
				    	'password', 
				    	'design', 
				    	'login',
				    	'messages',
				    	'recover',
				    	'validate',
				    	'interactions',
				    	
		);
	  
	  if( in_array( $_POST['add_url'] , $loop ) || in_array( $_POST['add_url'], $staticPages) ) {
			echo 'no';
		  return false;
		}
	  
     //UPDATE BD
	 $res = $obj->addPages();
	 
 	 if( $res == 1 ) {
	  	echo 'ok';
	  }
   }// IF POST ISSET
}// END IF SESSION ACTIVE
 ?>