<?php
session_start();
error_reporting(0);
if( 
		isset ( $_POST['offset']) 
		&& isset ( $_POST['number']) 
		&& isset ( $_POST['_userId']) 
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
	
	if( !$_SESSION['authenticated'] ) {
		$id_user_favs = 0;
	} else {
		$id_user_favs = $_SESSION['authenticated'];
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
	$infoUser         = $obj->infoUserLive( $id_user );
	$response         = $obj->getPostsFavs(
	'WHERE F.id_usr = '. $id_user .' && P.id '.$query.' '.$offset .'', 'LIMIT '.$postnumbers, $id_user_favs );
	$checkFollow       = $obj->checkFollow( $_SESSION['authenticated'], $id_user );
	
	$_countTotal = count( $response );
	$user        = $id_user;
	
	if( $_countTotal == 0 ) {
		$nofound = '<span class="notfound">No result</span>';
	}
	
	if( $infoUser->mode == 0 && $checkFollow[0]['status'] == 0 && $_SESSION['authenticated'] != $user ) {
		$response = null;
		$nofound  = null;
		$mode     = '<span style="padding: 25px 0; background: url('.URL_BASE.'public/img/private.png) right bottom no-repeat;" class="notfound">
		'.$_SESSION['LANG']['profile_private'].'</span>';
	}

	else {
		$response = $response;
		$mode     = null;
	}
	
	?>
	<?php $countPosts = count( $response );
   		 if( $countPosts != 0 ) : 
			 foreach ( $response as $key ) {
			 	
				$_idUser = $key['id_user'];
				
			 	if( $key['video_site'] != '' && $key['photo'] == '' ) {
					$typeMedia            = $_SESSION['LANG']['video'];
					$icon                 = '<i class="video_img_sm icons"></i>';
				} else if( $key['video_site'] == '' && $key['photo'] != '' ) {
					$typeMedia            = $_SESSION['LANG']['image'];
					$icon                 = '<i class="ico_img_sm icons"></i>';
				} else if( $key['url_soundcloud'] != '' ) {
					$typeMedia             = null;
			        $icon                  = '<i class="icon_song_min icons"></i>';
					
				} else {
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
				$widthPhoto = _Function::getWidth( URL_BASE.'upload/'.$key['photo'] ); 
				
				if( $widthPhoto > 440 ) {
					$thumbPic = 'thumb/450-450-';
				} else {
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
			}//<<--- Foreach
		  endif; // != 0
	 echo $mode;  
  }//<-- ISSET POST
}//<-- ISSET DATA
?>