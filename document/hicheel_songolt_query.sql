Select D.id, D.lesson_date, D.code, D.subject , student_count, D.class_type_id, D.par from (select C.id,C.lesson_date,C.code,lesson.subject,lesson.class_type_id ,C.par, instructor_user_id
from (Select A.id, A.lesson_date, B.code ,A.lesson_id ,A.par, instructor_user_id
	from  (select teacher_schedule.id , instructor_user_id, par, lesson_id, lesson_calendar.lesson_date ,teacher_schedule.class_id 
		from teacher_schedule
		LEFT JOIN lesson_calendar ON teacher_schedule.id = lesson_calendar.teacher_schedule_id) AS A
		LEFT JOIN (select  course.code ,class.id
			from class
			Inner JOIN course ON class.course_id=course.id) AS B ON A.class_id= B.id) as C
			INNER JOIN lesson ON C.lesson_id = lesson.id) AS D
            LEFT JOIN student_schedule ON D.id = student_schedule.teacher_schedule_id group by id, code