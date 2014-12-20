<?php
session_start();
error_reporting(0);
if( 
		isset ( $_GET['postId'] ) 
		&& isset ( $_GET['token'] )
) {

  if( isset( $_GET ) && $_SERVER['REQUEST_METHOD'] == "GET" ) {
   	
	$favoriteArr = array();
	$replyArr    = array();
   	
	$_postId = is_numeric( $_GET['postId'] ) ? $_GET['postId'] : die();
	$_token  = !preg_match('/[^a-z0-9-\_\.]/i', $_GET['token'] ) ? $_GET['token'] : die();
	
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
	$obj            = new AjaxRequest();
	$getMedia       = $obj->getMedia( $_postId, $_token );
	$getFavorites   = $obj->getFavorites( $_postId );
	$countFavs      = count( $getFavorites );
	$getReply       = $obj->getReply( $_postId );
	$countReply     = count( $getReply );
	$verifyPost     = $obj->checkPost( $_postId, $_token ) ? 1 : 0;
	$getRepost      = $obj->getRepostUser( $_postId );
	
	/* Url */
	$urlStatus = URL_BASE.$getMedia[0]['username'].'/status/'.$getMedia[0]['id'];
	
	/*
	 * --------------------
	 * Verify Post
	 * --------------------
	 */
	 if( $verifyPost == 0 ) {
	 	return false;
	 }
	
	//================================================//
	//                   * Favorites *               =//
	//================================================//
	if( $countFavs != 0 ) {
		for ( $i = 0; $i < $countFavs; ++$i ) { 
			$favoriteArr[] = '<a class="south openModal" data-id="'.$getFavorites[$i]['id'].'" title="@'.$getFavorites[$i]['username'].'" href="'.URL_BASE.$getFavorites[$i]['username'] .'"><img src="'.URL_BASE.'thumb/24-24-public/avatar/'.$getFavorites[$i]['avatar'] .'" /></a>';
		}
	}//<--- 
	
	//================================================//
	//                   * Replys *                  =//
	//================================================//
	if( $countReply != 0 ) {
		for ( $u = 0; $u < $countReply; ++$u ) {
			//<--- * User Verified * --->
			if( $getReply[$u]['type_account'] == 1 ) {
					$verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">';
				} else  {
					$verified = null;
				}
				//<--- * Delete Reply* --->
			if( $_SESSION['authenticated'] == $getReply[$u]['id'] ) {
					$removeReply = ' <i title="'.$_SESSION['LANG']['delete'].'" data="'.$getReply[$u]['idReply'].'" class="trash_ico_reply removeReply"></i>';
				} else {
					$removeReply = null;
				}
			
			$replyArr[] = "<span class='spanReply'>".$removeReply."<span class='paddingReply'>
			<a href='".URL_BASE.$getReply[$u]['username']."' class='openModal' data-id='".$getReply[$u]['id']."'>
				<img class='avatar_user' src='".URL_BASE.'thumb/30-30-public/avatar/'.$getReply[$u]['avatar']."'>
			</a>
			 <span class='replyContainer'> <span class='timestamp timeAgo' data='".date('c', strtotime( $getReply[$u]['date'] ) )."'>
			 </span> <a href='".URL_BASE.$getReply[$u]['username']."' class='userR openModal' data-id='".$getReply[$u]['id']."'>".stripslashes( $getReply[$u]['name'] ).$verified."</a> 
			 <strong class='usernameClass'>@".$getReply[$u]['username']."</strong> <p>"._Function::checkText( $getReply[$u]['reply'] )."</p>
			 </span></span> </span><!-- SPAN REPLY -->";
		}
	}//<---
	
	$widthPhoto = _Function::getWidth( '../../upload/'.$getMedia[0]['photo'] ); 
				
	if( $widthPhoto > 450 ) {
		$thumbPic = 'thumb/450-450-';
	} else  {
		$thumbPic = null;
	}
	
	//==== PHOTO	
	if( $getMedia[0]['photo'] != ''  ) {
		$media = "<span class='container-media'> <a data-view='".$_SESSION['LANG']['details']." &rarr;' data-url=".$urlStatus." class='galeryAjax cboxElement' href='".URL_BASE."upload/".$getMedia[0]['photo']."'> <img class='photoPost' src='".URL_BASE.$thumbPic."upload/".$getMedia[0]['photo']."'> </a></span>";
	}
	
	//==== VIDEO VIMEO
	if( $getMedia[0]['video_site'] == 'vimeo'  ) {
		$media = '<span class="container-media"> <iframe src="http://player.vimeo.com/video/'.$getMedia[0]['video_code'].'" width="450" height="360" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></span>';
	}

	//==== VIDEO YOUTUBE
	if( $getMedia[0]['video_site'] == 'youtube'  ) {
		$media = '<span class="container-media"> <iframe width="450" height="360" src="http://www.youtube.com/embed/'.$getMedia[0]['video_code'].'" frameborder="0" allowfullscreen></iframe></span>';
	}
	
	//==== SOUNDCLOUD
	if( $getMedia[0]['url_soundcloud'] != ''  ) {
		$media = '<span class="container-media"> <iframe width="100%" height="120" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$getMedia[0]['url_soundcloud'].'"></iframe></span>';
	}
	
	//====== FAVORITES
	if( $countFavs != 0 ) {
		if( $countFavs == 1 ) {
			$s =  null;
		} else  {
			$s = 's';
		}
		
	//====== Repost
	if( $getRepost[0]['totalRepost'] != 0 ) {
		$repost = "| <strong>".$getRepost[0]['totalRepost']."</strong> ".$_SESSION['LANG']['reposted']."";
	} else {
		$repost = null;
	}
	
		$favorites = "<span class='favorites_user'> <span class='favs_title'><strong>".$countFavs."</strong> ".$_SESSION['LANG']['favorites']." ".$repost."</span></span>";
	}//<<<------- Favorites != 0
	
	if( $countFavs == 0 && $getRepost[0]['totalRepost'] != 0 ) {
		
		$favorites = "<span class='favorites_user'> <span class='favs_title' style='border:none; padding: 0; margin: 0;'><strong>".$getRepost[0]['totalRepost']."</strong> ".$_SESSION['LANG']['reposted']."</span></span>";

	}

	/* Report Post */
	if(  isset( $_SESSION['authenticated'] ) && $_SESSION['authenticated'] != $getMedia[0]['user'] ) {
		$report    = '<span class="iReport reportPost" data="'.$getMedia[0]['id'].'" data-token="'.$getMedia[0]['token_id'].'"><a>'.$_SESSION['LANG']['report'].'</a></span>';
	
	}
	
	
	//<----- Output data
	echo json_encode( array ( 
			'media' => $media.$favorites.'<!-- details - report --> 
			<span class="details_report"> 
			   <span class="iDetails">
			     '.date('d/m/Y', strtotime( $getMedia[0]['date'] ) ).' - <a href="'.URL_BASE.$getMedia[0]['username'].'/status/'.$getMedia[0]['id'].'">'.$_SESSION['LANG']['details'].'</a> 
			</span>
			'.$report." 
			</span><!-- details - report -->", 
			'favs' => $favoriteArr, 
			'error' => 0, 
			'replys' => $replyArr 
	) 
	); 

  }//<---- ISSET GET
}//<-- ISSET
?>