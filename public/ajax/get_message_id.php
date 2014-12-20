<?php
session_start();
error_reporting(0);
if( 

		isset ( $_POST['_userId'] ) 
		&& !empty( $_POST['_userId'] )
	
) {
	//<<<<<------ 
	if( $_POST['_userId'] == $_SESSION['authenticated'] ) {
		return false;
	}
	
  if( isset( $_POST ) && $_SERVER['REQUEST_METHOD'] == "POST" && $_SESSION['authenticated'] ) {
   	
   	/*
	 * -----------------------
	 *   Valid $id_user 
	 * -----------------------
	 */
    $id_user = is_numeric($_POST['_userId']) ? $_POST['_userId'] : die();
	

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
	$obj               = new AjaxRequest();
	$response          = $obj->getMessageId( $id_user, $_SESSION['authenticated'] );
	
	//<<<<<----- Verified User
	$verified = $obj->checkUser( $id_user ) ? 1 : 0;
		
		if( $verified == 0 ) {
			return false;
		}
	?>
	<?php $countPosts = count( $response );
   		 if( $countPosts != 0 ) : 
			 foreach ( $response as $key )  {
			 	
				//============ VERIFIED
				if( $key['type_account'] == '1' ) {
					$verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">';
				} else {
					$verified = null;
				} if( $key['id_user'] == $_SESSION['authenticated'] ) {
					$remove = '<i title="'.$_SESSION['LANG']['delete'].'" style="left:-15px; top: 35px;" data="'.$key['id'].'" class="trash_ico_reply removeMsg"></i>';
					$class = ' class="msg_id_user"';
				} else {
					$class = null;
					$remove = '<i title="'.$_SESSION['LANG']['delete'].'" data="'.$key['id'].'" class="trash_ico_reply removeMsg"></i>';
				}
				?>
				<!-- POSTS -->
			   		<li<?php echo $class; ?> data="<?php echo $key['id']; ?>">
			   			<span class="paddingPost">
			   				<?php echo $remove; ?>
			   				<a href="<?php echo URL_BASE.$key['username'] ?>">
			   					<img class="avatar_user" src="<?php echo URL_BASE.'thumb/48-48-public/avatar/'.$key['avatar']; ?>">
			   				</a>
			   			<span class="detail_grid">
			   				<span class="timestamp timeAgo" data="<?php echo date('c', strtotime( $key['date'] ) ); ?>"></span>
			   				<span style="width:100%; float: left;">
			   					<a href="<?php echo URL_BASE.$key['username'] ?>">
			   					 <span class="username"><?php echo stripslashes( $key['name'] ).$verified; ?> </span>	
			   					</a>
			   					 
			   					<strong class="usernameClass">@<?php echo $key['username']; ?></strong>
			   				</span><!-- SPAN 100% -->
			   				
			   				<span>
			   				<p><?php echo _Function::checkText( $key['message'] ); ?></p>
			   				</span><!-- SPAN 50% -->
			   			
			   		  </span><!-- detail_grid  -->	
			   		</span><!-- paddingPost  -->	
			   		  
		   		</li> <?php }//<<<--- Foreach 
		   		endif;
     }//<-- ISSET POST
}//<-- ISSET DATA
?>