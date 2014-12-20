<?php
session_start();
error_reporting(0);
if ( 
	 isset( $_POST['id_reply'] ) 
	 && !empty( $_POST['id_reply'] )
	 && isset( $_POST['reply_msg'] )
) {
if ( isset( $_SESSION['authenticated'] ) ) {
		/*
		 * --------------------------
		 *   Require File
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
		$obj                = new AjaxRequest();
		$_POST['id_reply']  = is_numeric( $_POST['id_reply'] ) ? $_POST['id_reply'] : die();
		$_POST['reply_msg'] = trim( $_POST['reply_msg'] );
		$infoUser           = $obj->infoUserLive( $_SESSION['authenticated'] );
		$admin              = $obj->getSettings();
		$verifiedUserBlock  = $obj->checkUserBlock( $_POST['id_reply'], $_SESSION['authenticated'] );
		
		// IF Message is Null
		if( mb_strlen( trim( $_POST['reply_msg'] ), 'utf8' ) == 0 ) {
			return false;
		}
		//Knowing whether the user is locked
		if( $verifiedUserBlock[0]['status'] == 1 ) {
			return false;
		}
		
		//<-------- *  * --------->
		if( mb_strlen( $_POST['reply_msg'], 'utf8' ) > $admin->message_length  )
		{
			$_POST['reply_msg'] = _Function::cropStringLimit( $_POST['reply_msg'], $admin->post_length );
			
		} else {
			$_POST['reply_msg'] = $_POST['reply_msg'];
		}
					
		$query = $obj->sendMessageId();
		
		//============ VERIFIED
		if( $infoUser->type_account == '1' ) {
			$verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">';
		} else {
			$verified = null;
		}
					
		if( !empty( $query ) ) {
		 ?>
		 
		 <li class="msg_id_user" data="<?php echo $query; ?>">
			   			<span class="paddingPost">
			   				<i title="<?php echo $_SESSION['LANG']['delete']; ?>" style="left:-15px; top:35px;" data="<?php echo $query; ?>" class="trash_ico_reply removeMsg"></i>
			   				<a href="<?php echo URL_BASE.$infoUser->username ?>">
			   					<img class="avatar_user" src="<?php echo URL_BASE.'thumb/48-48-public/avatar/'.$infoUser->avatar; ?>">
			   				</a>
			   			<span class="detail_grid">
			   				<span class="timestamp timeAgo" data="<?php echo date('c', time() ); ?>"></span>
			   				<span style="width:100%; float: left;">
			   					<a href="<?php echo URL_BASE.$infoUser->username ?>">
			   					 <span class="username"><?php echo stripslashes( $infoUser->name ).$verified; ?> </span>	
			   					</a>
			   					 
			   					<strong class="usernameClass">@<?php echo $infoUser->username; ?></strong>
			   				</span><!-- SPAN 100% -->
			   				
			   				<span>
			   				<p><?php echo _Function::checkText( $_POST['reply_msg'] ); ?></p>
			   				</span><!-- SPAN 50% -->
			   			
			   		  </span><!-- detail_grid  -->	
			   		</span><!-- paddingPost  -->	
		   		</li>
		 <?php
	}//<---
	else {
		return false;
	}
  }//<-- SESSION
}//<-- if token id
?>