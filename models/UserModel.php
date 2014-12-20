<?php

class UserModel extends ModelBase
{
	public function getSettings() {
    	/*
		 * --------------------------
		 * Get Settings from Admin
		 * --------------------------
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
	
	public function infoUser( $usr ) {
   	   /*
		 * --------------------------------------------
		 * Get info user, name, username, etc..
		 * -------------------------------------------
		 */
   	   if ( isset( $usr ) ) {
			$sql = "
			SELECT 
			COUNT( DISTINCT FO.id ) totalFollowers,
			COUNT( DISTINCT FOL.id ) totalFollowing,
			COUNT( DISTINCT FA.id ) totalFavs,
			COUNT( DISTINCT PO.id ) totalPost,
			U.id,
			U.username,
			U.name,
			U.location,
			U.country,
			U.email,
			U.website,
			U.bio,
			U.avatar,
			U.type_account,
			U.mode,
			U.status, 
			U.messages_private,
			U.email_notification_follow,
			U.email_notification_msg,
			U.language,
			P.bg,
			P.bg_position,
			P.bg_attachment,
			P.color_link,
			P.bg_color,
			P.cover_image
			FROM users U
			LEFT JOIN profile_design P ON U.id = P.user 
			LEFT JOIN posts PO ON U.id = PO.user && PO.status = '1' && PO.status_general = '1'
			LEFT JOIN followers FO ON U.id = FO.following && FO.status = '1'
			LEFT JOIN followers FOL ON U.id = FOL.follower && FOL.status = '1'
			LEFT JOIN favorites FA ON U.id = FA.id_usr && FA.status = '1'
			WHERE U.id = ?
			GROUP BY U.id
			";
			
			$data = $this->db->prepare( $sql );
			
			if ( $data->execute( array( $usr ) ) ) {
				
				return $data->fetch( PDO::FETCH_OBJ );
				$this->dbh = null;
			}
			
		}// END ISSET
    }//<--- * END FUNCTION *-->
    
    public function countries() {
		/*
		 * ----------------
		 * Get countries..
		 * ----------------
		 */
		$sql = $this->db->prepare( "SELECT short, country FROM countries ORDER BY country" );
		if( $sql->execute() )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
	}
    
