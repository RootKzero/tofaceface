<?php
ini_set('memory_limit', '-1');
session_start();
error_reporting(0);
require('../../class_ajax_request/classAjax.php');
include('../../application/functions.php'); 
include('../../application/DataConfig.php');
$session_id  = $_SESSION['authenticated']; //$session id
$path        = "../../tmp/";
$path_bg = "../backgrounds/";
$obj         = new AjaxRequest();
$infoUser    = $obj->infoUserLive( $_SESSION['authenticated'] );
$bg_old      = $path_bg.$infoUser->bg;
$defaults    = array( '0.jpg', '1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg','10.jpg','11.jpg' );

if ( isset( $session_id ) ) 
{
	$valid_formats = array("jpg", "JPG", "jpeg","png","x-png","gif","pjpeg");
	if( isset( $_POST ) && $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photo']['name'];
			$size = $_FILES['photo']['size'];
			
			if( strlen( $name ) )
				{
					$ext = pathinfo( $name );
					if( in_array( $ext['extension'], $valid_formats ) )
					{
					if( $size < ( 1500 * 1500 ) )
						{
							$photo_post  = 'bg_'.strtolower( $infoUser->username )."_".$session_id.""._Function::randomString( 5, FALSE, TRUE, FALSE ).".".strtolower ( $ext['extension'] );
							$tmp = $_FILES['photo']['tmp_name'];
		
							if( move_uploaded_file( $tmp, $path.$photo_post ) )
								{
									//=============== 440 px =================//
									$width  = _Function::getWidth( $path.$photo_post );
									$height = _Function::getHeight( $path.$photo_post );
								
									$scale = 1;
									$uploaded = _Function::resizeImage( $path.$photo_post, $width, $height, $scale, $path.$photo_post );
								
									//<=//   PHOTO LARGE     =//>
									$photo_post_id = $photo_post;
									
									//==================================================//
									//=            * COPY FOLDER AVATAR /         *    =//		
									//==================================================//
									if ( file_exists( $path.$photo_post ) && isset( $photo_post_id ) )
									{
										copy( $path.$photo_post, $path_bg.$photo_post );
										unlink( $path.$photo_post );
										
									}//<--- IF FILE EXISTS	#2
									
									//<<<-- Delete old image -->>>/
									if ( file_exists( $bg_old ) && $infoUser->bg != '' && !in_array($infoUser->bg, $defaults) )
									{
										unlink( $bg_old );
									}//<--- IF FILE EXISTS #1
									
									//<<<--- * UPDATE DB * -->>>
									 $obj->updateTheme( $photo_post_id );
									
									

				echo json_encode( array ( 'output' => '', 'error' => 0, 'photo' => $photo_post ) ); 

}//<--- move_uploaded_file
							else
								{
									echo json_encode( array ( 'output' => $_SESSION['LANG']['error'], 'error' => 1 ) );
								}
							
						}
						else
							{
								echo json_encode( array ( 'output' => $_SESSION['LANG']['max_size_2'], 'error' => 1 ) );	
							}
						
										
						}
						else
							{
								echo json_encode( array ( 'output' => $_SESSION['LANG']['formats_available'], 'error' => 1 ) );
							}
							
				}
				
			else
				{
					echo json_encode( array ( 'output' => $_SESSION['LANG']['please_select_image'], 'error' => 1 ) );
				    exit;
				}
				
		}
	
}// SESSION ACTIVE
else 
{
	echo json_encode( array ( 'output' => $_SESSION['LANG']['error'], 'error' => 1, 'reload' => 1 ) );
	exit;
}
?>