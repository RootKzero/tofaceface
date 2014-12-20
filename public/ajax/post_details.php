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
			<?php
			echo $key['rp_id'] ; endif; ?>
	
	

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