    public function getAllPosts( $_where, $_limit, $session ) {
			/*
			 * -----------------------------
			 * Get all Post in "Index page"
			 * $_where : Condition
			 * $_limit : Limit of post
			 * $_session: Current Session
			 * -----------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			COUNT(DISTINCT FA.id ) favoriteUser,
			P.id
			FROM posts P 
			LEFT JOIN users U ON P.user = U.id
			LEFT JOIN posts RP ON P.repost_of_id = RP.id
			LEFT JOIN users U2 ON RP.user = U2.id
			LEFT JOIN favorites  FA ON P.id = FA.id_favorite && FA.id_usr = :id && FA.status = '1'
	        ".$_where."
			ORDER BY P.id DESC
			". $_limit ."
			" );
			
			//return $sql;
			if( $sql->execute( array( ':id' => $session ) ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
			//$this->db = null;
			
	}//<--- * END FUNCTION *-->
	
	public function discover( $_where, $_limit, $session ) {
			 /*
			 * --------------------------------
			 * Get all Post in "Discover Page"
			 * $_where : Condition
			 * $_limit : Limit of post
			 * $_session: Current Session
			 * --------------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			COUNT(DISTINCT FA.id ) favoriteUser,
			COUNT(DISTINCT F.id ) followActive,
			COUNT(DISTINCT B.id) blockUser,
			P.id,
			P.token_id,
			P.post_details,
			P.photo,
			P.video_code,
			P.video_title,
			P.video_site,
			P.video_url,
			P.user,
			P.date,
			U.name,
			U.username,
			U.avatar,
			U.type_account
			FROM posts P
			LEFT JOIN users U ON P.user = U.id
			LEFT JOIN followers F ON P.user = F.following && F.follower = :id  && F.status = '1'
			LEFT JOIN favorites  FA ON P.id = FA.id_favorite && FA.id_usr = :id && FA.status = '1'
			LEFT JOIN block_user B ON U.id = B.user && B.user_blocked = :id && B.status = '1'
			". $_where ." && U.status = 'active' && P.status = '1' && B.id IS NULL && P.repost_of_id = '0'
			GROUP BY P.id
			ORDER BY P.date DESC
			". $_limit ."
			" );
			
			//return $sql;
			if( $sql->execute( array( ':id' => $session ) ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
			//$this->db = null;
			
	}//<--- * END FUNCTION *-->
	
	public function connect( $_where, $_limit, $session ) {
			/*
			 * ------------------------------------
			 * Get all Mentions in "Connect page"
			 * $_where : Condition
			 * $_limit : Limit of post
			 * $_session: Current Session
			 * ------------------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			COUNT(DISTINCT FA.id ) favoriteUser,
			P.id,
			P.token_id,
			P.post_details,
			P.photo,
			P.video_code,
			P.video_title,
			P.video_site,
			P.video_url,
			P.user,
			P.date,
			U.id user_id,
			U.name,
			U.username,
			U.avatar,
			U.type_account,
			U.mode
			FROM posts P
			LEFT JOIN users U ON P.user = U.id
			LEFT JOIN favorites  FA ON P.id = FA.id_favorite && FA.id_usr = :id && FA.status = '1'
			". $_where ."
			GROUP BY P.id
			ORDER BY P.id DESC
			". $_limit ."
			" );
			
			if( $sql->execute(  array( ':id' => $session )  ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
			
	}//<--- * END FUNCTION *-->
	
	public function getInteractions( $where, $limit, $_id ) {
			/*
			 * -----------------------------
			 * Get All interactions
			 * $where : Condition
			 * $limit : Limit media
			 * ---------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			I.type,
			P.id,
			P.token_id,
			P.post_details,
			P.video_url,
			P.user,
			P.date,
			U.id user_id,
			U.name,
			U.username,
			U.avatar,
			U.type_account,
			U.mode,
			US.username p_username
			FROM interactions I 
			LEFT JOIN users U ON I.autor = U.id
			LEFT JOIN posts P ON I.target = P.id
			LEFT JOIN reply R ON I.target = R.post 
			&& R.user = U.id 
			&& R.post = P.id 
			&& R.status = '1'
			LEFT JOIN followers F ON F.follower = U.id
			LEFT JOIN users US ON P.user = US.id
			LEFT JOIN favorites FA ON I.target = FA.id_favorite
		 	WHERE I.destination = :id && I.autor != :id && ".$where." && I.trash = '0'
		 	GROUP BY I.id DESC
		 	ORDER BY I.id DESC
			".$limit."
			" );
			
			if( $sql->execute(  array( ':id' => $_id  )  ) ) {
				
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
	}//<--- * END FUNCTION *-->
	
	public function getPostsFavs( $_where, $_limit, $session ) {
			/*
			 * -----------------------------
			 * Get Post Favorites
			 * $_where : Condition
			 * $_limit : Limit of post
			 * $_session: Current Session
			 * -----------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			COUNT(DISTINCT FA.id ) favoriteUser,
			P.id,
			P.token_id,
			P.post_details,
			P.user,
			P.date,
			U.name,
			U.username,
			U.avatar,
			U.type_account
			FROM posts P
			LEFT JOIN users U ON P.user = U.id
			LEFT JOIN favorites F ON P.id = F.id_favorite
			LEFT JOIN favorites  FA ON P.id = FA.id_favorite && FA.id_usr = :id && FA.status = '1'
			". $_where ." && U.status = 'active' && P.status = '1' && F.status = '1'
			GROUP BY P.id
			ORDER BY F.id DESC
			". $_limit ."
			" );
			
			if( $sql->execute(  array( ':id' => $session )  ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
			
	}//<--- * END FUNCTION *-->
    
    public function whoToFollow( $_id ) {
			/*
			 * -----------------------------
			 * "who To Follow" : 
			 * suggestion who to follow
			 * $id : Current user "Session ID"
			 * -----------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			COUNT(DISTINCT B.id) blockUser,
			U.id,
			U.name,
			U.username,
			U.avatar,
			U.type_account
			FROM users U
			LEFT JOIN followers F ON U.id = F.following && F.follower = :id && F.status = '1'
			LEFT JOIN block_user B ON U.id = B.user && B.user_blocked = :id && B.status = '1'
			WHERE U.id <> :id && F.id IS NULL && U.status = 'active' && B.id IS NULL
			GROUP BY U.id
			ORDER BY rand(". time() . " * " . time() .")
			LIMIT 3
			" );
			
			//return $sql;
			if( $sql->execute( array( ':id' => $_id ) ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
			$this->db = null;
			
	}//<--- * END FUNCTION *-->
	
  	public function getUserId( $usr ) {
   		/*
		 * -----------------------------
		 * Get user by username 
		 * $usr : Username
		 * http://yousite.com/UserName
		 * -----------------------------
		 */
   	   if ( isset( $usr ) )
		{
			$sql = "
			SELECT 
			id,
			name,
			username
			FROM users
			WHERE username = :username && status = 'active'
			";
			
			$data = $this->db->prepare( $sql );
			
			if ( $data->execute( array( ':username' => $usr ) ) )
			{
				return $data->fetchall();
				$this->db = null;
			}
			
		}// END ISSET
    }//<--- * END FUNCTION *-->

	
	public function getTrendsTopic() {
		/*
		 * -----------------------------
		 * Get Trends Topic
		 * trends over the last 5 days
		 * Limit 10
		 * -----------------------------
		 */
		$time = date( 'Y-m-d G:i:s', time() );
		$sql = $this->db->prepare( "
		SELECT COUNT( DISTINCT user ) total, 
		trends FROM trends_topic 
		WHERE 
		DATE(time_stamp) <= DATE('".$time."') AND 
        DATE(time_stamp) >= DATE('".$time."' - INTERVAL 5 DAY ) && trends != ''
		GROUP BY trends
		ORDER BY total DESC 
		LIMIT 10" );
		$sql->execute();
		return $sql->fetchall( PDO::FETCH_OBJ );

	}
	
	public function checkFollow( $follower, $following ) {
		/*
		 * ----------------------------------------------
		 * Namely follow up status
		 * ----------------------------------------------
		 */
		$follower  = (int)$follower;
		$following = (int)$following;
		
		$query = $this->db->prepare("
		SELECT status FROM followers WHERE follower = ? &&  following = ? ");
		$query->execute( array( $follower, $following ) );
		return $query->fetch( PDO::FETCH_OBJ );
		$this->db = null;
	}
	
	public function checkRepost( $id, $user ) {
		/*
		 * ----------------------------------------------
		 * Repost of User
		 * ----------------------------------------------
		 */
		$id    = (int)$id;
		
		$sql = $this->db->prepare( "SELECT id FROM posts WHERE repost_of_id = ? && user = ? && status = '1' " );
		$sql->execute( array( $id, $user ) );
		$response = $sql->fetch();
		
		if( !empty( $response ) ) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getRepostUser( $_id ) {
			/*
			 * ------------------------
			 * Get Repost
			 * $_id : ID Publication/Post
			 * ----------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			COUNT( DISTINCT id ) totalRepost
			FROM posts
			WHERE repost_of_id = :id && status = '1'
			ORDER BY id ASC
			" );
			
			if( $sql->execute(  array( ':id' => $_id  )  ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
	}//<--- * END FUNCTION *-->
		public function checkUserBlock( $user, $blocked ) {
		/*
		 * ----------------------------------------------
		 * Know whether a user has been blocked
		 * ----------------------------------------------
		 */
		$user    = (int)$user;
		$blocked = (int)$blocked;
		
		$query = $this->db->prepare("
		SELECT id, status FROM block_user WHERE user = ? &&  user_blocked = ? ");
		$query->execute( array( $user, $blocked ) );
		return $query->fetchall();
		$this->db = null;
	}
	
	public function getPhotosVideos( $_id ) {
			/*
			 * ----------------------------------------------
			 * Get photos show Profile users
			 * $_id : ID User
			 * ----------------------------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			U.username,
			P.id,
			P.photo,
			P.post_details,
			P.date,
			P.video_code,
			P.video_url,
			P.video_site,
			P.video_thumbnail,
			P.video_title,
			P.url_soundcloud,
			P.title_soundcloud,
			P.thumbnail_song
			FROM posts P
			LEFT JOIN users U ON P.user = U.id
			WHERE P.user = :id && P.photo != '' && P.status = '1' && repost_of_id = 0
			|| P.user = :id && P.status = '1' && P.video_code != '' && repost_of_id = 0
			|| P.user = :id && P.status = '1' && P.url_soundcloud != '' && repost_of_id = 0
			ORDER BY P.id DESC
			LIMIT 6
			" );
			
			if( $sql->execute(  array( ':id' => $_id  )  ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
	}//<--- * END FUNCTION *-->
	
	public function getAllMedia( $_id, $where, $limit ) {
			/*
			 * -----------------------------
			 * Get All media
			 * $_id : ID User
			 * $where : Condition
			 * $limit : Limit media
			 * ---------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			P.id,
			P.photo,
			P.post_details,
			P.date,
			P.video_code,
			P.video_url
			FROM posts P
			WHERE P.user = :id && P.repost_of_id = '0' && P.status = '1' && P.photo != '' ".$where."
			|| P.user = :id && P.repost_of_id = '0' && P.status = '1' && P.video_code != '' ".$where."
			|| P.user = :id && P.status = '1' && P.url_soundcloud != '' && repost_of_id = 0 ".$where."
			ORDER BY P.id DESC
			".$limit."
			" );
			
			if( $sql->execute(  array( ':id' => $_id  )  ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
	}//<--- * END FUNCTION *-->
    
    public function getFollowers( $_where, $_limit, $session ) {
			/*
			 * -----------------------------
			 * Get Followers
			 * $_where : Condition
			 * $_limit : Limit of post
			 * $_session: Current Session
			 * -----------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			COUNT(DISTINCT FO.id ) followActive,
			U.id,
			U.username,
			U.name,
			U.avatar,
			U.type_account,
			U.bio
			FROM users U
			LEFT JOIN followers F ON U.id = F.follower
			LEFT JOIN followers  FO ON U.id = F.following && FO.follower = :id && FO.status = '1' 
			". $_where ." && U.status = 'active' && F.status = '1'
			GROUP BY U.id
			ORDER BY F.id DESC
			". $_limit ."
			" );
			
			if( $sql->execute(  array( ':id' => $session )  ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
			
	}//<--- * END FUNCTION *-->
	
	public function getFollowing( $_where, $_limit, $session ) {
			/*
			 * -----------------------------
			 * Get Following
			 * $_where : Condition
			 * $_limit : Limit of post
			 * $_session: Current Session
			 * -----------------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			COUNT(DISTINCT FO.id ) followActive,
			U.id,
			U.username,
			U.name,
			U.avatar,
			U.type_account,
			U.bio
			FROM users U
			LEFT JOIN followers F ON U.id = F.following
			LEFT JOIN followers  FO ON U.id = FO.follower && FO.following = :id && FO.status = '1'
			". $_where ." && U.status = 'active' && F.status = '1'
			GROUP BY U.id
			ORDER BY F.id DESC
			". $_limit ."
			" );
			
			if( $sql->execute(  array( ':id' => $session )  ) ) {
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
	}//<--- * END FUNCTION *-->
	
	public function getStatus( $user, $status ) {
			/*
			 * -----------------------------
			 * Get Status
			 * $user   : Username of user
			 * $status : ID status
			 * -----------------------------
			 */	
			$sql = $this->db->prepare( "
			SELECT 
			COUNT(DISTINCT FA.id ) favoriteUser,
			P.id,
			P.token_id,
			P.post_details,
			P.photo,
			P.video_code,
			P.video_title,
			P.video_site,
			P.video_url,
			P.user,
			P.date _date,
			P.url_soundcloud,
			P.title_soundcloud,
			U.id user_id,
			U.name,
			U.username,
			U.avatar,
			U.type_account,
			U.mode,
			U.status,
			PR.bg,
			PR.bg_position,
			PR.bg_attachment,
			PR.color_link,
			PR.bg_color
			FROM posts P
			LEFT JOIN users U ON P.user = U.id
			LEFT JOIN profile_design PR ON U.id = PR.user
			LEFT JOIN followers F ON P.user = F.following
			LEFT JOIN favorites  FA ON P.id = FA.id_favorite && FA.id_usr = :session && FA.status = '1'
			WHERE U.username = :user && P.id = :id && U.status = 'active' && P.status = '1'
			GROUP BY P.id
			ORDER BY P.date DESC
			" );
			
			if( $sql->execute( array( ':user' => $user, ':id' => $status, ':session' => $_SESSION['authenticated'] ) ) )
			{
				return  $sql->fetch( PDO::FETCH_OBJ );
			}
			//$this->db = null;
			
	}//<--- * END FUNCTION *-->
	
	public function getFavorites( $_id ) {
			/*
			 * ------------------------
			 * Get Favorites
			 * $_id : ID Publication/Post
			 * ----------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			U.id,
			U.username,
			U.name,
			U.avatar
			FROM users U
			LEFT JOIN favorites F ON U.id = F.id_usr && F.status = '1'
			LEFT JOIN posts P ON F.id_favorite = P.id
			WHERE P.id = :id
			ORDER BY F.date DESC
			LIMIT 20
			" );
			
			if( $sql->execute(  array( ':id' => $_id  )  ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
	}//<--- * END FUNCTION *-->
	
	public function getReply( $_id ) {
			/*
			 * ------------------------
			 * Get Replys
			 * $_id : ID Publication/Post
			 * ----------------------
			 */
			$sql = $this->db->prepare( "
			SELECT 
			U.id,
			U.username,
			U.name,
			U.avatar,
			U.type_account,
			R.id idReply,
			R.reply,
			R.date
			FROM users U
			LEFT JOIN reply R ON U.id = R.user && R.status = '1'
			LEFT JOIN posts P ON R.post = P.id
			WHERE P.id = :id && R.status = '1'
			ORDER BY R.date ASC
			" );
			
			if( $sql->execute(  array( ':id' => $_id  )  ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
	}//<--- * END FUNCTION *-->
	
	public function getMessages( $_id ) {
		/*
		 * ----------------------------------------
		 * Get messages private
		 * $_id : ID User
		 * ---------------------------------------
		 */	
		$sql = $this->db->prepare( "
		SELECT 
	    mm.recipient_id,
	    m.*,
	    U.id,
		U.username,
		U.name,
		U.type_account,
		U.avatar,
		U2.id id_2,
		U2.username username2,
		U2.name name2,
		U2.type_account type_account2,
		U2.avatar avatar2
		FROM (
		  SELECT
		  `from`,
		  `to`,
		    `from` + `to` - 1 as recipient_id,
		    Max(id) as id
		  FROM
		    messages
		  WHERE
		    `from` = :id && remove_from = '1'  ||
		    `to` = :id && remove_from = '1'
		  GROUP BY
		    `from` + `to` - 1
		  ) mm
		    INNER JOIN
		  messages m
		    On
		  mm.id = m.id
		  LEFT JOIN users U ON U.id = mm.`to`
		  LEFT JOIN users U2 ON U2.id = mm.`from` 
		  ORDER BY date DESC
		");
		if( $sql->execute(  array( ':id' => $_id  )  ) )
			{
				return  $sql->fetchall( PDO::FETCH_ASSOC );
			}
	}//<<<<-- * End * --->>>>
	
	public function getCodeAccount( $code ) {
		/*
		 * -----------------------------
		 * Get Code Account
		 * $code : Code activation
		 * -----------------------------
		 */	
		if ( preg_match( '/[^a-z0-9\_\-]/i',$code ) )
		{
			return false;
		}
		$sql = $this->db->prepare("SELECT id FROM users WHERE activation_code = :code && status = 'pending'");
		$sql->execute( array(  ':code' => $code ) );
		$response = $sql->fetch();
		
		if( !empty( $response ) )
		{
			return true;
		}
		else {
			return false;
		}
	}//<<<-- End
	
	public function activeAccount( $code ) {
		/*
		 * -----------------------------
		 * Activate Account
		 * $code : Code activation
		 * -----------------------------
		 */	
		if ( preg_match( '/[^a-z0-9\_\-]/i',$code ) )
		{
			return false;
		}
		
		$sql = "UPDATE users SET status = 'active' WHERE activation_code = :code && status = 'pending'";
		
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( ':code', $code, PDO::PARAM_STR );
		
		if ( $stmt->execute() )
		{
			return true;
		}
		 else {
			 return false;
		 }
		$this->db = null;
		
	}//<<< * End * -->>>>
	
	public function notificationsMessages() {
    	/*
		 * -----------------------
		 * Get all news Messages
		 * ----------------------
		 */
    	$sql = $this->db->prepare("
    	SELECT 
    	COUNT( DISTINCT `from` ) total
		FROM messages 
		WHERE `to` = :id && status = 'new' && remove_from = '1'
		GROUP BY `to`
    	");
    	
    	if ( $sql->execute( array( ':id' => $_SESSION['authenticated'] ) ) ) {
				return $sql->fetch( PDO::FETCH_OBJ );
				$this->db = null;
			}
    }
    
    public function notificationsInteractions() {
    	/*
		 * -----------------------
		 * Get all Interactions
		 * ----------------------
		 */
    	$sql = $this->db->prepare("
    	SELECT 
    	COUNT(DISTINCT id ) total
		FROM interactions 
		WHERE destination = :id && status = '0'
    	");
    	
    	if ( $sql->execute( array( ':id' => $_SESSION['authenticated'] ) ) ) {
				return $sql->fetch( PDO::FETCH_OBJ );
				$this->db = null;
			}
    }
	
	public function interactionsViews() {
		$sql = "UPDATE interactions SET status = '1' WHERE destination = :id";
		$stmt = $this->db->prepare( $sql );
		$stmt->bindValue( ':id', $_SESSION['authenticated'], PDO::PARAM_INT );
		$stmt->execute();
	}
	
	public function getAllPages() {
    	/*
		 * -------------------------------
		 * get All Pages static, Privacy
		 * Help, etc.
		 * -------------------------------
		 */
        $sql = $this->db->prepare("
        SELECT 
        url
        FROM pages_general 
        ");
		if ( $sql->execute() ) {
			return $sql->fetchall( PDO::FETCH_ASSOC );
		}
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
	
}//<--- * END CLASS * ---> 

?>
