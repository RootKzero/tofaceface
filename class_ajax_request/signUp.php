<?php
require_once '../../application/Config.php';
require_once '../../application/Db.php';
require_once '../../application/SPDO.php';


class SignUp
{
	/*
	 * --------------------
	 * @db DateBase
	 * @_dateNow Date now
	 * --------------------
	 */
	protected $db;
	private $_dateNow;
		
	public function __construct() {
		/*
		 * --------------------
		 * Database Connection
		 * --------------------
		 */
		 
		$this->db       = SPDO::singleton();
		$this->_dateNow = date( 'Y-m-d G:i:s', time() );
	}
	
	public function getSettings() {
    	/*
		 * -----------------------
		 * get Settings from Admin
		 * -----------------------
		 */
        $post = $this->db->query("
        SELECT
        title,
        description,
        keywords,
        message_length,
        post_length,
        ad
        FROM admin_settings ");
        return $post->fetch( PDO::FETCH_OBJ );
    }
	
	public function checkUsername( $username ) {
		/*
		 * -----------------------
		 * VERIFIED USERNAME
		 * -----------------------
		 */
		$post = $this->db->prepare("SELECT username FROM users WHERE username = :user");
		$post->execute( array( ':user' => $username ));
		return $post->fetchall();
		$this->db = null;
	}
	
	public function signUpNoVerified() {
   	    /*
		 * ----------------------------------------------
		 * sign up
		 * 1) Verified username, if is available
		 * insert into database
		 * ----------------------------------------------
		 */
   		$verifiedUsername = self :: checkUsername( $_POST['username'] ) ? 1 : 0;
   		
		if( $verifiedUsername == 1 ) {
			return( 'unavailable' );
		}
		
		/*
		 * -----------------------
		 * Insert User
		 * -----------------------
		 */
	    $sql = "
	    INSERT INTO users 
	    VALUES(
	    null,
	    ?,
	    ?,
	    '',
	    'xx',
	    ?,
	    ?,
	    '".$this->_dateNow."',
	    '',
	    '',
	    'avatar.png',
	    ?,
	    '0',
	    '1',
	    'active',
	    '1',
	    '1',
	    '1',
	    '".$_SESSION['lang']."'
		);";
		
		$password = sha1( $_POST['password'] );
		
		$stmt  = $this->db->prepare( $sql );
		
		$stmt->bindValue( 1, $_POST['username'], PDO::PARAM_STR);
		$stmt->bindValue( 2, $_POST['full_name'], PDO::PARAM_STR );
		$stmt->bindValue( 3, $password, PDO::PARAM_STR );
		$stmt->bindValue( 4, $_POST['email'], PDO::PARAM_STR );
		$stmt->bindValue( 5, $_POST['code'], PDO::PARAM_STR );
		

		$stmt = $stmt->execute();
		
		/*
		 * -----------------------
		 * User ID inserted
		 * -----------------------
		 */
		$idUsr = $this->db->lastInsertId( $stmt );

		if ( $stmt == true ) {
			
			//============================================================//
			//=                * INSERT PROFILE DESIGN *                 =//
			//============================================================//
			$profileDesign = $this->db->prepare("
			INSERT INTO profile_design
			VALUES
			(
			null,
			?,
			'0.jpg',
			'left',
			'fixed',
			'#0088E2',
			'#000000',
			''
			)");
			$profileDesign->execute( array( $idUsr ) );
			
			return $idUsr;
			
		}
		$this->db = null;
   }//<-- end Method
   
}//*************************************** End Class AjaxRequest() *****************************************//
?>