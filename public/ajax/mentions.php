<?php
session_start();
error_reporting(0);
if( 
	isset ( $_GET['filter'] )
) {
  if( isset( $_GET ) && $_SERVER['REQUEST_METHOD'] == "GET" ) {
	
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
	$obj              = new AjaxRequest();
	$response         = $obj->searchUsersMentions( $_GET['filter'], ' 
	&& U.status = "active"', 'LIMIT 5 ', $_SESSION['authenticated'] );

	
	$countPosts      = count( $response );
	$countPostsTotal = count( $responseTotal );
	$words           = str_replace( '#', '%23', strip_tags( $_GET['filter'] ) );
	
   if( $countPosts != 0 ) :
	   
   foreach ( $response as $key ) {
			 	
		//============ VERIFIED
		if( $key['type_account'] == '1' ) {
			$verified = ' <img style="vertical-align: middle;" src="'.URL_BASE.'public/img/verified_min.png">';
		} else {
			$verified = null;
		}
	 
	 	$arrayLoop[] = 	array( 
				'name' => stripslashes( $key['name'] ) . $verified,
				'username' => $key['username'], 
				"avatar" => $key['avatar']
		);
		} 
   $array = array( 
			"tags" => $arrayLoop
		 );
		 
		 echo json_encode( $array );
		 
   else: 
	    $array = array( 
			"tags" => 0
		 );
		 
	    echo json_encode( $array );
		endif;  //<<<--- $countPosts != 0
     }//<--
}//<-- ISSET
?>