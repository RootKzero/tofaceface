<?php

class Session
{
	public static function init() {
		session_start();
	}//<--- * END init() * --->
	
	public function destroy( $action = false  ) {
		if( $action === true ) {
			$_SESSION = array();
			session_destroy();
		}
	}//<--- * END destroy() * -->
	
	public function get( $key ) {
		if( isset( $_SESSION[$key] ) ) {
			return $_SESSION[$key];
		} else {
			return false;
		}
	}//<--- * END get() * -->
	
}//<------------ * END CLASS * ------------->
?>