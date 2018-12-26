SELECT  teacher_schedule.instructor_user_id,course.code,course.name,course.credit, class.year,class.season_id,teacher_schedule.class_room_id, teacher_schedule.par, teacher_schedule.class_type_id
FROM class
INNER JOIN teacher_schedule ON class.id=  teacher_schedule.class_id 
INNER JOIN course ON class.course_id=course.id;
