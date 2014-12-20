<?php
session_start();
error_reporting(0);
if( 
		isset ( $_POST['offset']) 
		&& isset ( $_POST['number']) 
		&& isset ( $_POST['_userId'] )
	
) {
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
	$obj              = new AjaxRequest();
	$response         = $obj->searchUsers( $_POST['_userId'], ' && U.status = "active" && U.id '.$query.' '.$offset, 'LIMIT '.$postnumbers, $_SESSION['authenticated'] );
		
	?>
	<?php $countPosts = count( $response );
   		 if( $countPosts != 0 ) : 
			 foreach ( $response as $key ) {
			 	
				$_idUser = $key['id'];
				 
			 	//============ VERIFIED
				if( $key['type_account'] == '1' ) {
					$verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">';
				} else {
					$verified = null;
				}
				$checkBlock      = $obj->checkUserBlock( $_SESSION['authenticated'], $key['id'] );
				?>
				<!-- POSTS -->
			   		<li class="hoverList" data="<?php echo $key['id']; ?>">
			   		
			   		<?php if( $checkBlock[0]['status'] == 0 ): ?>	
			   			
			   			<?php if(  isset( $_SESSION['authenticated'] ) && $_SESSION['authenticated'] != $key['id'] && $key['followActive'] == 0 ): ?>
			   			<span data-username="<?php echo $key['username']; ?>" data-id="<?php echo _Function::randomString( 10, FALSE, TRUE, FALSE ).'-'.$key['id']; ?>" data-follow="<?php echo $_SESSION['LANG']['follow']; ?>" data-unfollow="<?php echo $_SESSION['LANG']['unfollow']; ?>" data-following="<?php echo $_SESSION['LANG']['following']; ?>" class="followBtn follow_button followBtnMin"><?php echo $_SESSION['LANG']['follow']; ?></span>
			   			<?php endif; ?>
			   			
			   			<?php if(  isset( $_SESSION['authenticated'] ) && $_SESSION['authenticated'] != $key['id'] && $key['followActive'] == 1 ): ?>
			   			<span data-username="<?php echo $key['username']; ?>" data-id="<?php echo _Function::randomString( 10, FALSE, TRUE, FALSE ).'-'.$key['id']; ?>" data-follow="<?php echo $_SESSION['LANG']['follow']; ?>" data-unfollow="<?php echo $_SESSION['LANG']['unfollow']; ?>" data-following="<?php echo $_SESSION['LANG']['following']; ?>" class="followBtn follow_button follow_active followBtnMin"><?php echo $_SESSION['LANG']['following']; ?></span>
			   			<?php endif; ?>
			   			
			   		<?php endif;//<<-- Blocked ?>
			   			
			   			<span class="paddingPost">
			   				<a  href="<?php echo URL_BASE.$key['username']; ?>" class="openModal" data-id="<?php echo $_idUser ?>">
			   					<img class="avatar_user" src="<?php echo URL_BASE."thumb/48-48-public/avatar/".$key['avatar']; ?>">
			   			      </a>
			   			<span class="detail_grid">
			   				<span style="width:100%; float: left;">
			   					<a  href="<?php echo URL_BASE.$key['username']; ?>" data-id="<?php echo $_idUser ?>" class="username openModal"><?php echo stripslashes( $key['name'] ).$verified; ?> </a> <strong class="usernameClass">@<?php echo $key['username']; ?></strong>
			   				</span><!-- SPAN 100% -->
			   				
			   				<span style="width:70%; float: left;">
			   				<p>
			   					<?php echo _Function::checkText( $key['bio'] ); ?>
			   				</p>
			   				</span><!-- SPAN 50% -->
			   		  </span><!-- detail_grid  -->	
			   		</span><!-- paddingPost  -->	
		   		</li> <?php }//<<<-- Foreach
		   		endif;  //<<<--- $countPosts != 0
     }//<--
}//<-- ISSET
?>