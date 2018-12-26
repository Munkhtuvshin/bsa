<?php
require_once ROOT . '/model/model.php';
class div extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "    select * from Date_view;";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }

    function add($id,$lesson_date,$code,$student_count,$subject,$class_type_id,$name,$Duration){
        $query = "INSERT INTO Date_view VALUES (\"$id\",\"$lesson_date\",\"$code\",\"$student_count\",\"$subject\",\"$class_type_id\",\"$name\",\"$Duration\")";
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
         
        }  
        function edit($id){
            $result = array();
            $query = 'SELECT * FROM Date_view WHERE id = '.$id;
            $res = $this->db->query($query);
            while($row = $res->fetch_object()){
                $result[] = $row;
            }
            return $result;
        }
      
        function edit1($id, $lesson_date,$code,$student_count,$subject,$class_type_id,$name,$Duration){
            $result = array();
            var_dump($name);
            $query = "UPDATE Date_view SET lesson_date = \"$lesson_date\",code = \"$code\",student_count =\"$student_count\",subject = \"$subject\",class_type_id = \"$class_type_id\",name = \"$name\",Duration = \"$Duration\"  WHERE id = " . $id;
            $result = $this->db->query($query);
            if(!$result){
                echo $this->db->error;
            }
            return $result;
        }
        function remove($id){
            $query = "DELETE FROM Date_view WHERE id = " . $id;
            $result = $this->db->query($query);
            if(!$result){
                echo $this->db->error;
            }
            return $result;
        }
   
    }

       
        

   
 
