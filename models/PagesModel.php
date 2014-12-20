<?php

 
class PagesModel extends ModelBase
{
		
    public function getPage( $page ) {
    	/*
		 * -----------------------------
		 * Get Page by Url
		 * -----------------------------
		 */
        $sql = ("
        SELECT 
        title,
        content
        FROM ". PAGES_GENERAL ." 
        WHERE url = ?
        ");
		
		$output = $this->db->prepare( $sql );
		$output->bindValue( 1, $page, PDO::PARAM_STR );
		
		if( $output->execute() )
		{
			return $output->fetch( PDO::FETCH_OBJ );
		}
		$this->db = null;
    }
	
	public function getCodePass( $code ) {
		/*
		 * -----------------------------
		 * Get Code Pass
		 * -----------------------------
		 */
		if ( preg_match( '/[^a-z0-9\_\-]/i',$code ) )
		{
			return false;
		}
		$sql = $this->db->prepare("SELECT id FROM recover_pass WHERE id_hash = :hash && verified = '0'");
		$sql->execute( array(  ':hash' => $code ) );
		$response = $sql->fetch();
		
		if( !empty( $response ) )
		{
			return true;
		}
		else {
			return false;
		}
	}//<<<--- End Function
	
}//<-- * END CLASS * -->

?>
