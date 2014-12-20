<?php

class adminSettings extends ModelBase
{
    
    public function getSettings() {
        $post = $this->db->query("
        SELECT
        title,
        description,
        keywords,
        message_length,
        post_length,
        ad
        FROM ". ADMIN_SETTINGS ." ");
        return $post->fetch( PDO::FETCH_OBJ );
    }
}//<-- * END CLASS * -->

?>
