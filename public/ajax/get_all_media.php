<?php
session_start();
error_reporting(0);
if( 
		isset ( $_POST['offset'] ) 
		&& isset ( $_POST['number'] ) 
		&& isset ( $_POST['_userId'] ) 
		&& !empty( $_POST['_userId'] )
) {
 if( isset( $_POST ) && $_SERVER['REQUEST_METHOD'] == "POST" ) {
   	
   	/*
	 * --------------------------------------------------
	 *   Valid $offset, $id_user && Valid $postnumbers
	 * --------------------------------------------------
	 */
	$offset                 = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
	$postnumbers            = is_numeric($_POST['number']) ? $_POST['number'] : die();
    $id_user                = is_numeric($_POST['_userId']) ? $_POST['_userId'] : die();
	
	/*
	 * ---------------------------------------
	 *   Query > ID || Query < ID
	 * ---------------------------------------
	 */
	if( $_POST['query'] == 1 ) {
		$query = '<';
	} else {
		$query = '>';
	}
	
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
	$obj         = new AjaxRequest();
	$infoUser    = $obj->infoUserLive( $id_user );
	$response    = $obj->getAllMedia( $id_user, ' && P.id '.$query.' '.$offset .'', 'LIMIT '.$postnumbers );
	$checkFollow = $obj->checkFollow( $_SESSION['authenticated'], $id_user );
	
	$_countPosts = count( $response );
	
	if( $_countPosts == 0 )
	{
		$nofound = '<span class="notfound">No posts to display</span>';
	}
	$user     = $id_user;
	if( $infoUser->mode == 0 && $checkFollow[0]['status'] == 0 && $_SESSION['authenticated'] != $user  )
	{
		$response = null;
		$nofound  = null;
		$mode     = '<span style="padding: 25px 0; background: url('.URL_BASE.'public/img/private.png) right bottom no-repeat;" class="notfound">
		'.$_SESSION['LANG']['profile_private'].'</span>';
	}

	else
	{
		$response = $response;
		$mode     = null;
	}
	?>
	<?php $countMedia = count( $response );
   		 if( $countMedia != 0 ) : 
			 foreach ( $response as $key ) {
			 	
				++$num;
				if( $num % 5 ) {
					$style = null;
				} else {
					 $style = ' class="last"';
				}
				
				/* Url */
				$urlStatus = URL_BASE.$infoUser->username.'/status/'.$key['id'];

				if( $key['photo'] != '' ) {
					$img       = '<img src="'.URL_BASE.'thumb_fixed/90-90-upload/'.$key['photo'].'" />';
					$url       = 'href="'.URL_BASE.'upload/'.$key['photo'].'"';
					$lightbox  = 'rel="lightbox[photos]"';
					$spanVideo = null;
					$title     = null;//''.$key['post_details'].'';
					$typeMedia = 'media_galery';
				} else if( $key['url_soundcloud'] != '' ) {
					$img       = '<img width="90" height="90" src="'.$key['thumbnail_song'].'" />';
					$url       = 'href="https://w.soundcloud.com/player/?url='.$key['url_soundcloud'].'"';
					$lightbox  = null;
					$target    = 'target="_blank"';
					$spanVideo = '<span class="soundCloud"></span>';
					$title     = null;
					$typeMedia = 'soundcloud media_galery';
					
				} else {
					if( $key['video_site'] == 'youtube' ) {
						$key['video_url'] = 'http://www.youtube.com/v/'.$key['video_code'].'?rel=0&wmode=transparent'; 
						
					} else {
						$key['video_url'] = 'http://player.vimeo.com/video/'.$key['video_code'].'';
					}
						$img       = '<img style="left: -20px; position: relative;" width="120" src="'.$key['video_thumbnail'].'" />';
						$url       = 'href="'.$key['video_url'].'"';
						$lightbox  = null;
						$target    = 'target="_blank"';
						$spanVideo = '<span class="video_'.$key['video_site'].'"></span>';
						$title     = null;//''.$key['video_title'];
						$typeMedia = $key['video_site'].' media_galery';
					
				}
				
				?>
				 <li data="<?php echo $key['id'] ?>" class="hoverList">
					<a data-view="<?php echo $_SESSION['LANG']['details']; ?> &rarr;" data-url="<?php echo $urlStatus; ?>" class="<?php echo $typeMedia; ?> cboxElement allMedia" title="<?php echo $title; ?>" <?php echo $url; ?> <?php echo $target; ?>>
						<?php echo $spanVideo; ?>
						<?php echo $img; ?>
					</a>
				</li>
				 <?php }//<<<--- Foreach
		   endif;//<<<-- Count != 0
				echo $mode; 
     }//<-- ISSET POST
}//<-- ISSET DATA
?>