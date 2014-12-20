<?php

	error_reporting( 0 );
	/* Define absolute paths */
	define( 'DS', DIRECTORY_SEPARATOR );
	define( 'ROOT', realpath( dirname( __FILE__ ) ) . DS );
	define( 'APP_PATH', ROOT . 'application' . DS );
	
	/* REQUIRE FILES */
	
try {
    require_once APP_PATH . 'Config.php';
	require_once APP_PATH . 'SPDO.php';
	require_once APP_PATH . 'ModelBase.php';
    require_once APP_PATH . 'Request.php';
    require_once APP_PATH . 'Bootstrap.php';
    require_once APP_PATH . 'Controller.php';
    require_once APP_PATH . 'View.php';
    require_once APP_PATH . 'Sessions.php';
	require_once APP_PATH . 'Db.php';
	require_once APP_PATH . 'AdminSettings.php';
	require_once APP_PATH . 'functions.php';
	
	/*-----------------
	 * ADMIN SETTINGS
	 * ---------------
	 */
	$obj       = new adminSettings();
	$settings  = $obj->getSettings();
	
	require_once APP_PATH . 'DataConfig.php';
	
    //<-* SESSION START *->
    Session :: init();
	
	//<-* Languages *->
	_Function :: getLang();
	
	//<- * REQUEST * ->
    Bootstrap :: run( new Request );
				
}
catch( Exception $e ) {
    echo $e->getMessage();
}
?>