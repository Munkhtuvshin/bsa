<?php
require_once ROOT . '/model/model.php';
class LessonChoose extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "SELECT * FROM course";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function get($id){
        $query = "SELECT * FROM course WHERE id = " . $id;
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
            return $row;
        }
    }
    function add($id,$name,$code,$credit,$division_id,$course_type_id,$description){
        $query = "INSERT INTO course VALUES (\"$id\",\"$name\",\"$code\",\"$credit\",\"$division_id\",\"$course_type_id\",\"$description\")";
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
         
        }  
    //    function edit($id){
         //   $result = array();
          //  $query = 'SELECT * FROM course WHERE id = '.$id;
         //   $res = $this->db->query($query);
         //   while($row = $res->fetch_object()){
        //        $result[] = $row;
        //    }
     //       return $result;
     //   }
      
    //    function editPost($id, $name,$code,$credit,$division_id,$course_type_id,$description){
        //    $result = array();
         //   var_dump($name);
          //  $query = "UPDATE course SET name = \"$name\",code = \"$code\",credit =\"$credit\",division_id = \"$division_id\",course_type_id = \"$course_type_id\",description = \"$description\"  WHERE id = " . $id;
          //  $result = $this->db->query($query);
          //  if(!$result){
           //     echo $this->db->error;
          //  }
         //   return $result;
    //    }
        function remove($id){
            $query = "DELETE FROM course WHERE id = " . $id;
            $result = $this->db->query($query);
            if(!$result){
                echo $this->db->error;
            }
            return $result;
        }
   
    }

