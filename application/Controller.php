<?php

abstract class Controller
{
    protected $_view;
    
    public function __construct() {
        $this->_view = new View( new Request );
    }
    
	abstract public function index();
	 
    protected function loadModel( $model ) {
        $model     = $model . 'Model';
        $rootModel = ROOT . 'models' . DS . $model . '.php';
        
        if( is_readable( $rootModel ) )
        {
            require $rootModel;
            $model = new $model;
            return $model;
        }
		
        else {
            throw new Exception('Error model');
        }
    }//<-- * END FUNCTION * -->
    
    protected function redirect( $root = false ) {
        if( $root )
        {
            header('location:' . URL_BASE . $root );
            exit;
        }
        else{
            header('location:' . URL_BASE);
            exit;
        }
	}
    
    public static function checkEmail( $str ) {
		return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-\.]+)+[A-z]{2,4}$/", $str );
	}
	    
}//<<<----- * End Class * ------->>>
?>
