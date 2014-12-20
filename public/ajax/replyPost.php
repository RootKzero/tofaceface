<?php
session_start();
error_reporting(0);
if ( 
	 isset( $_POST['id_reply'] ) 
	 && !empty( $_POST['id_reply'] ) 
	 && isset( $_POST['token_reply'] ) 
	 && !empty( $_POST['token_reply'] ) 
	 && isset( $_POST['reply_post'] )
)
{
if ( isset( $_SESSION['authenticated'] ) ){
	
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
	$obj                  = new AjaxRequest();
	
	$_POST['id_reply']    = is_numeric( $_POST['id_reply'] ) ? $_POST['id_reply'] : die();
	$_POST['token_reply'] = trim( $_POST['token_reply'] );
	$_POST['reply_post']  = trim( _Function::checkTextDb( $_POST['reply_post'] ) );
	$infoUser             = $obj->infoUserLive( $_SESSION['authenticated'] );
	$admin                = $obj->getSettings();
	
	//<-------- *  * --------->
	if( strlen( utf8_decode( $_POST['reply_post'] ) ) > $admin->post_length  ) {
		$_POST['reply_post'] = _Function::cropStringLimit( $_POST['reply_post'], $admin->post_length );
		
	}
	
	if( strlen( utf8_decode( $_POST['reply_post'] ) ) == 0 ) {
		return false;
	}
	if( $infoUser->type_account == 1 ) {
		 $verified = ' <img class="verified_img" src="'.URL_BASE.'public/img/verified_min.png">'; 
	} else {
		 $verified = null; 
	}
	
	/*
	 * ----------------------
	 *   Send Reply
	 * ----------------------
	 */
	$query = $obj->sendReply();
	
	if( !empty( $query ) ) {
		 ?>
		 <!-- SPAN REPLY -->
			   				<span class="spanReply">
			   					<i title="<?php echo $_SESSION['LANG']['delete']; ?>" data="<?php echo $query; ?>" class="trash_ico_reply removeReply"></i>
			   					<span class="paddingReply">
			   						<a href="<?php echo URL_BASE.$infoUser->username; ?>" class="openModal" data-id="<?php echo $infoUser->id; ?>">
			   							<img class="avatar_user" src="<?php echo URL_BASE; ?>thumb/30-30-public/avatar/<?php echo $infoUser->avatar; ?>">
			   						</a>
			   						<span class="replyContainer">
			   							<span class="timestamp timeAgo" data="<?php echo date('c', time()); ?>"></span>
			   							<a href="<?php echo URL_BASE.$infoUser->username; ?>" class="userR openModal" data-id="<?php echo $infoUser->id; ?>"><?php echo $infoUser->name.$verified; ?></a> <strong class="usernameClass">@<?php echo $infoUser->username; ?></strong>
			   							<p><?php echo _Function::checkText( $_POST['reply_post'] ); ?></p>
			   						</span>
			   					</span>
			   				</span><!-- SPAN REPLY -->
		 <?php
	} else  {
		return false;
	}
  }//<-- SESSION
}//<-- if token id
?>