<?php
session_start();
error_reporting(0);
if ( 
		isset ( $_POST['username'] ) 
		&& !empty( $_POST['username'] ) 
		&& isset ( $_POST['email'] ) 
		&& !empty( $_POST['email'] )
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
	   $obj = new AjaxRequest();
	  include_once('../../application/functions.php'); 
	  include_once('../../application/DataConfig.php');	
	 
	  $_POST['email']          = trim( $_POST['email']);
	  $_POST['mode']           = _Function::spaces( trim( $_POST['mode']) );
	  $_POST['username']       = _Function::spaces( trim( $_POST['username'] ) );
	  $_POST['country']        = _Function::spaces( trim( $_POST['country'] ) );
	  $infoUser                = $obj->infoUserLive( $_SESSION['authenticated'] );
	  $emailAddress            = $_POST['email'];
	  
	  //<<<--- Defaults Languages
	  foreach ( _Function :: arrayLang() as $key => $value ) {
	  	$defaultsLanguages[] = $value;
	  }
	
	  //<<<<--- Languages
	  if( !in_array( $_POST['lang'] , $defaultsLanguages ) ) {
	  	$_POST['lang'] = 'en';
	  } else {
	  	$_POST['lang'] = $_POST['lang'];
	  }
	  
	  if( $infoUser->language != $_POST['lang'] ) {
	  	unset( $_SESSION['lang_user'] );
		
		$_SESSION['lang_user'] = $_POST['lang'];
		$changeLang = 1;
	  } else {
	  	$changeLang = 0;
	  }
	  
	  //<<<<--- Username
	  if( $infoUser->username != $_POST['username'] ) {
	  	$changeUser = 1;
	  	$_POST['username'] = $_POST['username'];
		
	  } else {
	  	  $changeUser = 0;
		  $_POST['username'] = '';
	  }
	  
	  //<<<--- Email
	   if( $infoUser->email != $_POST['email'] ) {
	  	$changeMail = 1;
	  	$_POST['email'] = $_POST['email'];
		
	  } else {
	  	 $changeMail = 0;
		 $_POST['email'] = '';
	  }
	  
	  //<<<--- Email Notification msg private
	  if( isset(  $_POST['check_0']  ) ) {
	  	$_POST['check_0'] = '1';
	  } else {
	  	$_POST['check_0'] = '0';
	  }

	//<<<--- Email Notification follow me
	  if( isset(  $_POST['check_1']  ) ) {
	  	$_POST['check_1'] = '1';
	  } else {
	  	$_POST['check_1'] = '0';
	  }
	  
	  /* Validation */
		if ( preg_match( '/[^a-z0-9\_]/i',$_POST['username'] ) && $changeUser == 1 ){
				
			echo json_encode( array( 'action' => $_SESSION['LANG']['username_not_valid'], 'focus' => 'username' ) );
			
		} else if ( strlen( $_POST['username'] ) < 1 && $changeUser == 1 || strlen( $_POST['username'] ) > 15  && $changeUser == 1 ){
				
			echo json_encode( array( 'action' => $_SESSION['LANG']['username_not_valid'], 'focus' => 'username' ) );
			
		} else if ( !filter_var( $emailAddress, FILTER_VALIDATE_EMAIL )  && $changeMail == 1 ) {
				
			echo json_encode( array( 'action' => $_SESSION['LANG']['email_not_valid'], 'focus' => 'email' ) );
		} else {
			
		$res = $obj->updateSettings(); 
			 
		if( $res == 1 ) {
	  	echo json_encode( array( 'action' => 'true', 
	  	'output' => $_SESSION['LANG']['saved_successfully'], 
	  	'user' => $changeUser, 
	  	'new_user' => $_POST['username'],
	  	'langChange' => $changeLang
		) 
		);
		
	  } else if ( $res == 2 ) {
	  	
	 	echo json_encode( array( 'action' => $_SESSION['LANG']['username_already_use'] ) );
		
	 } else if ( $res == 3 ) {
	 	
	 	echo json_encode( array( 'action' => $_SESSION['LANG']['no_changes'] ) );
		
	 } else {
		 echo json_encode( array( 'action' => $_SESSION['LANG']['email_already_use'] ) );
		
	 }// ELSE
}// ELSE

/* Session */
} else {
	return false;
 } 
/* Isset Post */
} else {
	echo $_SESSION['LANG']['error'];
 } 
 ?>