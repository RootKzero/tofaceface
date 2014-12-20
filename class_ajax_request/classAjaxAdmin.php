<?php
require_once '../../application/Config.php';
require_once '../../application/Db.php';
require_once '../../application/SPDO.php';

class AjaxRequestAdmin
{
	/*
	 * --------------------
	 * @db DateBase
	 * @_dateNow Date now
	 * --------------------
	 */
	protected $db;
	private $_dateNow;
		
	public function __construct()
	{
		/*
		 * --------------------
		 * Database Connection
		 * --------------------
		 */
		$this->db = SPDO::singleton();
		$this->_dateNow = date( 'Y-m-d G:i:s', time() );
	}
	
	public function infoUserLive( $usr ) {
   		 /*
		 * --------------------------------------------
		 * get info user in live, name, username, etc..
		 * -------------------------------------------
		 */
   	   
   	   if ( isset( $usr ) )
		{
			$sql = "
			SELECT 
			U.username,
			U.name,
			U.avatar,
			U.email,
			U.type_account,
			U.password,
			U.mode,
			P.bg,
			P.bg_position,
			P.bg_attachment,
			P.color_link,
			P.bg_color,
			P.cover_image
			FROM users U
			LEFT JOIN profile_design P ON U.id = P.user 
			WHERE U.id = ?
			";
			
			$data = $this->db->prepare( $sql );
			
			if ( $data->execute( array( $usr ) ) )
			{
				
				return $data->fetch( PDO::FETCH_OBJ );
				$this->db = null;
			}
			
		}// END ISSET
    }//<--- * END FUNCTION *-->
    
	public function settingsGeneral() {
    	 /*
		 * ----------------------------------------------
		 * Update settings general
		 * Title, Description, keywords, message length
		 * ----------------------------------------------
		 */
        $sql = "UPDATE 
        admin_settings 
        SET 
        title = ?,
        description = ?,
        keywords = ?,
        message_length = ?,
        post_length = ?";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( 1, $_POST['title'], PDO::PARAM_STR );
		$stmt->bindValue( 2, $_POST['Description'], PDO::PARAM_STR );
		$stmt->bindValue( 3, $_POST['Keywords'], PDO::PARAM_STR );
		$stmt->bindValue( 4, $_POST['message_length'], PDO::PARAM_INT );
		$stmt->bindValue( 5, $_POST['post_length'], PDO::PARAM_INT );
		$stmt->execute();
	 
	 if ( $stmt == true )
		{
			return true;
		}
		$this->db = null;
    }
    
    public function adSettings() {
    	/*
		 * ----------------------------------------------
		 * Update Ads
		 * Html or Adsense
		 * ----------------------------------------------
		 */
        $sql = "UPDATE 
        admin_settings 
        SET 
        ad = ?";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( 1, $_POST['ad'], PDO::PARAM_STR );

		$stmt->execute();
	 
	 if ( $stmt == true )
		{
			return true;
		}
		$this->db = null;
    }
	
	public function passwordChange() {
    	/*
		 * ---------------------
		 * Change Password
		 * ---------------------
		 */
    	$pass = sha1( $_POST['pass'] );
        $sql = "UPDATE 
        admin
        SET 
        pass = ?
        WHERE id = ?";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( 1, $pass, PDO::PARAM_STR );
		$stmt->bindValue( 2, $_SESSION['id_admon'], PDO::PARAM_STR );

		$stmt->execute();
	 
	 if ( $stmt == true )
		{
			return true;
		}
		$this->db = null;
    }
	
	public function editPages() {
    	/*
		 * ---------------------------
		 * Edit Pages
		 * e.g: Privacy, Help, etc.
		 * --------------------------
		 */
        $sql = "UPDATE 
        pages_general 
        SET 
        title = ?,
        content = ?
        WHERE id = ?";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( 1, $_POST['title'], PDO::PARAM_STR );
		$stmt->bindValue( 2, $_POST['content'], PDO::PARAM_STR );
		$stmt->bindValue( 3, $_POST['id'], PDO::PARAM_INT );

		$stmt->execute();
	 
	 if ( $stmt == true ) {
			return true;
		}
		$this->db = null;
    }
	
	public function getAllPagesGeneral() {
    	/*
		 * -------------------------------
		 * get All Pages static, Privacy
		 * Help, etc.
		 * -------------------------------
		 */
        $sql = $this->db->query("
        SELECT 
        title,
        url
        FROM pages_general 
        ORDER BY title
        ");
		return $sql->fetchall();
    }
	
	public function addPages() {
    	/*
		 * ---------------------------
		 * Add Pages
		 * e.g: Privacy, Help, etc.
		 * --------------------------
		 */
        $sql = "INSERT INTO pages_general VALUES(
	    null,
	    ?,
	    ?,
	    ?
		);";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( 1, $_POST['add_title'], PDO::PARAM_STR );
		$stmt->bindValue( 2, $_POST['add_content'], PDO::PARAM_STR );
		$stmt->bindValue( 3, $_POST['add_url'], PDO::PARAM_STR );

		$stmt->execute();
	 
	 if ( $stmt == true ) {
			return true;
		}
    }
	
