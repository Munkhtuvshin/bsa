SELECT  school.name AS SC,school_user_type.name,school_user.code , last_name, user.first_name 
FROM school_user 
INNER JOIN user ON school_user.user_id=user.id
INNER JOIN school ON school_user.school_id=school_id
INNER JOIN school_user_type ON school_user.school_user_type_id=school_user_type.id
WHERE user.id='9' and school.id='2' 