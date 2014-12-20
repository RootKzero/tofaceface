<?php
ini_set('memory_limit', '-1');
session_start();
error_reporting(0);
require('../../class_ajax_request/classAjax.php');
include('../../application/functions.php'); 
include('../../application/DataConfig.php');
$session_id    = $_SESSION['authenticated']; //$session id
$path          = "../../tmp/";
$path_cover    = "../cover/";
$obj           = new AjaxRequest();
$infoUser      = $obj->infoUserLive( $_SESSION['authenticated'] );
$coverOld      = $path_cover.$infoUser->cover_image;
$imgOldLarge   = $path_cover.'large_'.$infoUser->cover_image;

if ( isset( $session_id ) ) 
{
	$valid_formats = array("jpg", "JPG", "jpeg","png","x-png","gif","pjpeg");
	if( isset( $_POST ) && $_SERVER['REQUEST_METHOD'] == "POST") {
			$name = $_FILES['photo']['name'];
			$size = $_FILES['photo']['size'];
			
		if( strlen( $name ) ) {
					$ext = pathinfo( $name );
			
			if( in_array( $ext['extension'], $valid_formats ) ) {
			   if( $size < ( 2250 * 2250 ) ) {
			   	
				$randomHash  = _Function::randomString( 5, FALSE, TRUE, FALSE );		
				$photo_post  = 'cover_'.strtolower( $infoUser->username )."_".$session_id."".$randomHash.".".strtolower ( $ext['extension'] );
				$photo_large = 'large_cover_'.strtolower( $infoUser->username )."_".$session_id."".$randomHash.".".strtolower ( $ext['extension'] );
				$tmp         = $_FILES['photo']['tmp_name'];
				
				$dimensionsImage = getimagesize( $tmp );
				$widthImage      = $dimensionsImage[0];
				$heightImage     = $dimensionsImage[1];
						
			if( $widthImage >= 400 && $heightImage >= 200 ) {
						
					  if( move_uploaded_file( $tmp, $path.$photo_large ) ) {
					  	
						
						
						//=============== Image Large =================//
						$width  = _Function::getWidth( $path.$photo_large );
						$height = _Function::getHeight( $path.$photo_large );
						$max_width = '860';
						
						if( $width < $height ) {
							$max_width = '600';
						}
						
						if ( $width > $max_width ) {
							$scale = $max_width / $width;
							$uploaded = _Function::resizeImage( $path.$photo_large, $width, $height, $scale, $path.$photo_large );
						} else {
							$scale = 1;
							$uploaded = _Function::resizeImage( $path.$photo_large, $width, $height, $scale, $path.$photo_large );
						}
						
						_Function::resizeImageFixed( $path.$photo_large, 860, 260, $path.$photo_post );
						
						//<=//   PHOTO LARGE     =//>
						$photo_post_id = $photo_post;
						
						//==================================================//
						//=            * COPY FOLDER COVER /         *    =//		
						//==================================================//
						if ( file_exists( $path.$photo_post )  && isset( $photo_post_id ) ) {
							//<-------- * Cover 860x260 * ------->
							copy( $path.$photo_post, $path_cover.$photo_post );
							unlink( $path.$photo_post );
							
							/* Large Image */	
							copy( $path.$photo_large, $path_cover.$photo_large );
							unlink( $path.$photo_large );
						
						}//<--- IF FILE EXISTS	#2
						
						
						//<<<-- Delete old image -->>>/
						if ( file_exists( $coverOld ) 
							&& $infoUser->cover_image != '' 
							&& $photo_post_id 
						) {
							
							unlink( $coverOld );
						}//<--- IF FILE EXISTS #1
						
						if ( file_exists( $imgOldLarge ) ) {
								
							unlink( $imgOldLarge );
						}//<--- IF FILE EXISTS #1
						
						//<<<--- * UPDATE DB * -->>>
						$obj->uploadCover( $photo_post_id );
									
									

				echo json_encode( array ( 'output' => '', 'error' => 0, 'photo' => $photo_post ) ); 

}//<--- move_uploaded_file
							else {
									echo json_encode( array ( 'output' => $_SESSION['LANG']['error'], 'error' => 1 ) );
								}
	//<--- Width && Height
	} else {
	echo json_encode( array ( 'output' => $_SESSION['LANG']['width_height_min'], 'error' => 1 ) );	
}	
						} else {
								echo json_encode( array ( 'output' => $_SESSION['LANG']['max_size_5'], 'error' => 1 ) );	
							}
						
										
						} else {
								echo json_encode( array ( 'output' => $_SESSION['LANG']['formats_available'], 'error' => 1 ) );
							}
							
				}
				
			else {
					echo json_encode( array ( 'output' => $_SESSION['LANG']['please_select_image'], 'error' => 1 ) );
				    exit;
				}
				
		}
	
}// SESSION ACTIVE
else  {
	echo json_encode( array ( 'output' => $_SESSION['LANG']['error'], 'error' => 1, 'reload' => 1 ) );
	exit;
}
?>