SELECT *
FROM eschool.group as g INNER JOIN eschool.profession_class as pc
ON g.table_pk = pc.id INNER JOIN eschool.profession as p ON pc.profession_id = p.id
WHERE g.table_id = 2 ;