	public function deletePage() {
		 $sql = "DELETE FROM pages_general WHERE id = ?";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( 1, $_POST['id'], PDO::PARAM_INT );
		$stmt->execute();
		 if ( $stmt->rowCount() != 0 ) {
			return true;
		}
	}

	public function typeAccount() {
    	/*
		 * ---------------------
		 * Set type Account users
		 * ---------------------
		 */
        $sql = "UPDATE 
        users 
        SET 
        type_account = ?
        WHERE id = ?";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( 1, $_POST['value'], PDO::PARAM_INT );
		$stmt->bindValue( 2, $_POST['id'], PDO::PARAM_INT );
		$stmt->execute();
	 
	  if ( $stmt == true )
		{
			return true;
		}
		$this->db = null;
     }
	
	public function suspendedAccount() {
    	/*
		 * ---------------------
		 * Suspended Account users
		 * ---------------------
		 */
        $sql = "UPDATE 
        users 
        SET 
        status = 'suspended'
        WHERE id = ?";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( 1, $_POST['id'], PDO::PARAM_INT );
		$stmt->execute();
	 
	 if ( $stmt == true )
		{
			return true;
		}
		$this->db = null;
    }
	
	public function activateAccount() {
    	/*
		 * ---------------------
		 * Activate Account users
		 * ---------------------
		 */
        $sql = "UPDATE 
        users 
        SET 
        status = 'active'
        WHERE id = ?";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( 1, $_POST['id'], PDO::PARAM_INT );
		$stmt->execute();
	 
	 if ( $stmt == true )
		{
			return true;
		}
		$this->db = null;
    }
		
