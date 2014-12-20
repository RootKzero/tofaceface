<?php

$config = Config::singleton();
define('SITE_NAME', $settings->title ); //<-- SITE NAME EG: SOCIAL
define('DESCRIPTION_SITE', $settings->description ); //<-- SITE DESCRIPTION 
define('KEYWORDS_SITE', $settings->keywords ); //<-- SITE KEYWORDS
$config->set( 'BACKGROUND_INDEX', $settings->bg_index );
define( 'MAX_LENGTH', $settings->post_length );

/* EMAIL */
define( 'EMAIL_ACTIVE_ACCOUNT', 'activate@'.$_SERVER['SERVER_NAME'].'' );
define( 'EMAIL_PASS_RECOVER', 'recover@'.$_SERVER['SERVER_NAME'].'' );
define( 'EMAIL_NOTIFICATIONS', 'notifications@'.$_SERVER['SERVER_NAME'].'' );

/* BIT URL PARAMS */
define( 'BIT_URL_USER', 'azodian' );
define( 'BIT_URL_KEY', 'R_ba156525896da313224d0db0c62a07d8' );

/*
 * DATE DEFAULT
 * */
//date_default_timezone_set('America/Caracas');



//<--- *  NOT MODIFIED * --->
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_LAYOUT', 'default');
/*
 * FOLDERS/FILES ROOT
 * 
 * */
$config->set('controllersFolder', 'controllers/');
$config->set('modelsFolder', 'models/');
$config->set('viewsFolder', 'views/');
$config->set('tmpFolder', 'tmp/');
$config->set('avatarFolder', 'avatar/');
$config->set('photosListingFolder', 'photos-listing/');
/*
 * PARAMS
 * 
 * */

$config->set( 'time', date( 'Y-m-d G:i:s', time() ) );
?>
