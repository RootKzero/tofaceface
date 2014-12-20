<?php
 
class indexController extends Controller
{ 
    public function index() {
		if( Session::get( 'authenticated' ) ) {
		   $output                   = $this->loadModel('User');
		   $this->_view->settings    = $output->getSettings();
		   $this->_view->notiMsg     = $output->notificationsMessages();
		   $this->_view->notiIntera  = $output->notificationsInteractions();
		   $this->_view->pagesGeneral = $output->getAllPagesGeneral();
		   //<--- INFO USER SESSION
		   $this->_view->infoSession = $output->infoUser( $_SESSION['authenticated'] );
		   
		   //<----- ALL POST INDEX PAGE
		   $this->_view->posts = $output->getAllPosts( '
		   WHERE P.user = '.$_SESSION['authenticated'] .' && P.status = "1"
			&& U.status = "active" || P.user 
			IN (
					SELECT following FROM followers WHERE follower = "'.$_SESSION['authenticated'] .'" 
					&& status = "1"
			 ) && P.status = "1" && U.status = "active" 
			 GROUP BY IF( P.`repost_of_id` = 0, P.`id`, P.`repost_of_id`) DESC', 
			 null , 
			 $_SESSION['authenticated']
		   );
		   //<--- WHO TO FOLLOWER
		   $this->_view->whoToFollow  = $output->whoToFollow( $_SESSION['authenticated'] );
		   //<--- TRENDING TOPIC
		   $this->_view->trending     = $output->getTrendsTopic();
		   
		}
		
		if( !Session::get( 'authenticated' ) ) {
			$output = $this->loadModel('User');
			$this->_view->pagesGeneral = $output->getAllPagesGeneral();
			if( isset( $_GET['validate'] ) ) {
				$this->_view->accountValidate = $output->getCodeAccount( $_GET['validate'] ) ? 1 : 0;
			}
			
			if( $this->_view->accountValidate == 1 ) {
				$this->_view->actived = $output->activeAccount( $_GET['validate'] );
			}
		}
		/* Show Views */
        $this->_view->render( 'index', null );
    }
}
?>