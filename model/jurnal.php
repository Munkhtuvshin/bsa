<?php
require_once ROOT . '/model/Model.php';
class Jurnal extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll(){
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT lesson_calendar.id, teacher_schedule.class_id, lesson.subject, teacher_schedule.week_day, teacher_schedule.par, lesson_calendar.lesson_date FROM lesson_calendar INNER JOIN teacher_schedule ON teacher_schedule.id = lesson_calendar.teacher_schedule_id INNER JOIN lesson ON lesson.id = lesson_calendar.lesson_id'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getOne($id){
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT lesson.subject, user.id, student_lesson.point, user.first_name, user.last_name FROM lesson INNER JOIN student_lesson ON lesson.id = student_lesson.lesson_id INNER JOIN user ON student_lesson.student_user_id = user.id';
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function addStudentPoint($id, $dvn){ 
        $result = array(); // butsaah utga hadgalna
        $query = 'UPDATE student_lesson SET student_lesson.point = "'.$dvn.'" WHERE student_lesson.student_user_id = "'.$id.'"';
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
    }
}