<?php
session_start();
error_reporting(0);
if( 
		isset ( $_POST['offset']) 
		&& isset ( $_POST['number']) 
		&& isset ( $_POST['_userId']) 
		&& !empty( $_POST['_userId'] )
	
) {
  if( isset( $_POST ) && $_SERVER['REQUEST_METHOD'] == "POST" && $_SESSION['authenticated'] ) {
   	
   		/*
	 * --------------------------------------------------
	 *   Valid $offset && Valid $postnumbers
	 * --------------------------------------------------
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
	$obj               = new AjaxRequest();
	$infoUser          = $obj->infoUserLive( $_SESSION['authenticated'] );
	$response          = $obj->getMessages( $_SESSION['authenticated'], ' && id '.$query.' '.$offset .'',null );
	?>
	<?php $countPosts = count( $response );
   		 if( $countPosts != 0 ) : 
			 foreach ( $response as $key ) {
				
				if( $key['from'] == $_SESSION['authenticated'] && $key['username'] == $infoUser->username ) {
			 		$key['name']         = $key['name2'];
					$key['username']     = $key['username2'];
					$key['avatar']       = $key['avatar2'];
					$key['type_account'] = $key['type_account2'];
					$ID                  = $key['id_2'];
			 		$sendTo              = '<img src="'.URL_BASE.'public/img/msg_send.png" /> ';
			 	} else if( $key['from'] == $_SESSION['authenticated'] && $key['username2'] == $infoUser->username ) {
			 		$key['name']         = $key['name'];
					$key['username']     = $key['username'];
					$key['avatar']       = $key['avatar'];
					$key['type_account'] = $key['type_account'];
					$ID                  = $key['id_user'];
			 		$sendTo              = '<img src="'.URL_BASE.'public/img/msg_send.png" /> ';
			 	} else if( $key['from'] != $_SESSION['authenticated'] && $key['username'] == $infoUser->username ) {
					$key['name']         = $key['name2'];
					$key['username']     = $key['username2'];
					$key['avatar']       = $key['avatar2'];
					$key['type_account'] = $key['type_account2'];
					$ID                  = $key['id_2'];
					$sendTo              = null;
				} else if( $key['from'] != $_SESSION['authenticated'] && $key['username2'] == $infoUser->username ) {
					$key['name']         = $key['name'];
					$key['username']     = $key['username'];
					$key['avatar']       = $key['avatar'];
					$key['type_account'] = $key['type_account'];
					$ID                  = $key['id_user'];
					$sendTo              = null;
				}
				
				//============ VERIFIED
				if( $key['type_account'] == '1' ) {
					$verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">';
				} else {
					$verified = null;
				}
				
				if( mb_strlen( $key['message'], 'utf8' ) > 45 ) {
				 	$message = _Function::cropString( $key['message'], 45 );
				 } else {
				 	$message = $key['message'];
				 }
				 
				 /* New - Readed */
				 if( $key['status'] == 'new' && $key['from'] != $_SESSION['authenticated'] )  {
				 	$styleStatus = ' style="background: #EAEFF3;"'; 
				 } else {
					 $styleStatus = null; 
				 }
				?>
				<!-- POSTS -->
			   		<li class="hoverList" data="<?php echo $key['id']; ?>"<?php echo $styleStatus; ?>>
			   			<i style="top: 12px;" title="<?php echo $_SESSION['LANG']['delete']. ' ' .$_SESSION['LANG']['messages']; ?>" data="<?php echo $ID; ?>" class="trash_ico_reply removeAllMsg"></i>
			   			<a class="see_msg" data-reply="<?php echo $_SESSION['LANG']['reply']; ?>" data="<?php echo $ID; ?>" href="messages/#">			  	 			
			   			<span class="paddingPost">
			   					<img class="avatar_user" src="<?php echo URL_BASE.'thumb/48-48-public/avatar/'.$key['avatar']; ?>">
			   			<span class="detail_grid">
			   				<span class="timestamp timeAgo" data="<?php echo date('c', strtotime( $key['date'] ) ); ?>"></span>
			   				<span style="width:100%; float: left;">
			   					<span class="username"><?php echo stripslashes( $key['name'] ).$verified; ?> </span> 
			   					<strong class="usernameClass">@<?php echo $key['username']; ?></strong>
			   				</span><!-- SPAN 100% -->
			   				
			   				<span>
			   				<p><?php echo $sendTo._Function::checkTextMessages( $message ); ?></p>
			   				</span><!-- SPAN 50% -->
			   			
			   		  </span><!-- detail_grid  -->	
			   		</span><!-- paddingPost  -->	
			   	</a>	
		   	</li> <?php }//<<--- Foreach 
		 endif;
     }//<-- ISSET POST
}//<-- ISSET DATA
?>