<?php
session_start();
error_reporting(0);
if( 
		isset ( $_GET['offset']) 
		&& isset ( $_GET['number'])
	
)
{
if ( isset( $_SESSION['authenticated'] ) )
{
  if( isset( $_GET ) && $_SERVER['REQUEST_METHOD'] == "GET" )
   {
   	
   	/*
	 * --------------------------------------------------
	 *   Valid $offset && Valid $postnumbers
	 * --------------------------------------------------
	 */
	$offset                 = is_numeric($_GET['offset']) ? $_GET['offset'] : die();
	$postnumbers            = is_numeric($_GET['number']) ? $_GET['number'] : die();
	
	/*
	 * ---------------------------------------
	 *   Query > ID || Query < ID
	 * ---------------------------------------
	 */
	if( $_GET['query'] == 1 ) {
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
	$obj      = new AjaxRequest();
	$response = $obj->getAllPosts('
	WHERE P.user = '.$_SESSION['authenticated'] .'
			&& P.status = "1"
			&& U.status = "active"
	&& P.id '.$query.' '.$offset .'
	|| P.user 
			IN (
					SELECT following FROM followers WHERE follower = '.$_SESSION['authenticated'] .' 
					&& status = "1"
			 ) && P.status = "1" && U.status = "active" && P.id '.$query.' '.$offset .'
			 GROUP BY IF( P.`repost_of_id` = 0, P.`id`, P.`repost_of_id`) DESC
			 ORDER BY P.id DESC
			  ',
	 'LIMIT '.$postnumbers,
	  $_SESSION['authenticated'] 
	);
	
 $countPosts = count( $response );
   		 if( $countPosts != 0 ) : 
			 foreach ( $response as $key ) {
			 	
				if( $key['repost_of_id'] != 0 ) {
					$nameUser            = $key['name'];
					$idPost              = $key['id'];
					$key['type_account'] = $key['rp_type_account'];
					$key['username']     = $key['rp_username'];
					$key['name']         = $key['rp_name'];
					$key['avatar']       = $key['rp_avatar'];
					$key['user']         = $key['rp_user'];
					$key['id']           = $key['rp_id'];
					$_idUser             = $key['rp_id_user'];
					
				} else {
					$nameUser            = null;
					$key['type_account'] = $key['type_account'];
					$idPost              = $key['id'];
					$key['username']     = $key['username'];
					$key['name']         = $key['name'];
					$key['avatar']       = $key['avatar'];
					$key['user']         = $key['user'];
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
				} else {
					$iconFav      = null;
					$spanFav      = null;
					$spanAbsolute = null;
					$textFav      = $_SESSION['LANG']['favorite'];
				}
				$widthPhoto = _Function::getWidth( '../../upload/'.$key['photo'] ); 
				
				if( $widthPhoto > 440 ) {
					$thumbPic = 'thumb/450-450-';
				} else  {
					$thumbPic = null;
				}
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
				?>
				<!-- POSTS -->
<li class="hoverList" data="<?php echo $idPost; ?>">
	<span class="paddingPost">
		<?php echo $spanAbsolute; ?>
		<a  href="<?php echo URL_BASE.$key['username']; ?>" data-id="<?php echo $_idUser ?>" class="openModal">
			<img class="avatar_user" src="<?php echo URL_BASE."thumb/48-48-public/avatar/".$key['avatar']; ?>">
	      </a>
	<span class="detail_grid">
		<span class="timestamp timeAgo" data="<?php echo date('c', strtotime( $key['date'] ) ); ?>"></span>
		<a  href="<?php echo URL_BASE.$key['username']; ?>" data-id="<?php echo $_idUser ?>" class="username openModal"><?php echo stripslashes( $key['name'] ).$verified; ?> </a> <strong class="usernameClass">@<?php echo $key['username']; ?></strong>
		<p>
			<?php 
			/*<------- * POST DETAILS * -------->*/
			echo _Function::checkText( $key['post_details'] ); ?>
			
			<?php 
			/*<------- * VIDEOS * -------->*/
			if( $key['video_site'] != '' ) : 
			
				 echo $key['video_title'].' '. _Function::linkText( $key['video_url'] );
                 
                 endif;
				 
				 /*<------- * VIDEO URL AND IMAGE IS TRUE * -------->*/
			if( $key['video_site'] == '' &&  $key['video_url'] != '' ) : 
			
				 echo _Function::linkText( $key['video_url'] );
                 
                 endif;
				
				/* DATA SONG */
				if( $key['title_soundcloud'] != '' ) {
					echo $key['title_soundcloud'];
				}
				
				/*<------- * THUMB PIC * -------->*/
				if( $key['video_site'] == '' && $key['post_details'] == '' && $key['url_soundcloud'] == '' ): ?>
				<a data-view="<?php echo $_SESSION['LANG']['details']; ?> &rarr;" data-url="<?php echo $urlStatus; ?>" class="linkImage galeryAjax cboxElement" href="<?php echo URL_BASE.'upload/'.$key['photo']; ?>" rel="lightbox">
					<?php echo 'pic.thumb/'.$key['photo']; ?>
					</a>
				<?php endif; ?>
		</p>
		
		<?php
		if( $key['repost_of_id'] != 0 ) {
			
			?>
				<p style="font-size: 13px; color: #999; font-style: italic;">
					<img style="vertical-align: middle;" src="<?php echo URL_BASE; ?>public/img/repost-ico.png" /> <?php echo $_SESSION['LANG']['reposted_by']; ?> <?php echo $nameUser; ?>
					</p>
			<?php } ?>
			
			<!-- EXPAND -->
			<a data-expand="<?php echo $_SESSION['LANG']['expand']; ?>" data-hide="<?php echo $_SESSION['LANG']['hide']; ?>" class="expand getData" data="<?php echo $key['id']; ?>" data-token="<?php echo $key['token_id']; ?>">
				<?php echo $icon; ?>
				<span class="textEx"><?php echo $_SESSION['LANG']['expand']; ?></span> <?php echo $typeMedia; ?>
			</a>
			
			<!-- FAVORITES -->
			<?php if( isset( $_SESSION['authenticated'] ) ): ?>
			<a data-fav="<?php echo $_SESSION['LANG']['favorite']; ?>" data-fav-active="<?php echo $_SESSION['LANG']['favorited']; ?>" class="favorite favoriteIcon" data="<?php echo $key['id']; ?>" data-token="<?php echo $key['token_id']; ?>">
				<i class="favorite_ico icons<?php echo $iconFav; ?>"></i>
				<span<?php echo $spanFav; ?>><?php echo $textFav; ?></span>
			</a>
			<?php endif; ?>
			
			<!-- REPOST -->
			<?php if( isset( $_SESSION['authenticated'] ) && $key['user'] !=  $_SESSION['authenticated'] ): ?>
			<a data-rep="<?php echo $_SESSION['LANG']['repost']; ?>" data-rep-active="<?php echo $_SESSION['LANG']['reposted']; ?>" class="repost_button repostIcon" data="<?php echo $key['id']; ?>" data-token="<?php echo $key['token_id']; ?>">
				<i class="repost_ico icons <?php echo $iconRepost; ?>"></i>
				<span<?php echo $spanRepost; ?>><?php echo $textRepost; ?></span>
			</a>
			<?php endif; ?>
			
			<!-- TRASH -->
			<?php if( $key['user'] == $_SESSION['authenticated'] ): ?>
			<a data-message="<?php echo $_SESSION['LANG']['delete_post']; ?>" data-confirm="<?php echo $_SESSION['LANG']['confirm']; ?>" class="trash" data-image="<?php echo $key['photo']; ?>" data="<?php echo $key['id']; ?>" data-token="<?php echo $key['token_id']; ?>">
				<i class="trash_ico icons"></i>
				<span><?php echo $_SESSION['LANG']['trash']; ?></span>
			</a>
			<?php endif; ?>
	
	

	<!-- details-post -->
	<span class="details-post">
	</span><!-- details_post -->
	
	<?php if( isset( $_SESSION['authenticated'] ) ): ?>
	<!-- Grid Reply -->
   <div class="grid-reply" style="display: none;"> 
		<form action="" method="post" accept-charset="UTF-8" id="form_reply_post">
			<input type="hidden" name="id_reply" id="id_reply" value="<?php echo $key['id']; ?>">
			<input type="hidden" name="token_reply" id="token_reply" value="<?php echo $key['token_id']; ?>">
			<textarea name="reply_post" id="reply_post"></textarea>
			<div class="counter"></div> 
			<button id="button_reply" disabled="disabled" style="opacity: 0.5; cursor: default;" type="submit"><?php echo $_SESSION['LANG']['reply']; ?></button> 
			</form>
	</div><!-- Grid Reply -->
	<?php endif; ?>
  </span><!-- paddingPost  -->	
</li>
			<?php	
				 } 
			endif; 
     }//<-- SESSION
  }//<-- if token id
}//<-- ISSET
?>