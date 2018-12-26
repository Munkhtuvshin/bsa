create view Date_view as (select C.id, C.lesson_date,U.code ,S.student_count, L.subject,L.class_type_id,CS.name, 2 as Duration from lesson_calendar as C
	left join (select teacher_schedule_id, count(*) as student_count from student_schedule
				group by teacher_schedule_id) as S on C.teacher_schedule_id = S.teacher_schedule_id
    left join lesson as L on C.lesson_id = L.id
    left join teacher_schedule as TS on C.teacher_schedule_id = TS.id
    left join class as K on TS.class_id = K.id
    left join course as U on K.course_id = U.id
    left join class_type as CS on TS.class_type_id=CS.id);
    
    select * from Date_view;
    
    
    
    select Date_view.id ,Date_view.lesson_date ,SUM(Date_view.Duration)   from  Date_view

WHERE  lesson_date>='2018-01-30 08:00:00' AND lesson_date<='2018-01-30 11:20:00'
group by class_type_id
having class_type_id=1;

/* I */
select Date.id ,Date.lesson_date , IFNULL(SUM(Date.Duration), 0) AS lec, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-01-30 08:00:00' AND lesson_date<='2018-01-30 11:20:00'
group by class_type_id having class_type_id=2), 0) as lab, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-01-30 08:00:00' AND lesson_date<='2018-01-30 11:20:00'
group by class_type_id having class_type_id=3), 0) as sem,
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-01-30 08:00:00' AND lesson_date<='2018-01-30 11:20:00'
group by class_type_id having class_type_id=4), 0) as bd
from  Date_view AS Date
WHERE  lesson_date>='2018-01-30 08:00:00' AND lesson_date<='2018-01-30 11:20:00'
group by class_type_id
having class_type_id=1;



/* II */
select Date.id ,Date.lesson_date , IFNULL(SUM(Date.Duration), 0) AS lec, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-02-06 08:00:00' AND lesson_date<='2018-02-27 11:20:00'
group by class_type_id having class_type_id=2), 0) as lab, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-02-06 08:00:00' AND lesson_date<='2018-02-27 11:20:00'
group by class_type_id having class_type_id=3), 0) as sem,
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-02-06 08:00:00' AND lesson_date<='2018-02-27 11:20:00'
group by class_type_id having class_type_id=4), 0) as bd
from  Date_view AS Date
WHERE  lesson_date>='2018-02-06 08:00:00' AND lesson_date<='2018-02-27 11:20:00'
group by class_type_id
having class_type_id=1;

/* III */
select Date.id ,Date.lesson_date , IFNULL(SUM(Date.Duration), 0) AS lec, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-03-06 08:00:00' AND lesson_date<='2018-03-27 11:20:00'
group by class_type_id having class_type_id=2), 0) as lab, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-03-06 08:00:00' AND lesson_date<='2018-03-27 11:20:00'
group by class_type_id having class_type_id=3), 0) as sem,
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-03-06 08:00:00' AND lesson_date<='2018-03-27 11:20:00'
group by class_type_id having class_type_id=4), 0) as bd
from  Date_view AS Date
WHERE  lesson_date>='2018-03-06 08:00:00' AND lesson_date<='2018-03-27 11:20:00'
group by class_type_id
having class_type_id=1;

/* IV*/
select Date.id ,Date.lesson_date , IFNULL(SUM(Date.Duration), 0) AS lec, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-04-03 08:00:00' AND lesson_date<='2018-04-24 11:20:00'
group by class_type_id having class_type_id=2), 0) as lab, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-04-03 08:00:00' AND lesson_date<='2018-04-24 11:20:00'
group by class_type_id having class_type_id=3), 0) as sem,
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-04-03 08:00:00' AND lesson_date<='2018-04-24 11:20:00'
group by class_type_id having class_type_id=4), 0) as bd
from  Date_view AS Date
WHERE  lesson_date>='2018-04-03 08:00:00' AND lesson_date<='2018-04-24 11:20:00'
group by class_type_id
having class_type_id=1;



/* V*/
select Date.id ,Date.lesson_date , IFNULL(SUM(Date.Duration), 0) AS lec, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-05-01 08:00:00' AND lesson_date<='2018-05-15 11:20:00'
group by class_type_id having class_type_id=2), 0) as lab, 
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-05-01 08:00:00' AND lesson_date<='2018-05-15 11:20:00'
group by class_type_id having class_type_id=3), 0) as sem,
IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-05-01 08:00:00' AND lesson_date<='2018-05-15 11:20:00'
group by class_type_id having class_type_id=4), 0) as bd
from  Date_view AS Date
WHERE  lesson_date>='2018-05-01 08:00:00' AND lesson_date<='2018-05-15 11:20:00'
group by class_type_id
having class_type_id=1;
