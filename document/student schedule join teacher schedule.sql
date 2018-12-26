SELECT  student_schedule.student_user_id, teacher_schedule.id
FROM  student_schedule
INNER JOIN teacher_schedule
ON  student_schedule.student_user_id=teacher_schedule.id;