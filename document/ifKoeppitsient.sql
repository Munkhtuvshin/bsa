 select code  ,IF(code>330 ,"More","Less")
 from course;
 
SELECT code,IF(LOCATE('3',code),"1.2","Less") 
FROM course 
WHERE id='5' and locate('3',code)>4;
/*4 dehi elemented 3 orson bol 1.2 koэффициент*/

SELECT code 
FROM course 
WHERE id='5';

select  IF(id=1 ,"2","1")
 from class_type
 WHERE id='1';
 /*kegts labiin kredit*/
 
 SELECT IF(SUBSTRING(code, 5, 1)=3,"1.2","Less")  AS m
FROM course
WHERE id='5';
/*tasalj awah*/
 
 
