<?php
session_start();
error_reporting(0);
if( 
		isset ( $_POST['offset']) 
		&& isset ( $_POST['number'])	
)
{
if ( isset ( $_SESSION['authenticated'] ) )
{
  if( isset( $_POST ) && $_SERVER['REQUEST_METHOD'] == "POST" )
   {
   	
   	/*
	 * ---------------------------------------
	 *   Valid $offset && Valid $postnumbers
	 * ---------------------------------------
	 */
	$offset                 = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
	$postnumbers            = is_numeric($_POST['number']) ? $_POST['number'] : die();
	
	/*
	 * ---------------------------------------
	 *   Query > ID || Query < ID
	 * ---------------------------------------
	 */
	if( $_POST['query'] == 1 )
	{
		$query = '<';
	}
	else 
	{
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
	$obj              = new AjaxRequest();
	$response         = $obj->discover(
	'WHERE P.user != '. $_SESSION['authenticated'] .' 
		   && U.status = "active" 
		   && P.status = "1" 
		   && B.id IS NULL 
		   && U.mode = "1" 
		   && P.id '.$query.' '.$offset .' 
		   && P.repost_of_id = "0"
		   && F.id IS NULL 
		   GROUP BY P.id ORDER BY P.id DESC', 
		   'LIMIT '.$postnumbers,
		    $_SESSION['authenticated'] );
	
	?>
	<?php $countPosts = count( $response );
   		 if( $countPosts != 0 ) : 
			 foreach ( $response as $key ) {
			 	
				$idPost  = $key['id'];
				$_idUser = $key['user_id'];
				 
			 	if( $key['video_site'] != '' && $key['photo'] == '' ) {
					$typeMedia            = $_SESSION['LANG']['video'];
					$icon                 = '<i class="video_img_sm icons"></i>';
				} else if( $key['video_site'] == '' && $key['photo'] != '' ) {
					$typeMedia            = $_SESSION['LANG']['image'];
					$icon                 = '<i class="ico_img_sm icons"></i>';
				} else if( $key['url_soundcloud'] != '' ) {
					$typeMedia             = null;
			        $icon                  = '<i class="icon_song_min icons"></i>';
					
				} else  {
					$typeMedia            = null;
					$icon                 = null;
				}
				//============ VERIFIED
				if( $key['type_account'] == '1' ) {
					$verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">';
				} else {
					$verified = null;
				}
				//============ FAVORITES
				if( $key['favoriteUser'] == 1 ) {
					$iconFav      = ' iconfavorited';
					$spanFav      = ' class="favorited" title="'.$_SESSION['LANG']['trash'].' '.$_SESSION['LANG']['favorite'].'"';
					$spanAbsolute = '<span class="add_fav"></span>';
					$textFav      = $_SESSION['LANG']['favorited'];
				} else {
					$iconFav      = null;
					$spanFav      = null;
					$spanAbsolute = null;
					$textFav      = $_SESSION['LANG']['favorite'];
				}
				
				/*
				 * -------------------------------------------------
				 *      If the picture is larger than 440 pixels, 
				 *      show the thumbnail
				 * -------------------------------------------------
				 */
				$widthPhoto = _Function::getWidth( '../../upload/'.$key['photo'] ); 
				
				if( $widthPhoto > 440 ) {
					$thumbPic = 'thumb/450-450-';
				} else  {
					$thumbPic = null;
				}
				
				/* Url */
				$urlStatus = URL_BASE.$key['username'].'/status/'.$key['id'];
				
				$activeRepost = $obj->checkRepost( $key['id'], $_SESSION['authenticated'] );
				
				//============ REPOST SESSION CURRENT
				if( $activeRepost == 1  ) {
					$iconRepost   = ' iconRepost';
					$spanRepost   = ' class="repostedSpan"';
					$textRepost   = $_SESSION['LANG']['reposted'];
				} else  {
					$iconRepost   = null;
					$spanRepost   = null;
					$textRepost   = $_SESSION['LANG']['repost'];
				}
				
				/*
				 * -------------------------------------
				 *  POST DETAILS / EXPAND / FAVS ETC
				 * -------------------------------------
				 */
				include( 'post_details.php' );
				
			}//<--- Foreach
 endif; //<--- != 0
     }//<-- SESSION
  }//<-- if token id
}//<-- ISSET
?>