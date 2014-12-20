<?php
session_start();
error_reporting(0);
if(  isset ( $_POST['offset'] ) && isset ( $_POST['number'] ) ) {
 if ( isset ( $_SESSION['authenticated'] ) ) {
   if( isset( $_POST ) && $_SERVER['REQUEST_METHOD'] == "POST" ) {
   	
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
	$infoUser    = $obj->infoUserLive( $_SESSION['authenticated'] );
	
	$response    = $obj->getInteractions('
	U.status = "active" && I.id '.$query.' '.$offset .' 
	', 
	'LIMIT '.$postnumbers, 
	$_SESSION['authenticated'] 
	);
	
	$countPosts = count( $response );
   		 if( $countPosts != 0 ) : 
			 foreach ( $response as $key ) {
			 	
				$_idUser = $key['user_id'];
				 
				//============ VERIFIED
				if( $key['type_account'] == '1' ) {
					$verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">';
				} else {
					$verified = null;
				}
				
				switch( $key['type'] ) {
					case 1:
						$action          = $_SESSION['LANG']['followed_you'];
						$icoDefault      = 'follow';
						$linkDestination = false;
						$idTag           = null;
						break;
					case 2:
						$action          = $_SESSION['LANG']['reposted_post'];
						$icoDefault      = 'reposted';
						$reply           = null;
						$linkDestination = true;
						$idTag           = null;
						break;
					case 3:
						$action          = $_SESSION['LANG']['favorited_post'];
						$icoDefault      = 'favorite';
						$linkDestination = true;
						$idTag           = null;
						break;
					case 4:
						$action          = $_SESSION['LANG']['commented_post'];
						$icoDefault      = 'reply';
						$linkDestination = true;
						$idTag           = '#reply-status-wrap';
						break;
					case 5:
						$action          = '<strong style="color: #333; font-weight: bold;">@</strong>'.$_SESSION['LANG']['mentions'].'';
						$icoDefault      = null;
						$linkDestination = true;
						$idTag           = null;
						break;
					case 6:
						$action          = '<strong style="color: #FF7000; font-weight: bold;">@</strong>'.$_SESSION['LANG']['mentions_in_replies'].'';
						$icoDefault      = null;
						$linkDestination = true;
						$idTag           = '#reply-status-wrap';
						break;
				}
				
				/* Url */
				$urlStatus = URL_BASE.$key['p_username'].'/status/'.$key['id'];
				
				?>
				<!-- POSTS -->
			
			   		<li class="hoverList" data="<?php echo $key['idInteraction']; ?>">
			   			<span class="paddingPost">
			   				<a  href="<?php echo URL_BASE.$key['username']; ?>" class="openModal" data-id="<?php echo $_idUser ?>">
			   					<img class="avatar_user" src="<?php echo URL_BASE."thumb/48-48-public/avatar/".$key['avatar']; ?>">
			   			      </a>
			   			<span class="detail_grid">
			   				<span class="timestamp timeAgo" data="<?php echo date('c', strtotime( $key['date'] ) ); ?>"></span>
			   				<a href="<?php echo URL_BASE.$key['username']; ?>" data-id="<?php echo $_idUser ?>" class="username openModal"><?php echo stripslashes( $key['name'] ).$verified; ?> </a> <strong class="usernameClass">@<?php echo $key['username']; ?></strong>
			   				
			   				<?php if( $action == true ) : ?>
				   				<p style="color: #999; font-size: 12px;">
				   					<?php if( $icoDefault == true ) : ?>
				   				<i class="ico_interactions ico_interaction_<?php echo $icoDefault; ?> "></i> 
				   				<?php endif; ?>
				   				<?php echo $action; ?>
				   				</p>
				   			<?php endif; ?>
			   					
			   				<?php if( $linkDestination == true ): ?>
			   				<p>
			   					
			   					<?php echo _Function::checkText( $key['post_details'] ); ?>
			   					<?php if( $key['video_site'] != '' ) : 
			   						
									echo $key['video_title'].' '. _Function::linkText( $key['video_url'] );
					                 endif;
									 
									 if( $key['url_soundcloud'] != '' ) {
									 	echo $key['title_soundcloud'];
									 }
									 
			   						 if( $key['video_site'] == '' && $key['post_details'] == '' && $key['url_soundcloud'] == ''  ): ?>
			   						<a data-view="<?php echo $_SESSION['LANG']['details']; ?> &rarr;" data-url="<?php echo $urlStatus; ?>" class="linkImage galeryAjax cboxElement" href="<?php echo URL_BASE.'upload/'.$key['photo']; ?>" rel="lightbox">
			   							<?php echo 'pic.thumb/'.$key['photo']; ?>
			   							</a>
			   						<?php endif; ?>
			   				</p><!-- end tag p -->
			   				
			   				<a style="float: left; font-size: 12px; margin: 0 7px 0 0;" href="<?php echo URL_BASE.$key['p_username'].'/status/'.$key['id'].$idTag; ?>">
			   					<span class="textEx"><?php echo $_SESSION['LANG']['got_to_post']; ?> &raquo;</span>
			   				</a>
			   			<?php endif; //<--- End $linkDestination == true ?>

	</span>
			   
			   		  </span><!-- paddingPost  -->	
		   		</li> <?php } endif; 
     }//<-- SESSION
  }//<-- if token id
}//<-- ISSET
?>