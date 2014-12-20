<?php 

class adminController extends Controller
{
	/* INDEX */
    public function index() {  
    	$out = $this->loadModel( 'Admin' );
		$this->_view->settings       = $out->getSettings();
		$this->_view->users          = $out->getUsers( " WHERE status = 'active' || status = 'pending'", 'LIMIT '.( 20 ) );
		$this->_view->countUser      = count( $this->_view->users );
		$this->_view->usersGrid      = $out->getUsers( null, null );
		$this->_view->countUserGrid  = count( $this->_view->usersGrid );
		$this->_view->usersReported  = $out->getUsersReported();
		$this->_view->postsReported  = $out->getPostReported();
		$this->_view->pageId         = $out->getPageId( $_GET['edit'] );
		$this->_view->allPages       = $out->getAllPages();
		$this->_view->infoUser       = $out->infoUser( $_GET['info_user'] );
		$this->_view->getCountry     = $out->getCountUserGlobal();
		$this->_view->profilePublic  = $out->getProfilesPublic();
		$this->_view->profilePrivate = $out->getProfilesPrivate();
		$this->_view->infoUserAdmin  = $out->getAdminUsers( 'WHERE id = "'.$_SESSION['id_admon'].'" ' );
		$this->_view->usersAdmin     = $out->getusersAdmin();
        $this->_view->title          = 'Panel Administration';
		/* Show Views */
        $this->_view->render('index', null );
    }
	
}//<<<<<<<<<-- * END CLASS * -->>>>>>>>>>>>>

?>
