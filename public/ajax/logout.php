<?php
error_reporting(0);
session_start();
if ( isset( $_GET['logout'] ) && $_GET['logout'] == 'out')
{
	session_destroy();
	echo 'OK';
	exit(0);
}
?>