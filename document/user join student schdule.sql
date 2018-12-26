SELECT user.username , student_schedule.student_user_id
FROM user
INNER JOIN student_schedule
ON  user.id=student_schedule.student_user_id;