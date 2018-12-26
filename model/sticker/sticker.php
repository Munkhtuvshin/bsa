<?php 
require_once ROOT . '/model/Model.php';
class Sticker extends Model{
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
    public function getStickerAlbumName($id){
        $result = ''; // butsaah utga hadgalna
        $query = 'SELECT id, name FROM sticker_album WHERE id = '.$id; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result = $row;
        }
        return $result;
    }
    public function userHasStickerAlbum($userSticker){
        $result = false; // butsaah utga hadgalna
        $query = 'SELECT sticker_album.*, user_sticker_album.user_id as down_user_id FROM sticker_album LEFT JOIN user_sticker_album ON user_sticker_album.album_id = sticker_album.id WHERE user_sticker_album.user_id = '.$userSticker->user_id.' AND user_sticker_album.album_id = '.$userSticker->album_id; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result = true;
        }
        return $result;
    }
    public function addStickerToUser($userSticker) {
        $query = 'INSERT INTO user_sticker_album (album_id, user_id) VALUES ('. $userSticker->album_id .', '. $userSticker->user_id .')';
        return $this->db->query($query); // query ajilluulna
    }
    public function removeStickerFromUser($userSticker) {
        $query = 'DELETE FROM user_sticker_album WHERE user_sticker_album.album_id = '. $userSticker->album_id .' AND user_sticker_album.user_id = '. $userSticker->user_id;
        return $this->db->query($query); // query ajilluulna
    }
}
?>