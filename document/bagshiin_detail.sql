SELECT division.name AS SA,course.code, course.name AS CO
from division
INNER JOIN course ON division.id=course.division_id
WHERE division.id='2' and course.id='5'
