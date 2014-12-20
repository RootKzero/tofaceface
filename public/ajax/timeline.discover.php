<?php
session_start();
if( 
		isset ( $_GET['since_id'] ) 
		&& !empty ( $_GET['since_id'] )
	
) {
	/*
	 * --------------------------
	 *   Require File
	 * -------------------------
	 */
	require_once('../../class_ajax_request/classAjax.php');
	include_once('../../application/functions.php'); 
	include_once('../../application/DataConfig.php');	

	if( isset( $_GET ) && $_SERVER['REQUEST_METHOD'] == "GET" && isset( $_SESSION['authenticated'] ) ) {
	 	$since_id     = is_numeric( $_GET['since_id'] ) ? $_GET['since_id'] : die();
		$_array       = array();
		/*
		 * ----------------------
		 *   Instance Class
		 * ----------------------
		 */
		$obj          = new AjaxRequest();
		$getPosts     = $obj->discover( 
			   'WHERE P.user != '. $_SESSION['authenticated'] .' 
			   && U.status = "active" && P.status = "1" && P.id > '.$since_id.' 
			   && U.mode = "1" && F.id IS NULL && P.repost_of_id = "0" 
			   GROUP BY P.id ORDER BY P.id ASC',
			    null , 
			    $_SESSION['authenticated']
			   );
	    
	    $count = count( $getPosts );
		if( $count != 0 ) {
			for ( $i = 0; $i < $count; ++$i ) {
				
				$_idUser = $getPosts[$i]['user_id'];
				
				if( $getPosts[$i]['repost_of_id'] != 0 ) {
				$nameUser                     = $getPosts[$i]['name'];
				$idPost                       = $getPosts[$i]['id'];
				$getPosts[$i]['type_account'] = $getPosts[$i]['rp_type_account'];
				$getPosts[$i]['username']     = $getPosts[$i]['rp_username'];
				$getPosts[$i]['name']         = $getPosts[$i]['rp_name'];
				$getPosts[$i]['avatar']       = $getPosts[$i]['rp_avatar'];
				$getPosts[$i]['user']         = $getPosts[$i]['rp_user'];
				$getPosts[$i]['id']           = $getPosts[$i]['rp_id'];
				
			} else {
				$nameUser                     = null;
				$idPost                       = $getPosts[$i]['id'];
				$getPosts[$i]['type_account'] = $getPosts[$i]['type_account'];
				$getPosts[$i]['username']     = $getPosts[$i]['username'];
				$getPosts[$i]['name']         = $getPosts[$i]['name'];
				$getPosts[$i]['avatar']       = $getPosts[$i]['avatar'];
				$getPosts[$i]['user']         = $getPosts[$i]['user'];
				$getPosts[$i]['id']           = $getPosts[$i]['id'];
				
		}
			/* Url */
			$urlStatus = URL_BASE.$getPosts[$i]['username'].'/status/'.$getPosts[$i]['id'];
				
			//<---- DELETE POST
		    if( $_SESSION['authenticated'] == $getPosts[$i]['user'] ) {
				$removePost = ' <a data-message="'.$_SESSION['LANG']['delete_post'].'" data-confirm="'.$_SESSION['LANG']['confirm'].'" class="trash" data="'.$getPosts[$i]['id'].'" data-token="'.$getPosts[$i]['token_id'].'"> <i class="trash_ico icons"></i> <span>'.$_SESSION['LANG']['trash'].'</span> </a>';
			} else {
				$removePost = null;
			}
			//<---- VERIFIED
			if( $getPosts[$i]['type_account'] == 1 ) {
				$verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">';
			} else {
				$verified = null;
			}
			//<---- TYPE MEDIA
			if( $getPosts[$i]['video_site'] != '' && $getPosts[$i]['photo'] == '' ) {
				$typeMedia            = $_SESSION['LANG']['video'];
				$icon                 = '<i class="video_img_sm icons"></i>';
			} else if( $getPosts[$i]['video_site'] == '' && $getPosts[$i]['photo'] != '' ) {
				$typeMedia            = $_SESSION['LANG']['image'];
				$icon                 = '<i class="ico_img_sm icons"></i>';
			} else if( $getPosts[$i]['url_soundcloud'] != '' ) {
				$typeMedia             = null;
		        $icon                  = '<i class="icon_song_min icons"></i>';
					
			} else {
				$typeMedia            = null;
				$icon                 = null;
			}
			/* Title Video */
			if( $getPosts[$i]['video_site'] != '' ) {
				$titleMedia = $getPosts[$i]['video_title'].' '. _Function::linkText( $getPosts[$i]['video_url'] );
			}
			
			/* Title Song */
			if( $getPosts[$i]['url_soundcloud'] != '' ) {
				$titleMedia = $getPosts[$i]['title_soundcloud'].'';
			}
			
			if( $getPosts[$i]['video_site'] == '' && $getPosts[$i]['post_details'] == '' && $getPosts[$i]['url_soundcloud'] == '' ) {
				$picImage = '<a data-view="'.$_SESSION['LANG']['details'].' &rarr;" data-url="'. $urlStatus.'" class="linkImage galeryAjax cboxElement" href="'.URL_BASE.'upload/'.$getPosts[$i]['photo'].'" rel="lightbox"> pic.thumb/'.$getPosts[$i]['photo'].' </a>';
			}

			if( $getPosts[$i]['repost_of_id'] != 0  ) {
				$repostUser = '<p style="font-size: 13px; color: #999; font-style: italic;">
										<img style="vertical-align: middle;" src="'.URL_BASE.'public/img/repost-ico.png" /> Reposted by '.$nameUser.'
										</p>';
			} else {
					$repostUser = null;
			}
			$activeRepost = $obj->checkRepost( $getPosts[$i]['id'], $_SESSION['authenticated'] );
			
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

			 if( isset( $_SESSION['authenticated'] ) && $getPosts[$i]['user'] !=  $_SESSION['authenticated'] ): 
			 $repostIcon = '<a data-rep="'.$_SESSION['LANG']['repost'].'" data-rep-active="'. $_SESSION['LANG']['reposted'].'" class="repost_button repostIcon" data="'.$getPosts[$i]['id'].'" data-token="'.$getPosts[$i]['token_id'].'">
				   					<i class="repost_ico icons '.$iconRepost.'"></i>
				   					<span'.$spanRepost.'>'.$textRepost.'</span>
			   					</a>';
			 endif;
			   			
			$_array[] = '<li class="hoverList" data="'.$idPost.'"> 
			<span class="paddingPost">
			<a href="'.URL_BASE.$getPosts[$i]['username'].'" class="openModal" data-id="'. $_idUser .'"> 
					<img class="avatar_user" src="'.URL_BASE.'thumb/48-48-public/avatar/'.$getPosts[$i]['avatar'].'"> </a> 
						<span class="detail_grid"> <span class="timestamp timeAgo" data="'.date('c', strtotime( $getPosts[$i]['date'] ) ).'"></span> 
					<a href="'.URL_BASE.$getPosts[$i]['username'].'" class="username openModal" data-id="'. $_idUser .'">'.stripslashes( $getPosts[$i]['name'] ).' '.$verified.' </a> 
				<strong class="usernameClass">@'.$getPosts[$i]['username'].'</strong> <p> '._Function::checkText( $getPosts[$i]['post_details'] ).' '.$titleMedia.' '.$picImage.' </p> 
			'.$repostUser.'
			<a data-expand="'.$_SESSION['LANG']['expand'].'" data-hide="'. $_SESSION['LANG']['hide'].'" class="expand getData" data="'.$getPosts[$i]['id'].'" data-token="'.$getPosts[$i]['token_id'].'"> '.$icon.' <span class="textEx">'.$_SESSION['LANG']['expand'].'</span> '.$typeMedia.'</a> 
				<a data-fav="'.$_SESSION['LANG']['favorite'].'" data-fav-active="'. $_SESSION['LANG']['favorited'].'" class="favorite favoriteIcon" data="'.$getPosts[$i]['id'].'" data-token="'.$getPosts[$i]['token_id'].'"> 
				<i class="favorite_ico icons"></i> <span>'.$_SESSION['LANG']['favorite'].'</span> </a> 
				'.$repostIcon.'
				'.$removePost.' 
					<!-- details-post --> 
			<span class="details-post"> </span><!-- details_post --> <!-- Grid Reply --> 
					<div class="grid-reply" style="display: none;"> 
				<form action="" method="post" accept-charset="UTF-8" id="form_reply_post"> 
			<input type="hidden" name="id_reply" id="id_reply" value="'.$getPosts[$i]['id'].'"> 
					<input type="hidden" name="token_reply" id="token_reply" value="'.$getPosts[$i]['token_id'].'"> 
						<textarea name="reply_post" id="reply_post"></textarea> 
					<div class="counter"></div> 
				<button id="button_reply" disabled="disabled" style="opacity: 0.5; cursor: default;" type="submit">'.$_SESSION['LANG']['reply'].'</button> </form> 
			</div><!-- Grid Reply --> </span><!-- paddingPost --> </span></li>';
		}//<--- * LOOP FOR * --->
	}//<<<-- COUNT != 0
		
		if( $count <= 1 ) {
		$new_posts = $_SESSION['LANG']['one_post_new'];
	} else if( $count >= 2 ) {
		$new_posts = $_SESSION['LANG']['post_new'];
	}
	
	echo json_encode( array ( 'posts' => $_array, 'total' => $count, 'html' => $new_posts ) ); 
	
	 }
}//<---isset ( $_GET['offset']) &&
 ?>