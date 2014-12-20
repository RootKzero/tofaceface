<?php
session_start();
error_reporting(0);
if ( 
		isset ( $_POST['user'] ) 
		&& !empty( $_POST['user'] ) 
		&& isset ( $_POST['password'] ) 
) {
if ( !isset( $_SESSION['authenticated'] ) ) {
	   /*
		 * --------------------------
		 *   Require/Include Files
		 * -------------------------
		 */		
	   require_once('../../class_ajax_request/classAjax.php');
	   include_once('../../application/functions.php'); 
	   include_once('../../application/DataConfig.php');	
		 /*
		 * ----------------------
		 *   Instance Class
		 * ----------------------
		 */
	   $obj = new AjaxRequest();
	  
	  $_POST['user']      = trim( _Function::spaces( $_POST['user'] ) );
	  $_POST['password']  = trim( _Function::spaces( $_POST['password'] ) );
	  $emailAddress       = $_POST['user'];

		if ( $_POST['user'] == '' || strlen( $_POST['user'] ) == 0 ) {
				
			echo '<strong>Field</strong> is required.';
		} else if ( preg_match( '/[^a-z0-9\_]/i',$_POST['user'] ) && !filter_var( $emailAddress, FILTER_VALIDATE_EMAIL ) ) {
				
			echo $_SESSION['LANG']['username_email_not_invalid'];
		} else if ( mb_strlen( $_POST['password'], 'utf8' ) < 5 || mb_strlen( $_POST['password'], 'utf8' ) > 20 ) {
				
			echo $_SESSION['LANG']['pass_not_invalid'];
		} else {
			
			 $res    = $obj->signIn();
			 if( isset( $res['id'] ) ){
			 	echo 'True';
			 	$_SESSION['username']      = $res['username'];
			 	$_SESSION['authenticated'] = $res['id'];
				$_SESSION['lang_user']     = $res['language'];
		} else {
		 echo  $_SESSION['LANG']['account_not_active'];
		}// ELSE
}// ELSE
 } else {
		echo '<script type="text/javascript">	
					$(document).ready(function(){
						window.location.reload();
			         });// FIN READY 
         </script>';
	}
} else {
	echo $_SESSION['LANG']['error'];
	
}
 ?>