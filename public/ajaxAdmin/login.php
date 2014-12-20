<?php
session_start();
error_reporting(0);
if ( 
	isset ( $_POST['usr']) 
	&& !empty( $_POST['usr'] ) 
	&& isset( $_POST['pass'] ) 
	&& !empty( $_POST['pass'] )
) {
if ( !isset( $_SESSION['id_admon'] ) ) {
	
	/* Require */
	require_once('../../class_ajax_request/classAjax.php');
	$obj = new AjaxRequest();
		
		$_POST['usr'] = trim( $_POST['usr'] );
		$_POST['pass'] = trim( $_POST['pass'] );

			// LOGUEAMOS AL USUARIO
        $row = $obj->loginAdmin();
		
		if( isset( $row['id'] ) ) {
			$_SESSION['id_admon']  = $row['id'];
			$_SESSION['usr_admon'] = $row['user'];
			
	        echo 'true';
		} else {
			echo '<i class="glyphicon glyphicon-remove"></i> <strong>User</strong> and <strong>Password</strong> not valid.';
		
	  }
} else {
		echo '<script type="text/javascript">	
					$(document).ready(function(){
						window.location.reload();
			         });// FIN READY 
         </script>';
	}

} else {
	echo 'Error';
	
}
 ?>