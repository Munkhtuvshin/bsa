<?php
require_once ROOT . '/model/Model.php';
class File extends Model{
    public function __construct() {
		parent::__construct();
    }
      public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM file'; // select query
       # $query = "SELECT l.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    #class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
//Дараах код нь address.php дээрх бүх утгыг харуулна
     public function getAllFile() {
        $result = array(); // butsaah utga hadgalna
        #$query = 'SELECT * FROM file'; // select query
        $query = "SELECT F.id as Fid, F.path, F.description, U.first_name AS Uname, OT.name AS OTname FROM file AS F INNER JOIN 
            user AS U ON F.user_id = U.id INNER JOIN owner_type AS OT ON F.owner_type_id = OT.id WHERE owner_type_id=6";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
//Дараах код нь addAddress.php бүх утгыг нэмнэ
     public function add($file) {
        $query = 'INSERT INTO file ( path, description, user_id, owner_type_id, owner_id)';
        $query .= 'values ("' . $file->path . '", "' .  $file->description . '", "' . $file->user_id .'", "'. $file->owner_type_id . '", "'. $file->owner_id .'")';
        return $this->db->query($query); // query ajilluulna
    }
//Дараах код нь address.php бүх утгыг устгана
       public function remove($id) {
       $query = 'DELETE FROM file WHERE id = ' . intVal($id);
        #$query = "DELETE FROM lesson WHERE id ='".$_GET['id']."'";

        return $this->db->query($query); // query ajilluulna

        #header("Location: /view/lesson/index.php");
    }

     public function edit($id, $file){
        $query = 'UPDATE file SET ';
        $query .= 'path = "' . $file->path . '",
                    description = "' . $file->description . '",
                    user_id = "'. $file->user_id . '",
                    owner_type_id = "'. $file->owner_type_id .'",
                    owner_id = "'. $file->owner_id .'"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }

     public function getAllUser() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM user'; // select query
       # $query = "SELECT l.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    #class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

     public function getAllOwnerType() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM owner_type'; // select query
       # $query = "SELECT l.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    #class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

    public function download($path){
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM file WHERE path=$path'; // select query
       # $query = "SELECT l.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    #class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

}