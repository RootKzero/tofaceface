<?php
session_start();
error_reporting(0);

if ( isset( $_GET['logout'] ) && $_GET['logout'] == 'out') {
	
	unset( $_SESSION['id_admon'] );
	echo 'OK';
	exit(0);
}
?>