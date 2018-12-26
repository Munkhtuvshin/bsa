<?php
require_once ROOT . '/model/model.php';
class Detail extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "SELECT  school.name AS SC,school_user_type.name,school_user.code , last_name, user.first_name ,school_user_detail.value
        FROM school_user 
        INNER JOIN user ON school_user.user_id=user.id
        INNER JOIN school ON school_user.school_id=school_id
        INNER JOIN school_user_type ON school_user.school_user_type_id=school_user_type.id
        INNER JOIN school_user_detail ON school_user.id=school_user_detail.school_user_id
        WHERE user.id='1' and school.id='2'  ";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    }