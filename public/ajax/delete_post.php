<?php
session_start();
error_reporting(0);
if ( 
	isset( $_POST['token'] ) 
	&& !empty( $_POST['token'] ) 
	&& isset( $_POST['id'] ) 
	&& !empty( $_POST['id'] )
) {
  if ( isset( $_SESSION['authenticated'] ) ) {
		/*
	 * --------------------------
	 *   Require/Include Files
	 * -------------------------
	 */
		require_once('../../class_ajax_request/classAjax.php');
		/*
		 * ----------------------
		 *   Instance Class
		 * ----------------------
		 */
		$obj               = new AjaxRequest();
		/*
		 * --------------------------
		 *   Root of Photo
		 * -------------------------
		 */
		$root              = '../../upload/';
		$_POST['token_id'] = trim( $_POST['token_id'] );
		$_POST['id']       = (int)$_POST['id'];
		$_POST['user']     = $_SESSION['authenticated'];
		$_photo            = $obj->getPhotoPost( $_POST['id'] );
		$photo_id          = $_photo->photo;
		
		$query = $obj->deletePost();
	
		if( $query == 1 ) {
			
			/*
			 * --------------------------
			 *   folder permissions
			 * -------------------------
			 */
			chmod( $root.$photo_id, 0777 );
			
			 //==== Delete image if exists
			 if ( file_exists( $root.$photo_id ) && $photo_id != '' ) {
				 unlink( $root.$photo_id );
			 }
			 echo json_encode( array( 'status' => 'ok' ) );
		} else {
			echo json_encode( array( 'status' => 'error', 'res' => $_SESSION['LANG']['error'] ) );
		}
  }//<-- SESSION
}//<-- if token id
?>