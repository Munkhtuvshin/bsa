<?php 
require_once ROOT . '/model/Model.php';
class Admin extends Model{
    public function __construct(){
        parent::__construct();
    }
    public function getAllStickerAlbum(){
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT sticker_album.*, user_sticker_album.user_id as down_user_id FROM sticker_album LEFT JOIN user_sticker_album ON user_sticker_album.album_id = sticker_album.id'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getStickersByAlbum($id){
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM sticker WHERE sticker.sticker_album_id = '.$id; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function deleteStickerAlbum($id) {
        $query = 'DELETE FROM sticker_album WHERE sticker_album.id = '. $id;
        return $this->db->query($query); // query ajilluulna
    }
}
?>