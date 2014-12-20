<?php


class SearchModel extends ModelBase
{
  	public function search( $data ) {
   		/*
		 * ----------------------------------------
		 * Search #Hastag or some word
		 * $data : Word to search
		 * ---------------------------------------
		 */
   	   if ( isset( $data ) )
		{
			$data = trim( $data );
			$sql = "
			SELECT 
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
			U.id user_id,
			U.name,
			U.username,
			U.avatar,
			U.type_account,
			U.mode,
			MATCH( P.post_details, P.video_title, P.title_soundcloud ) AGAINST( '".$data."' IN BOOLEAN MODE ) relevance
			FROM posts P 
			LEFT JOIN users U ON P.user = U.id
			LEFT JOIN block_user B ON U.id = B.user && B.user_blocked = :id && B.status = '1'
			WHERE 
			P.post_details LIKE :query 
			&& P.status = '1' 
			&& U.mode = '1' 
			&& B.id IS NULL 
			&& repost_of_id = 0
			|| MATCH( P.post_details, P.video_title, P.title_soundcloud ) AGAINST( '".$data."' IN BOOLEAN MODE ) && U.mode = '1' && B.id IS NULL 
			&& repost_of_id = 0
			|| MATCH( P.post_details, P.video_title, P.title_soundcloud ) AGAINST( '".$data."*' IN BOOLEAN MODE ) && U.mode = '1' && B.id IS NULL
			&& repost_of_id = 0
			GROUP BY P.id
			";
			$output = $this->db->prepare( $sql );
			$output->bindValue( ':query',  '%'.$data.'%', PDO::PARAM_STR );
			$output->bindValue( ':id',  $session, PDO::PARAM_INT );
			
			if ( $output->execute() )
			{
				return $output->fetchall( PDO::FETCH_ASSOC );
				$this->db = null;
			}
			
		}// END ISSET
    }//<--- * END FUNCTION *-->
    
     public function searchUsers( $data, $session ) {
   	   		/*
			 * ----------------------------------------
			 * Search Users
			 * $data    : Word to search
			 * $session : Current Session
			 * ---------------------------------------
			 */
			$data = trim( $data, '@' );
			$data = trim( $data, '#' );
			$sql = "
			SELECT 
			COUNT(DISTINCT B.id) blockUser,
			U.id user_id,
			U.name,
			U.username,
			U.avatar,
			U.type_account,
			U.mode
			FROM users U 
			LEFT JOIN block_user B ON U.id = B.user && B.user_blocked = :id && B.status = '1'
			WHERE 
			U.username LIKE :query  
			&& U.status = 'active' 
			&& U.mode = '1' && B.id IS NULL 
			|| U.bio LIKE :query 
			&& U.status = 'active' 
			&& U.mode = '1' 
			&& B.id IS NULL 
			|| U.name LIKE :query 
			&& U.status = 'active' 
			&& U.mode = '1' 
			&& B.id IS NULL
			GROUP BY U.id
			ORDER BY U.id DESC
			";
			$output = $this->db->prepare( $sql );
			$output->bindValue( ':query', '%'.$data.'%', PDO::PARAM_STR );
			$output->bindValue( ':id',  $session, PDO::PARAM_INT );
			
			
			if ( $output->execute() )
			{
				return $output->fetchall( PDO::FETCH_ASSOC );
				$this->db = null;
			}
			
    }//<--- * END FUNCTION *-->
    
}//<--- * END CLASS * ---> 

?>
