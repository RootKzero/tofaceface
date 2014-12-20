<?php
session_start();
error_reporting(0);
if ( 
		isset ( $_POST['add_post'] ) 
		&& !empty( $_POST['add_post'] ) 
		|| isset ( $_POST['photoId'] ) 
		&& !empty( $_POST['photoId'] ) 
		|| isset ( $_POST['video'] ) 
		&& !empty( $_POST['video'] )
		|| isset ( $_POST['song'] ) 
		&& !empty( $_POST['song'] ) 
) {
  if ( isset ( $_SESSION['authenticated'] ) ) {
		/*
		 * --------------------------
		 *   Require/Include Files
		 * -------------------------
		 */
		require_once('../../class_ajax_request/classAjax.php');
		include_once('../../application/functions.php'); 
		include_once('../../application/DataConfig.php');
		/*
		 * ----------------------------
		 * Instance Class
		 * ----------------------------
		 */
		$obj      = new AjaxRequest();
		$infoUser = $obj->infoUserLive( $_SESSION['authenticated'] );
		$admin    = $obj->getSettings();
		
		$path                 = "../../tmp/";
		$rootUpload           = '../../upload/';
		$photoID              = $_POST['photoId'];
		$urlSong              = trim( $_POST['song'] );
		$isValidUrlSoundCloud = _Function :: isValidSoundCloudURL( $urlSong ) ? 1 : 0;
		$dataSoundCloud       = _Function :: isValidSoundCloudURL( $urlSong );
		
		/*
		 *--------------------
		 * SOUNDCLOUD
		 * if soundCloud is true
		 * @$_POST['photoId'] == false
		 * @$_POST['video'] == false
		 *-------------------- 
		 */		 
		 if( $isValidUrlSoundCloud === 1 ) {
		 	$_POST['video']         = '';
			$_POST['song_title']    = $dataSoundCloud->{'title'}.' (SoundCloud)';
			$_POST['thumbnail_song'] = preg_replace( '/(\-t500x500|\-t120x120+)/', '-large', $dataSoundCloud->{'thumbnail_url'} );
			
			
			/* DELETE PHOTO UPLOAD */
            chmod( $rootUpload.$photoID, 0777 );
			 if ( file_exists( $path.$photoID ) && $photoID != '' ) {
					unlink( $path.$photoID );
					
				}//<--- IF FILE EXISTS
				
				$_POST['photoId'] = '';
		 }//<<-- if valid
		    
		if( $isValidUrlSoundCloud === 0 ) {
			$_POST['song_title'] = '';
			$_POST['song'] = '';
			$_POST['thumbnail_song'] = '';
		}

		$error             = 0;
		$_POST['token_id'] = _Function::idHash( $_SESSION['authenticated'] );
		$pos_details       = _Function::checkText( $_POST['add_post'] );
		$_POST['add_post'] = _Function::checkTextDb( $_POST['add_post'] );
		$urlVideo          = trim( $_POST['video'] );
		$isValidYoutube    = _Function::isValidYoutubeURL( $urlVideo ) ? 1: 0; // 1 Valid 0 Not Valid
		$dataVideoYoutube  = _Function::isValidYoutubeURL( $urlVideo ); 
		$isValidVimeoURL   = _Function::isValidVimeoURL( $urlVideo ) ? 1 : 0; // 1 Valid 0 Not Valid
		$dataVideoVimeo    = _Function::isValidVimeoURL( $urlVideo ); 
		$idVideoYoutube    = _Function::getYoutubeId( $urlVideo );
		
		
		/*
		 * -------------------------------------------
		 * If is greater than the default character 
		 * -------------------------------------------
		 */
		if( mb_strlen( $_POST['add_post'], 'utf8' ) > $admin->post_length  ) {
			$_POST['add_post'] = _Function::cropStringLimit( $_POST['add_post'], $admin->post_length );
			
		}
		
		/*
		 * -------------------------------------------
		 *                isValidYoutube
		 * -------------------------------------------
		 */
		if( $isValidYoutube ==  1 && $_POST['photoId'] == '' ) {
			$dataVideo                = $dataVideoYoutube->{'title'}.' (Youtube) ';
			$typeMedia                = $_SESSION['LANG']['video'];
			$icon                     = '<i class="video_img_sm icons"></i>';
			$_POST['video_code']      = $idVideoYoutube;
			$_POST['video_title']     = $dataVideoYoutube->{'title'}.' (Youtube) ';
			$_POST['video_site']      = 'youtube';
			$_POST['video_url']       =  _Function::bitLyUrl( 'http://www.youtube.com/watch?v='.$idVideoYoutube.'' );
			$_POST['video_thumbnail'] = 'http://img.youtube.com/vi/'.$idVideoYoutube.'/1.jpg';
		} else if( $isValidYoutube ==  1 && $_POST['photoId'] != '' ) {
			$_POST['video_code']      = '';
			$_POST['video_title']     = '';
			$_POST['video_site']      = '';		
			$_POST['video_url']       = 'http://youtu.be/'.$idVideoYoutube.'';
			$_POST['video_thumbnail'] = '';
			$typeMedia = $_SESSION['LANG']['image'];
			$icon = '<i class="ico_img_sm icons"></i>';
		
		}
		/*
		 * -------------------------------------------
		 *                isValidVimeoURL
		 * -------------------------------------------
		 */
		else if( $isValidVimeoURL ==  1 && $_POST['photoId'] == '' ) {
			$dataVideo                = $dataVideoVimeo->{'title'}.' (Vimeo) ';
			$typeMedia                = $_SESSION['LANG']['video'];
			$icon                     = '<i class="video_img_sm icons"></i>';
			$_POST['video_code']      = $dataVideoVimeo->{'video_id'};
			$_POST['video_title']     = $dataVideoVimeo->{'title'}.' (Vimeo) ';
			$_POST['video_site']      = 'vimeo';
			$_POST['video_url']       = _Function::bitLyUrl( 'http://vimeo.com/'.$dataVideoVimeo->{'video_id'}.'' );
			$_POST['video_thumbnail'] = preg_replace( '/(\_640|\_1280+)/', '_200', $dataVideoVimeo->{'thumbnail_url'} );
			
		}  else if ( $isValidVimeoURL ==  1 && $_POST['photoId'] != '' ) {
			$_POST['video_code']      = '';
			$_POST['video_title']     = '';
			$_POST['video_site']      = '';	
			$_POST['video_url']       = 'http://vimeo.com/'.$dataVideoVimeo->{'video_id'}.'';
			$_POST['video_thumbnail'] = '';
			$typeMedia = $_SESSION['LANG']['image'];
			$icon = '<i class="ico_img_sm icons"></i>';
			
		} else  {
			$_POST['video_code']      = '';
			$_POST['video_title']     = '';
			$_POST['video_site']      = '';
			$_POST['video_url']       = '';
			$_POST['video_thumbnail'] = '';
			$typeMedia = $_SESSION['LANG']['image'];
			$icon = '<i class="ico_img_sm icons"></i>';
		}
		
		//<-------- * NO SHOW ICON * ------>
		if( $isValidYoutube ==  0 && $isValidVimeoURL == 0 && $_POST['photoId'] == '' ) {
			$typeMedia = null;
			$icon      = null;
		}
		
		if( $isValidYoutube ===  0 
			&& $isValidVimeoURL === 0 
			&& $isValidUrlSoundCloud === 0
			&& mb_strlen( trim( $_POST['add_post'] ), 'utf8' ) == 0
			&& $_POST['photoId'] == '' 
		) {
			$error = 1;
			return false;
		}
		
		/* Get Width of Image upload */
                
		$widthPhoto = _Function::getWidth( URL_BASE.'upload/'.$_POST['photoId'] ); 
				
		if( $widthPhoto > 440 ) {
			$thumbPic = 'thumb/440-440-';
		} else  {
			$thumbPic = null;
		}
		
		//========= MEDIA SOUNDCLOUD
		if( $isValidUrlSoundCloud === 1 ) {

			$typeMedia             = '';
			$icon                  = '<i class="icon_song_min icons"></i>';

		 }//<<-- if valid
		
		/*
		 * ---------------------------------------------
		 *    If everything is OK publication insert
		 * --------------------------------------------
		 */	
		$response = $obj->insertPost();
			
		if( $infoUser->type_account == 1 ) {
		 $verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">'; 
	} else {
		 $verified = null; 
	}
	
		if( !empty( $response ) ) {
			
			//==================================================//
			//=            * COPY FOLDER UPLOAD /         *    =//		
			//==================================================//
		 	chmod( $rootUpload.$photoID, 0777 );
			 if ( file_exists( $path.$photoID ) && $photoID != '' ) {
					copy( $path.$photoID, $rootUpload.$photoID );
					unlink( $path.$photoID );
					
				}//<--- IF FILE EXISTS
				
				/* Url */
				$urlStatus = URL_BASE.$infoUser->username.'/status/'.$response;
           ?>
           <li class="hoverList">
			   		  <span class="paddingPost">
			   		  	<a href="<?php echo URL_BASE.$infoUser->username; ?>" data-id="<?php echo $_SESSION['authenticated']; ?>" class="openModal">
			   			<img class="avatar_user" src="<?php echo URL_BASE.'thumb/48-48-public/avatar/'.$infoUser->avatar; ?>">
			   			</a>
			   			<span class="detail_grid">
			   				<span class="timestamp timeAgo" data="<?php echo date('c', time()); ?>"></span>
			   				<a href="<?php echo URL_BASE.$infoUser->username; ?>" class="username openModal" data-id="data-id="<?php echo $_SESSION['authenticated']; ?>"">
			   					<?php echo stripslashes( $infoUser->name ).$verified; ?></a> 
			   					<strong class="usernameClass">@<?php echo $infoUser->username; ?></strong>
			   				<p>
			   				 	<?php  
			   				 	/* POST DETAILS */
			   				 	if( $pos_details != '' ) {
			   				 		echo $pos_details.' ';
			   				 	}
			   				 	
								/* DATA VIDEO */
			   				 	if( isset( $_POST['video'] ) 
				   				 	&& $_POST['video'] != '' 
				   				 	&& $isValidYoutube ==  1 
				   				 	|| isset( $_POST['video'] ) 
				   				 	&& $_POST['video'] != '' 
				   				 	&& $isValidVimeoURL == 1
								) {
									echo $dataVideo.' '. _Function::linkText( $_POST['video_url'] );
									
								}
								
								/* DATA SONG */
								if( $_POST['song_title'] != '' ) {
									echo $_POST['song_title'];
								}
								
								 if( $isValidYoutube == 0 && $isValidVimeoURL == 0 && isset ( $_POST['photoId'] ) && $_POST['photoId'] != '' && $_POST['add_post'] == '' ): ?>
			   					<a data-view='<?php echo $_SESSION['LANG']['details']; ?> &rarr;' data-url='<?php echo $urlStatus; ?>' href="<?php echo URL_BASE.'upload/'.$_POST['photoId']; ?>" class="linkImage galeryAjax cboxElement">
			   						<?php echo 'pic.thumb/'.$_POST['photoId']; ?>
			   						</a>
			   					<?php endif; ?>
			   				</p>
			   				
			   				<a data-expand="<?php echo $_SESSION['LANG']['expand']; ?>" data-hide="<?php echo $_SESSION['LANG']['hide']; ?>" class="expand getData" data="<?php echo $response; ?>" data-token="<?php echo $_POST['token_id']; ?>">
			   					<?php echo $icon; ?>
			   					<span class="textEx"><?php echo $_SESSION['LANG']['expand']; ?></span> <?php echo $typeMedia; ?>
			   					</a>
			   					
			   					<a data-fav="<?php echo $_SESSION['LANG']['favorite']; ?>" data-fav-active="<?php echo $_SESSION['LANG']['favorited']; ?>"class="favorite favoriteIcon" data="<?php echo $response; ?>" data-token="<?php echo $_POST['token_id']; ?>">
				   					<i class="favorite_ico icons"></i>
				   					<span><?php echo $_SESSION['LANG']['favorite']; ?></span>
			   					</a>
			   					
			   					<a data-message="<?php echo $_SESSION['LANG']['delete_post']; ?>" data-confirm="<?php echo $_SESSION['LANG']['confirm']; ?>" class="trash" data="<?php echo $response; ?>" data-token="<?php echo $_POST['token_id']; ?>">
				   					<i class="trash_ico icons"></i>
				   					<span><?php echo $_SESSION['LANG']['trash']; ?></span>
			   					</a>
			   					
			   				<!-- details-post -->
			   				<span class="details-post">
			   				</span><!-- details-post -->
			   				
			   				<!-- Grid Reply -->
			   		   <div class="grid-reply" style="display: none;"> 
			   				<form action="" method="post" accept-charset="UTF-8" id="form_reply_post">
			   					<input type="hidden" name="id_reply" id="id_reply" value="<?php echo $response; ?>">
			   					<input type="hidden" name="token_reply" id="token_reply" value="<?php echo $_POST['token_id']; ?>">
			   					<textarea name="reply_post" id="reply_post"></textarea>
			   					<div class="counter"></div> 
			   					<button id="button_reply" disabled="disabled" style="opacity: 0.5; cursor: default;" type="submit"><?php echo $_SESSION['LANG']['reply']; ?></button> 
			   					</form>
			   			 </div><!-- Grid Reply -->
			   		 </span><!-- detail_grid -->
			   	  </span><!-- paddingPost  -->
			   </li>
           <?php
      } else {
      	chmod( $path.$photoID, 0777 );
		 if ( file_exists( $path.$photoID ) && $photoID != '' ) {
			 	
			 unlink( $path.$photoID );
		 }
      }
   } else {
		echo '<script type="text/javascript">	
					$(document).ready(function(){
						window.location.reload();
			         });// END READY 
         </script>';
	}
}//<------ IF PARENT
 ?>