	public function deleteAccount() {
	    	/*
			 * ---------------------
			 * Delete Account users
			 * ---------------------
			 */
	        $sql = "UPDATE 
	        users 
	        SET 
	        status = 'delete'
	        WHERE id = ?";
			$stmt = $this->db->prepare( $sql );
			$stmt->bindValue( 1, $_POST['id'], PDO::PARAM_INT );
			$stmt->execute();
		 
		 if ( $stmt->rowCount() != 0 ) {
		 	
				//================= UPDATE INTERACTIONS  STATUS -> DELETE ==============//
				$updateItera = "UPDATE interactions SET trash = '1' WHERE autor = ?";
				$_execSql   = $this->db->prepare( $updateItera );
				$_execSql->bindValue( 1, $_POST['id'], PDO::PARAM_INT ); 
				$_execSql->execute();
				
				//================== UPDATE FOLLOWERS ============//
				$update = "UPDATE followers SET status = '0' WHERE follower = ?";
				$exec   = $this->db->prepare( $update );
				$exec->bindValue( 1, $_POST['id'], PDO::PARAM_INT  );
				$exec->execute();
				
				//================= UPDATE FOLLOWING ==============//
				$update2 = "UPDATE followers SET status = '0' WHERE following = ?";
				$exe   = $this->db->prepare( $update2 );
				$exe->bindValue( 1, $_POST['id'], PDO::PARAM_INT ); 
				$exe->execute();
				
				//================= UPDATE FAVORITES ==============//
				$update3 = "UPDATE favorites SET status = '0' WHERE id_usr = ?";
				$_exe   = $this->db->prepare( $update3 );
				$_exe->bindValue( 1, $_POST['id'], PDO::PARAM_INT ); 
				$_exe->execute();
				
				//================= UPDATE REPLY ==============//
				$update4 = "UPDATE reply SET status = '0' WHERE user = ?";
				$_exec   = $this->db->prepare( $update4 );
				$_exec->bindValue( 1, $_POST['id'], PDO::PARAM_INT ); 
				$_exec->execute();
				
				//================= UPDATE POST ==============//
				$update5 = "UPDATE posts SET status = '0' WHERE user = ?";
				$_exec_   = $this->db->prepare( $update5 );
				$_exec_->bindValue( 1, $_POST['id'], PDO::PARAM_INT ); 
				if( $_exec_->execute() )
			    {
				    $querySql = $this->db->prepare("SELECT photo FROM posts WHERE user = ? && photo != ''");
					
					if( $querySql->execute( array( $_POST['id'] ) ) )
					{
						
						while( $row = $querySql->fetch( PDO::FETCH_ASSOC ) )
						{
							$total = count( $row );
							$root = '../../upload/'.$row['photo'];
							
							if( $total != 0 )
							{
								if( file_exists( $root ) )
								{
									unlink( $root );
								}
							}
							
						}
					}//<--- * End Delete Photos Posts * --->
			    	
			    }
			    
			    /*
				 * -----------------------------
				 * Delete Cover && Background
				 * -----------------------------
				 */
			    $_querySql = $this->db->prepare("SELECT bg, cover_image 
			    FROM profile_design WHERE user = ?");
					
					if( $_querySql->execute( array( $_POST['id'] ) ) ) {
						$defaults  = array( '0.jpg', '1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg','10.jpg','11.jpg' );
		
						while( $row = $_querySql->fetch( PDO::FETCH_ASSOC ) ) {
							$rootCover = '../cover/'.$row['cover_image'];
							$rootCoverLarge = '../cover/large_'.$row['cover_image'];
							$rootBg    = '../backgrounds/'.$row['bg'];
								
								//<<-- Cover
								if( file_exists( $rootCover ) && $row['cover_image'] != '' ) {
									unlink( $rootCover );
									unlink( $rootCoverLarge );
								}
								//<<-- Bg
								if( file_exists( $rootBg ) && !in_array( $row['bg'], $defaults ) && $row['bg'] != '' ) {
									unlink( $rootBg );
								}
						}
					}//<--- * End Delete Bg - Cover * --->
					
					/* Delete Avatar */
					$_querySqlAvatar = $this->db->prepare("SELECT avatar FROM user WHERE user = ?");
					if( $_querySqlAvatar->execute( array( $_POST['id'] ) ) ) {										
									
							while( $rw = $_querySqlAvatar->fetch( PDO::FETCH_ASSOC ) ) {
								$rootAvatar      = '../avatar/'.$rw['avatar'];
								$rootAvatarLarge = '../avatar/large_'.$rw['avatar'];
								
								if( file_exists( $rootAvatar ) 
									&& $rw['avatar'] != '' 
									&& $rootAvatar != $rootAvatar.'avatar.png'
									) {
									unlink( $rootAvatar );
									unlink( $rootAvatarLarge );
								}
							}
						}//<<<-- End Delete Avtar --->>>>
					
				return true;
			}
			$this->db = null;
	    }//<-------- /End Function ---------->

   
   public function getPhotoPost() {
		/*
		 * --------------------------------------
		 * get photo of post, when delete an post
		 * --------------------------------------
		 */
		$query = $this->db->prepare("
		SELECT photo FROM posts WHERE id = :id_post");
		$query->execute( array( ':id_post' => $_POST['id'] ) );
		return $query->fetch( PDO::FETCH_OBJ  );
		$this->db = null;
	}
	
   public function deletePost() {
   	/*
	 * -----------------------------
	 * Delete Post
	 * ----------------------------
	 */
   	 $sql = $this->db->prepare( "UPDATE posts SET status = '0' WHERE id = :_id");
   	 $sql->execute( array( ':_id' => $_POST['id'] ) );
	 
	 if ( $sql->rowCount() != 0 ) {
	 	
		 /* Delete Repost */
			 $_sql = $this->db->prepare( "UPDATE posts SET status = '0', `status_general` = '0' WHERE repost_of_id = :_id");
   	 		 $_sql->execute( array( ':_id' => $_POST['id'] ) );
			
			
		 //<-- DELETE INTERACTIONS
			 $_sqlItera = $this->db->prepare( "UPDATE interactions SET trash = '1' WHERE target = :_id && type != '1'");
   	 		 $_sqlItera->execute( array( ':_id' => $_POST['id'] ) );
			 
			return( 1 );
		}
		$this->db = null;
   }//<-- end Method
   
   public function checkUsername( $username ) {
		/*
		 * -----------------------
		 * VERIFIED USERNAME
		 * -----------------------
		 */
		$post = $this->db->prepare("SELECT user FROM admin WHERE user = :user");
		$post->execute( array( ':user' => $username ));
		return $post->fetchall();
		$this->db = null;
	}
   
   public function addUser() {
   	    /*
		 * ----------------------------------------------
		 * Add User Admin 
		 * 1) Verified username, if is available
		 * insert into database
		 * ----------------------------------------------
		 */
   		$verifiedUsername = self :: checkUsername( $_POST['user_admin'] ) ? 1 : 0;
   		
		if( $verifiedUsername == 1 ) {
			return( 2 );
		}
		
		/*
		 * -----------------------
		 * Insert User
		 * -----------------------
		 */
	    $sql = "
	    INSERT INTO admin 
	    VALUES(
	    null,
	    ?,
	    ?,
	    ?,
	    'active'
		);";
		
		$password = sha1( $_POST['pass_new'] );
		
		$stmt  = $this->db->prepare( $sql );
		
		$stmt->bindValue( 1, $_POST['user_admin'], PDO::PARAM_STR);
		$stmt->bindValue( 2, $_POST['name_admin'], PDO::PARAM_STR );
		$stmt->bindValue( 3, $password, PDO::PARAM_STR );

		$stmt = $stmt->execute();

		if ( $stmt == true ) {
			
			return true;
			
		}
		$this->db = null;
   }//<-- /End Method
   
   public function deleteUserAdmin() {
	    	/*
			 * ---------------------
			 * Delete Account users
			 * ---------------------
			 */
	        $sql = "UPDATE 
	        admin 
	        SET 
	        status = 'trash',
	        user = '**'
	        WHERE id = ?";
			$stmt = $this->db->prepare( $sql );
			$stmt->bindValue( 1, $_POST['id'], PDO::PARAM_INT );
			$stmt->execute();
		 
		 if ( $stmt->rowCount() != 0 ) {
				return true;
			}
			$this->db = null;
	    }//<-------- /End Method ---------->
 
}//*************************************** End Class AjaxRequestAdmin() *****************************************//
?>