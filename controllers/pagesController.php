<?php

/****************************************
 *  * Help 
 *  * Advertising
 *  * Terms
 *  * Privacy
 *  * About
 *  * Profile - "Settings"
 *  * Settings
 *  * Password
 *  * Design
 *  * Messages
 *  * Recover Pass
 *  * Discover
 *  * Connect
 *  * Activity
 * 
 **************************************/
 
class pagesController extends Controller
{
	//<-- * INDEX ERROR * --->
    public function index() {
    	header ('HTTP/1.0 404 Not Found');
	    include 'public/error/404.php'; // SHOW ERROR 404
    }
	
	public function pagesStatic( $page ) {
    	$output                    = $this->loadModel('User');
		$this->_view->getAllPages  = $output->getAllPages();
		$this->_view->pagesGeneral = $output->getAllPagesGeneral();
		
		foreach ( $this->_view->getAllPages as $key) {
			 $loop[] = $key['url']; 
		}
		if( !in_array( $page , $loop ) ) {
			$this->redirect( null );
		}
		
		//<--- INFO USER SESSION ACTIVE
		$this->_view->infoSession  = $output->infoUser( $_SESSION['authenticated'] );
		$this->_view->settings     = $output->getSettings();
		$this->_view->notiMsg      = $output->notificationsMessages();
		$this->_view->notiIntera   = $output->notificationsInteractions();
		
		//<--- WHO TO FOLLOWER
	    $this->_view->whoToFollow  = $output->whoToFollow( $_SESSION['authenticated'] );
	   
	   //<--- TRENDING TOPIC
	   $this->_view->trending = $output->getTrendsTopic();
	   
    	$out                = $this->loadModel( 'Pages' );
		$this->_view->data  = $out->getPage( $page );
		$this->_view->res   = count( $this->_view->data  );
        $this->_view->title = $this->_view->data->title;
		/* Show Views */
        $this->_view->render('static', null );
    }
	
	public function profile() {
		  $output                   = $this->loadModel('User');
		  $this->_view->settings    = $output->getSettings();
		  $this->_view->notiMsg     = $output->notificationsMessages();
		  $this->_view->notiIntera  = $output->notificationsInteractions();
		  $this->_view->pagesGeneral = $output->getAllPagesGeneral();
		  //<--- INFO USER SESSION ACTIVE
		  $this->_view->infoSession = $output->infoUser( $_SESSION['authenticated'] );
		  //<--- TRENDING TOPIC
		  $this->_view->trending    = $output->getTrendsTopic();
		  $this->_view->module      = 'profile';
		   
		 $this->_view->title = $_SESSION['LANG']['profile'];
		 /* Show Views */
		 $this->_view->render('settings', null );
	}
	
	public function settings() {
		 $output                   = $this->loadModel('User');
		 $this->_view->settings    = $output->getSettings();
	     $this->_view->notiMsg     = $output->notificationsMessages();
		 $this->_view->notiIntera  = $output->notificationsInteractions();
		 $this->_view->pagesGeneral = $output->getAllPagesGeneral();
		 //<--- INFO USER SESSION ACTIVE
		 $this->_view->infoSession = $output->infoUser( $_SESSION['authenticated'] );
		 //<--- TRENDING TOPIC
		 $this->_view->trending    = $output->getTrendsTopic();
		 //<--- countries
		 $this->_view->countries   = $output->countries();
		 $this->_view->module      = 'settings';
		   
		 $this->_view->title = $_SESSION['LANG']['settings'];
		 /* Show Views */
		 $this->_view->render('settings', null );
	}
	
	public function password() {
	  $output                   = $this->loadModel('User');
	  $this->_view->settings    = $output->getSettings();
	  $this->_view->notiMsg     = $output->notificationsMessages();
	  $this->_view->notiIntera  = $output->notificationsInteractions();
	  $this->_view->pagesGeneral = $output->getAllPagesGeneral();
	  //<--- INFO USER SESSION ACTIVE
	  $this->_view->infoSession = $output->infoUser( $_SESSION['authenticated'] );
	  //<--- TRENDING TOPIC
	  $this->_view->trending    = $output->getTrendsTopic();
	  //<--- pass
	  $this->_view->module      = 'password';
	   
	 $this->_view->title = $_SESSION['LANG']['password'];
	 /* Show Views */
	 $this->_view->render('settings', null );
	}
	
