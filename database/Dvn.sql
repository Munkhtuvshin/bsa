CREATE TABLE `class_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ; 
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_address_address1_idx` (`parent_id`),
  CONSTRAINT `fk_address_address1` FOREIGN KEY (`parent_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `address` varchar(45) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_School_School1_idx` (`parent_id`),
  KEY `fk_school_address1_idx` (`address_id`),
  CONSTRAINT `fk_School_School1` FOREIGN KEY (`parent_id`) REFERENCES `school` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_school_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;


CREATE TABLE `division_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE `division` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `division_type_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_division_division1_idx` (`parent_id`),
  KEY `fk_division_division_type1_idx` (`division_type_id`),
  KEY `fk_division_school1_idx` (`school_id`),
  CONSTRAINT `fk_division_division1` FOREIGN KEY (`parent_id`) REFERENCES `division` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_division_division_type1` FOREIGN KEY (`division_type_id`) REFERENCES `division_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_division_school1` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `course_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `division_id` int(11) NOT NULL,
  `course_type_id` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_course_division1_idx` (`division_id`),
  KEY `fk_course_course_type1_idx` (`course_type_id`),
  CONSTRAINT `fk_course_course_type1` FOREIGN KEY (`course_type_id`) REFERENCES `course_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_division1` FOREIGN KEY (`division_id`) REFERENCES `division` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `season_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_class_course1_idx` (`course_id`),
  KEY `fk_class_season1_idx` (`season_id`),
  CONSTRAINT `fk_class_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_class_season1` FOREIGN KEY (`season_id`) REFERENCES `season` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;


CREATE TABLE `lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_type_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_lesson_class_type1_idx` (`class_type_id`),
  KEY `fk_lesson_class1_idx` (`class_id`),
  CONSTRAINT `fk_lesson_class1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lesson_class_type1` FOREIGN KEY (`class_type_id`) REFERENCES `class_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `student_lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `point` int(11) DEFAULT NULL,
  `description` text,
  `lesson_id` int(11) NOT NULL,
  `student_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_student_lesson_lesson1_idx` (`lesson_id`),
  KEY `fk_student_lesson_user1_idx` (`student_user_id`),
  CONSTRAINT `fk_student_lesson_lesson1` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_lesson_user1` FOREIGN KEY (`student_user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `eschool`.`examination` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `start_date` DATETIME NULL,
  `end_date` DATETIME NULL,
  `point` INT NULL,
  `class_id` INT NOT NULL,
  `instructor_user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_examination_class1_idx` (`class_id` ASC),
  INDEX `fk_examination_user1_idx` (`instructor_user_id` ASC),
  CONSTRAINT `fk_examination_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `eschool`.`class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_examination_user1`
    FOREIGN KEY (`instructor_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE IF NOT EXISTS `eschool`.`student_examination` (
  `examination_id` INT NOT NULL,
  `student_user_id` INT NOT NULL,
  `point` INT NOT NULL,
  PRIMARY KEY (`examination_id`, `student_user_id`),
  INDEX `fk_student_examination_examination1_idx` (`examination_id` ASC),
  INDEX `fk_student_examination_user1_idx` (`student_user_id` ASC),
  CONSTRAINT `fk_student_examination_examination1`
    FOREIGN KEY (`examination_id`)
    REFERENCES `eschool`.`examination` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_examination_user1`
    FOREIGN KEY (`student_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
    
    create view temp_users as SELECT user.*, block.blocked_date, block.unblocked_date FROM user left join block on block.user_id=user.id;
    
    select u.*, stl.id as student_lesson_id, stl.point, ct.name from ((user as u inner join student_lesson as stl on stl.student_user_id=u.id) inner join lesson as l on l.id=stl.lesson_id)
	inner join class_type as ct on ct.id=l.class_type_id where l.id=1;
    
    
    create table course_class_type( `id` INT NOT NULL AUTO_INCREMENT, `course_id` INT NOT NULL,
	`class_type_id` INT NOT NULL, PRIMARY KEY (`id`),
	CONSTRAINT `class_type_id_fk` FOREIGN KEY (`class_type_id`) REFERENCES `class_type` (`id`),
	CONSTRAINT `course_id_fk` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`));
 
		DELIMITER //
		CREATE PROCEDURE simpleproc1 (IN param2 INT, IN param3 VARCHAR(50))
		 BEGIN
			DROP TEMPORARY TABLE IF EXISTS tab3;
			CREATE TEMPORARY TABLE tab3 AS ( 
			select u.*, count(sl.point) as too FROM ((((course as c left join course_class_type as cct on cct.course_id=c.id) left join class_type 
			as ct on ct.id=cct.class_type_id) left join lesson as l on l.class_type_id=ct.id ) left join student_lesson as sl
			on sl.lesson_id=l.id) inner join user as u on u.id=sl.student_user_id
			where ct.name=param3 && c.id=param2 group by u.id
			);
			select max(too) as mtoo from tab3 ;
		 END;
		//
		DELIMITER ;
        
        	SELECT u.*, sl.point, l.description, ct.name, se.point as onooo FROM (((((course as c inner join course_class_type as cct on cct.course_id=c.id) inner join class_type 
	as ct on ct.id=cct.class_type_id) inner join lesson as l on l.class_type_id=ct.id ) inner join student_lesson as sl
	on sl.lesson_id=l.id) inner join user as u on u.id=sl.student_user_id) left join student_examination as se on se.student_user_id=u.id 
	where c.id=1;