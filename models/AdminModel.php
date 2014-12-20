<?php

class AdminModel extends ModelBase
{
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
	
	public function getPageId( $page ) {
    	/*
		 * -----------------------
		 * get Pages static, Privacy
		 * Help, etc.
		 * -----------------------
		 */
        $sql = ("
        SELECT 
        title,
        content
        FROM pages_general 
        WHERE id = ?
        ");
		
		$output = $this->db->prepare( $sql );
		$output->bindValue( 1, $page, PDO::PARAM_STR );
		
		if( $output->execute() ) {
			return $output->fetch( PDO::FETCH_OBJ );
		}
		$this->db = null;
    }
    
	public function getAllPages() {
    	/*
		 * -------------------------------
		 * get All Pages static, Privacy
		 * Help, etc.
		 * -------------------------------
		 */
        $sql = $this->db->query("
        SELECT 
        id,
        title,
        content,
        url
        FROM pages_general 
        ");
		return $sql->fetchall();
    }
	
	public function getUsers(  $where, $limit ) {
    	/*
		 * -----------------------
		 * get all Users
		 * -----------------------
		 */
        $post = $this->db->query("
        SELECT
        id,
        username,
        name,
        email,
        date,
        avatar,
        type_account,
        status
        FROM users 
        ".$where."
        ORDER BY id DESC
        ".$limit." ");
        return $post->fetchall();
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
			CO.country,
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
			LEFT JOIN countries CO ON U.country = CO.short
			LEFT JOIN followers FOL ON U.id = FOL.follower && FOL.status = '1'
			LEFT JOIN favorites FA ON U.id = FA.id_usr && FA.status = '1'
			WHERE U.id = ?
			GROUP BY U.id
			";
			
			$data = $this->db->prepare( $sql );
			
			if ( $data->execute( array( $usr ) ) ) {
				
				return $data->fetch( PDO::FETCH_OBJ );
			}
			
		}// END ISSET
    }//<--- * END FUNCTION *-->
	
	public function getUsersReported() {
    	/*
		 * -----------------------
		 * get users reported
		 * -----------------------
		 */
        $post = $this->db->query("
        SELECT
        U.id,
        U.username,
        U.name,
        R.id report_id,
        R.date,
        U2.id r_id,
        U2.username r_username,
        U2.name r_name,
        U2.type_account r_account,
        U2.email r_email,
        U2.status r_status
        FROM users_reported R  
        LEFT JOIN users U ON R.user = U.id
        LEFT JOIN users U2 ON R.id_reported = U2.id
        ORDER BY U.id DESC
        ");
        return $post->fetchall();
    }  
	
	public function getPostReported() {
    	/*
		 * -----------------------
		 * get Posts reported
		 * -----------------------
		 */
        $post = $this->db->query("
        SELECT
        U.id,
        U.username,
        U.name,
        P.id report_id,
        P.date,
        U2.id r_id,
        U2.username r_username,
        U2.name r_name,
        PO.status,
        PO.id id_post
        FROM post_reported P  
        LEFT JOIN posts PO ON P.post_reported = PO.id
        LEFT JOIN users U ON P.user = U.id
        LEFT JOIN users U2 ON PO.user = U2.id
        WHERE PO.status != '0'
        ORDER BY P.id DESC
        ");
        return $post->fetchall();
    } 
    
    public function getCountUserGlobal() {
    	/*
		 * -----------------------
		 * get all Users Global
		 * -----------------------
		 */
        $post = $this->db->query("
        SELECT 
        COUNT( DISTINCT U.id ) total,
        CO.country 
        FROM users U
        LEFT JOIN countries CO ON U.country = CO.short 
        WHERE U.country != 'xx' && U.status = 'active'
        GROUP BY U.country
        ");
        return $post->fetchall();
    } 
	
	public function getProfilesPrivate() {
    	/*
		 * -----------------------
		 * get Profiles Charts 1
		 * Private
		 * -----------------------
		 */
        $post = $this->db->query("
        SELECT 
        COUNT( DISTINCT id ) total
        FROM users 
        WHERE mode = '0' && status = 'active'
        ");
        return $post->fetchall();
    } 
    
    public function getProfilesPublic() {
    	/*
		 * -----------------------
		 * get Profiles Charts 2
		 * Public
		 * -----------------------
		 */
        $post = $this->db->query("
        SELECT 
        COUNT( DISTINCT id ) total
        FROM users 
        WHERE mode = '1' && status = 'active'
        ");
        return $post->fetchall();
    } 
    
    public function getAdminUsers( $where ) {
    	/*
		 * -----------------------
		 * get Admin Users
		 * -----------------------
		 */
        $sql = "
        SELECT
        id, 
        user, 
        name,
        status
        FROM admin 
        ".$where."";
       $data = $this->db->prepare( $sql );
			
		if ( $data->execute() ) {
			
			return $data->fetch( PDO::FETCH_OBJ );
		}
    } 
	
	 public function getusersAdmin() {
    	/*
		 * -----------------------
		 * get Admin Users
		 * -----------------------
		 */
        $sql = $this->db->query("
        SELECT
        id, 
        user, 
        name,
        status
        FROM admin 
        WHERE status = 'active'");
	    return $sql->fetchall();
    } 
}//<--- * END CLASS * ---> 

?>
