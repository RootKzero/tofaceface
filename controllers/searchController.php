<?php
 
class searchController extends Controller
{ 
    public function index() {
       $output                   = $this->loadModel('User');
	   $this->_view->settings    = $output->getSettings();
	   $this->_view->notiMsg     = $output->notificationsMessages();
	   $this->_view->interaViews = $output->interactionsViews();
	   $this->_view->pagesGeneral = $output->getAllPagesGeneral();
	   /*
	    * ------------------------------------------
	    * If $_GET['q'] is empty redirect to Index
	    * ------------------------------------------
	    */
	   $_GET['q'] = trim( $_GET['q'] );
	   
	   if( $_GET['q'] == '' ) {
	   	 header('location: '.URL_BASE );
		 exit;
	   } 
	   
	   //<--- INFO USER SESSION
	   $this->_view->infoSession  = $output->infoUser( $_SESSION['authenticated'] );
	   //<--- WHO TO FOLLOWER
	   $this->_view->whoToFollow  = $output->whoToFollow( $_SESSION['authenticated'] );
	   //<--- TRENDING TOPIC
	   $this->_view->trending     = $output->getTrendsTopic();
		   
       $out = $this->loadModel('Search');
	   	   
		if( isset( $_GET['user'] ) && $_GET['user'] == 'true' ) {
			$this->_view->titleH4 = ' - '.$_SESSION['LANG']['people'].' ';
			$this->_view->title   = ''.$_SESSION['LANG']['people'].' - '.$_GET['q'];
			$this->_view->data    = $out->searchUsers( $_GET['q'], $_SESSION['authenticated'] );
			$this->_view->_file   = 'search_xajax_users.php';
		} else {
			$this->_view->title = strip_tags( $_GET['q'], ENT_QUOTES );
			$this->_view->data  = $out->search( $_GET['q'], $_SESSION['authenticated'] );
			$this->_view->_file = 'search_xajax.php';
		}
        /* Show Views */
        $this->_view->render('indexSearch', null );
    }
}

?>