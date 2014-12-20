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
	} else  {
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
	$response         = $obj->getAllPosts(
		'WHERE P.user = '.$id_user.'
			&& P.status = "1"
			&& P.status_general = "1"
			&& U.status = "active"
			&& P.id '.$query.' '.$offset .'
			GROUP BY P.id DESC ', 
		'LIMIT '.$postnumbers, 
		$id_user_favs 
	);
	$checkFollow      = $obj->checkFollow( $_SESSION['authenticated'], $id_user );
	
	$_countPosts = count( $response );
	
	if( $_countPosts == 0 ) {
		$nofound = '<span class="notfound">No posts to display</span>';
	}
	$user     = $id_user;
	
	if( $infoUser->mode == 0 
		&& $checkFollow[0]['status'] == 0 
		&& $_SESSION['authenticated'] 
		!= $user  
	) {
		$response = null;
		$nofound  = null;
		$mode     = '<span style="padding: 25px 0; background: url('.URL_BASE.'public/img/private.png) right bottom no-repeat;" class="notfound">
		'.$_SESSION['LANG']['profile_private'].'</span>';
	} else {
		$response = $response;
		$mode     = null;
	}
	
	$countPosts = count( $response );
   	  if( $countPosts != 0 ) : 
			 foreach ( $response as $key ) {
			 	
				
				if( $key['repost_of_id'] != 0 ) {
					$nameUser            = $key['name'];
					$key['type_account'] = $key['rp_type_account'];
					$key['username']     = $key['rp_username'];
					$key['name']         = $key['rp_name'];
					$key['avatar']       = $key['rp_avatar'];
					$key['user']         = $key['rp_user'];
					$idPost              = $key['id'];
					$key['id']           = $key['rp_id'];
					$_idUser             = $key['rp_id_user'];
					
				} else {
					$nameUser            = null;
					$key['type_account'] = $key['type_account'];
					$key['username']     = $key['username'];
					$key['name']         = $key['name'];
					$key['avatar']       = $key['avatar'];
					$key['user']         = $key['user'];
					$idPost              = $key['id'];
					$key['id']           = $key['id'];
					$_idUser             = $key['user_id'];
				}
				
				/* Url */
				$urlStatus = URL_BASE.$key['username'].'/status/'.$key['id'];
				
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
				} else  {
					$verified = null;
				}
				
				//============ FAVORITES
				if( $key['favoriteUser'] == 1 ) {
					$iconFav      = ' iconfavorited';
					$spanFav      = ' class="favorited" title="'.$_SESSION['LANG']['trash'].' '.$_SESSION['LANG']['favorite'].'"';
					$spanAbsolute = '<span class="add_fav"></span>';
					$textFav      = $_SESSION['LANG']['favorited'];
				} else  {
					$iconFav      = null;
					$spanFav      = null;
					$spanAbsolute = null;
					$textFav      = $_SESSION['LANG']['favorite'];
				}
				$activeRepost = $obj->checkRepost( $key['id'], $_SESSION['authenticated'] );
				
				//============ REPOST SESSION CURRENT
				if( $activeRepost == 1 ) {
					$iconRepost   = ' iconRepost';
					$spanRepost   = ' class="repostedSpan"';
					$textRepost   = $_SESSION['LANG']['reposted'];
				} else  {
					$iconRepost   = null;
					$spanRepost   = null;
					$textRepost   = $_SESSION['LANG']['repost'];
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
				/*
				 * -------------------------------------
				 *  POST DETAILS / EXPAND / FAVS ETC
				 * -------------------------------------
				 */
				include( 'post_details.php' );
				
				 }//<<<--- Foreach
            endif; //<<<---- $countPosts != 0
       echo $mode;	  
     }//<-- ISSET POST
}//<-- ISSET DATA
?>