<?php
require_once ROOT . '/model/model.php';
class Teacher extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "SELECT * FROM teacher_schedule";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function get($id){
        $query = "SELECT * FROM teacher_schedule WHERE id = " . $id;
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
            return $row;
        }
    }

   // function add($id,$week_day,$par,$class_id,$class_type_id,$instructor_user_id,$class_room_id){
     //   $query = "INSERT INTO teacher_schedule VALUES (\"$id\",\"$week_day\",\"$par\",\"$class_id\",\"$class_type_id\",\"$instructor_user_id\",\"$class_room_id\")";
      //  $result = $this->db->query($query);
      //  if(!$result){
       //     echo $this->db->error;
       // }
       // return $result;
         
       // }  
       // function edit($id){
        //    $result = array();
        //    $query = 'SELECT * FROM teacher_schedule WHERE id = '.$id;
          //  $res = $this->db->query($query);
          //  while($row = $res->fetch_object()){
              //  $result[] = $row;
         //   }
          //  return $result;
       // }
      
       // function edit1($id, $week_day,$par,$class_id,$class_type_id,$instructor_user_id,$class_room_id){
         ///   $result = array();
           // var_dump($name);
          //  $query = "UPDATE teacher_schedule SET week_day = \"$week_day\",par = \"$par\",class_id =\"$class_id\",class_type_id = \"$class_type_id\",instructor_user_id = \"$instructor_user_id\",class_room_id = \"$class_room_id\"  WHERE id = " . $id;
         //   $result = $this->db->query($query);
        //    if(!$result){
            //    echo $this->db->error;
          //  }
         //   return $result;
       // }
       // function remove($id){
          //  $query = "DELETE FROM teacher_schedule WHERE id = " . $id;
          //  $result = $this->db->query($query);
          //  if(!$result){
            //    echo $this->db->error;
          //  }
         //  return $result;
     //   }
   
   }