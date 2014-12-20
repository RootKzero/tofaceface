<?php
/*
 * -------------------------------------
 * Request.php
 * 
 * -------------------------------------
 */
class Request
{
    private $_controller;
    private $_method;
    
    public function __construct() {
    	$page        = $_GET['page'];    //<-- //PAGES STATIC eg: http:website.com/about
    	$usr         = $_GET['usr'];     //<-- PAGE USR eg: http:website.com/user
    	$action      = $_GET['action'];  //<-- PAGE USR VIEW eg: http:website.com/user/followers
    	$search      = $_GET['q'];  //<-- PAGE SEARCH eg http:website.com/search/?q=games-plus
    	$status      = $_GET['status'];  //<-- PAGE SEARCH eg http:website.com/user/status/1
    	$admin       = 'admin';
    	$staticPages = array( 
				    	'discover', 
				    	'connect', 
				    	'settings', 
				    	'profile', 
				    	'password', 
				    	'design', 
				    	'login',
				    	'messages',
				    	'recover',
				    	'validate',
				    	'interactions',
				    	
		);
		
		//<-- *  PAGES DEFAULT * -->
        if( !in_array( $page, $staticPages ) 
	        && isset( $page ) 
	        && !isset( $search ) 
	        && !isset( $action ) 
		) {
            $this->_controller = strtolower( $page );
			$this->_method     = strtolower( $page );
            
        }
		if( isset( $page ) 
				&& !isset( $search ) 
				&& !isset( $action ) 
				&& $page != $admin
		) {
			if( in_array( $page, $staticPages ) && $page != $admin ) {
				$this->_controller = 'pages';
				$this->_method     = strtolower( $page );
			} else if( !in_array( $page, $staticPages ) && $page != $admin ) {
				$this->_controller = 'pages';
				$this->_method     = 'pagesStatic';
				$this->_arguments  =  array( strtolower( $page ) );
			}
			
		}
		
		//<-- ***************** PAGE USER ************* -->
		if( isset( $usr ) 
			&& $action == '' 
			&& !isset( $page ) 
			&& !isset( $hashTag ) 
			&& !isset( $search ) 
		) {
			$this->_controller = 'user';
			$this->_method     = 'user';
		}
		
		//<-- ************** PAGE USER ACTION ************ -->
		if( isset( $usr ) 
			&& isset( $action ) 
			&& !isset( $page ) 
			&& !isset( $search ) 
		) {
			$this->_controller = 'user';
			$this->_method     = $action;
		}
		//<-- * PAGE SEARCH * -->
		if( isset( $search ) && $search != '' && $page == 'search'  ) {
			$this->_controller = 'search';
			$this->_method     = 'search';
		}
		
		//<-- * if no have variables defined $ _GET showed index * -->
        if( !$this->_controller ) {
            $this->_controller = DEFAULT_CONTROLLER;
        }
        
        if( !$this->_method ) {
            $this->_method = 'index';
        }
		
		if( !isset( $this->_arguments ) )
        {
            $this->_arguments = array();
        }
    }//<--- * END * -->
    
    public function getController() {
        return $this->_controller;
    }
    
    public function getMethod() {
        return $this->_method;
    }
	
	public function getArgs() {
        return $this->_arguments;
    }
 
}//<-- * END CLASS * -->

?>