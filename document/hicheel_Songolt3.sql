select C.id, C.lesson_date,U.code ,S.student_count, L.subject,CS.name, 2 as Duration from lesson_calendar as C
	left join (select teacher_schedule_id, count(*) as student_count from student_schedule
				group by teacher_schedule_id) as S on C.teacher_schedule_id = S.teacher_schedule_id
    left join lesson as L on C.lesson_id = L.id
    left join teacher_schedule as TS on C.teacher_schedule_id = TS.id
    left join class as K on TS.class_id = K.id
    left join course as U on K.course_id = U.id
    left join class_type as CS on TS.class_type_id=CS.id
 

   

    