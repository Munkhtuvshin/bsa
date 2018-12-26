<?php
require_once ROOT . '/model/Model.php';
class TsagBvrtgel extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT course.id AS idd, course.name, course.code, course.credit, class_type.name AS class_type_name, lesson_calendar.id FROM lesson_calendar INNER JOIN teacher_schedule ON teacher_schedule.id = lesson_calendar.teacher_schedule_id INNER JOIN class_type ON class_type.id = teacher_schedule.class_type_id INNER JOIN class ON teacher_schedule.class_id = class.id INNER JOIN course ON course.id = class.course_id'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getOne($id) {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT lesson.subject, course.code, class_type.name AS type, lesson_calendar.lesson_date AS date, COUNT(student_schedule.student_user_id) AS std_count FROM lesson INNER JOIN class ON lesson.class_id = class.id INNER JOIN course ON class.course_id = course.id INNER JOIN lesson_calendar ON lesson_calendar.lesson_id = lesson.id INNER JOIN class_type ON class_type.id = lesson.class_type_id INNER JOIN teacher_schedule ON teacher_schedule.class_id = class.id INNER JOIN student_schedule ON student_schedule.teacher_schedule_id = teacher_schedule.id WHERE course.id = "'.$id.'" GROUP BY lesson.subject, course.code, type, date';// select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }    
}