	public function design() {
	  $output                   = $this->loadModel('User');
	  $this->_view->settings    = $output->getSettings();
	  $this->_view->notiMsg     = $output->notificationsMessages();
	  $this->_view->notiIntera  = $output->notificationsInteractions();
	  $this->_view->pagesGeneral = $output->getAllPagesGeneral();
      //<--- INFO USER SESSION ACTIVE
	  $this->_view->infoSession = $output->infoUser( $_SESSION['authenticated'] );
	  //<--- TRENDING TOPIC
	  $this->_view->trending    = $output->getTrendsTopic();
	  //<--- design
	  $this->_view->module      = 'design';
	   
	 $this->_view->title = $_SESSION['LANG']['design'];
	 /* Show Views */
	 $this->_view->render('settings', null );
	}
	
	public function messages() {
	 $output                   = $this->loadModel('User');
	//<--- INFO USER SESSION ACTIVE
	 $this->_view->infoSession = $output->infoUser( $_SESSION['authenticated'] );
	 $this->_view->settings    = $output->getSettings();
	 $this->_view->notiMsg         = $output->notificationsMessages();
     $this->_view->notiIntera      = $output->notificationsInteractions();
	 $this->_view->pagesGeneral = $output->getAllPagesGeneral();
	 //<--- TRENDING TOPIC
	 $this->_view->trending    = $output->getTrendsTopic();
	 
	 //<<<<-- Messages --->>>>
	 $this->_view->messages    = $output->getMessages( $_SESSION['authenticated'] );
	 $this->_view->countMgs    = count( $this->_view->messages  );
	 
	 $this->_view->title  =  $_SESSION['LANG']['messages'];
	 //<--- msg
	 $this->_view->module = 'messages';
	/* Show Views */
     $this->_view->render('settings', null );
	}
	
	public function recover() {
	 $output                 = $this->loadModel( 'Pages' );
	 $this->_view->codeValid = $output->getCodePass( $_GET['c'] ) ? 1 : 0;
	 /* Show Views */
	 $this->_view->render('recover', null );
	}
	
	public function discover() {
		$output                  = $this->loadModel('User');
		$this->_view->settings   = $output->getSettings();
		$this->_view->notiMsg    = $output->notificationsMessages();
		$this->_view->notiIntera = $output->notificationsInteractions();
		$this->_view->pagesGeneral = $output->getAllPagesGeneral();
		//<----- ALL POST INDEX PAGE
	   $this->_view->posts     = $output->discover( 
	   'WHERE P.user != '. $_SESSION['authenticated'] .' 
	   && U.status = "active" 
	   && P.status = "1" 
	   && U.mode = "1" 
	   && F.id IS NULL', 
	   null , 
	   $_SESSION['authenticated']
	   );
		     
		//<--- INFO USER SESSION ACTIVE
	   $this->_view->infoSession = $output->infoUser( $_SESSION['authenticated'] );
	   //<--- TRENDING TOPIC
	   $this->_view->trending    = $output->getTrendsTopic();
		 
	   //<--- WHO TO FOLLOWER
	   $this->_view->whoToFollow = $output->whoToFollow( $_SESSION['authenticated'] );
	   
		   
	   $this->_view->title = $_SESSION['LANG']['discover'].' ';
	   /* Show Views */
	   $this->_view->render('discover', null );
	}

	
	
	public function interactions() {
		$output                   = $this->loadModel('User');
		$this->_view->settings    = $output->getSettings();
		$this->_view->notiMsg     = $output->notificationsMessages();
		$this->_view->interaViews = $output->interactionsViews();
		$this->_view->pagesGeneral = $output->getAllPagesGeneral();
		
		//<--- INFO USER SESSION ACTIVE
	   $this->_view->infoSession = $output->infoUser( $_SESSION['authenticated'] );
	   
		//<----- ALL POST INDEX PAGE
	   $this->_view->data = $output->getInteractions( 
	   'U.status = "active" ', 
	   null , 
	   $_SESSION['authenticated']
	   );
		     
	   //<--- TRENDING TOPIC
	   $this->_view->trending = $output->getTrendsTopic();
		 
	   //<--- WHO TO FOLLOWER
	   $this->_view->whoToFollow = $output->whoToFollow( $_SESSION['authenticated'] );
	   
	   $this->_view->title = $_SESSION['LANG']['interactions'].' // '.$_SESSION['LANG']['mentions'];
	   $this->_view->_file = 'ajax.interactions.php';
	   /* Show Views */
	   $this->_view->render('interactions', null );
	}

}//<<<<<<<<<-- * END CLASS * -->>>>>>>>>>>>>

?>
