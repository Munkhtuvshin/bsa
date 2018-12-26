INSERT INTO lesson (id, class_type_id, class_id,subject,description)
VALUES  (1, 1, 1,'Хичээлийн танилцуулга',''),
		(2, 2, 1,'Java хэл дээр консол орчны програм бичих',''),
        (3, 1, 1,'Вэб сервис ба RESTful API',''),
        (4, 2, 1,'Java хэл дээр консол орчны програм бичих',''),
        (5, 1, 1,'Вэб сервис ба RESTful API',''),
        (6, 2, 1,'Мэдээлэл харуулах вэб сервис бичих',''),
        (7, 1, 1,'JSON ба Spring Boot',''),
        (8, 2, 1,'Мэдээлэл харуулах вэб сервис бичих',''),
        (9, 1, 1,'JSON ба Spring Boot',''),
        (10, 2, 1,'Мэдээлэл харуулах вэб сервис бичих',''),
        (11, 4, 1,'Spring boot ашиглан REST сервис хийх',''),
        (12, 1, 1,'JSON ба Spring Boot',''),
        (13, 2, 1,'JSON-р мэдээлэл харуулах вэб сервис бичих',''),
        (14, 4, 1,'Spring boot ашиглан REST сервис хийх',''),
        (15, 1, 1,'Spring Boot ба MySQL',''),
        (16, 2, 1,'JSON-р мэдээлэл харуулах вэб сервис бичих',''),
        (17, 4, 1,'Spring boot ашиглан REST сервис хийх',''),
        (18, 1, 1,'Spring Boot Join хийх',''),
        (19, 2, 1,'Мэдээлэл бүртгэх вэб сервис хийх',''),
        (20, 4, 1,'Spring boot ашиглан REST сервис хийх',''),
        (21, 1, 1,'JavaScript-н тухай',''),
        (22, 2, 1,'Мэдээлэл бүртгэх вэб сервис хийх',''),
        (23, 4, 1,'Spring boot ашиглан REST сервис хийх',''),
        (24, 1, 1,'JavaScript AJAX',''),
        (25, 2, 1,'JavaScript тоглоом',''),
        (26, 4, 1,'Spring boot ашиглан REST сервис хийх',''),
        (27, 1, 1,'AngularJS-н тухай',''),
        (28, 2, 1,'JavaScript тоглоом',''),
        (29, 4, 1,'AngularJS ашиглан GUI хийх',''),
        (30, 1, 1,'AngularJS binding',''),
        (31, 2, 1,'AJAX',''),
        (32, 4, 1,'AngularJS ашиглан GUI хийх',''),
        (33, 1, 1,'AngularJS route хийх',''),
        (34, 2, 1,'AJAX',''),
        (36, 1, 1,'AngularJS resource ашиглах',''),
        (37, 2, 1,'Spring boot & AngularJS',''),
        (39, 1, 1,'AngularJS directive үүсгэх',''),
        (40, 2, 1,'Spring boot & AngularJS',''),
        (42, 1, 1,'Тойм лекц',''),
        (43, 1, 1,'Spring boot & AngularJS','');
        
INSERT INTO user (id, username, password,first_name,middle_name,last_name,user_type_id,recovery_code)
VALUES ('1', 'zolboo', '123','Золбоо','Тэмэээт','Төмөрболд',1,0);

INSERT INTO user (id, username, password,first_name,middle_name,last_name,user_type_id,recovery_code)
VALUES ('2', 'БАЯРХҮҮ ', '123','БАЯРХҮҮ ','Боржгон','О.',1,0);

INSERT INTO user (id, username, password,first_name,middle_name,last_name,user_type_id,recovery_code)
VALUES ('32', 'ХАНГАЛ ', '123','ХАНГАЛ ','Боржгон','О.',1,0);

INSERT INTO user (id, username, password,first_name,middle_name,last_name,user_type_id,recovery_code)
VALUES ('27', 'ХҮСЛЭН ', '123','ХҮСЛЭН ','Боржгон','О.',1,0);

INSERT INTO user (id, username, password,first_name,middle_name,last_name,user_type_id,recovery_code)
VALUES ('3', 'ТЭМҮҮЛЭН ', '123','ТЭМҮҮЛЭН','Боржгон','Э.',1,0),
	   ('4', 'МӨНХ-ЭРДЭНЭ','123','МӨНХ-ЭРДЭНЭ','Боржгон','Б.',1,0),
       ('5', 'СИЙЛЭГМАА','123','СИЙЛЭГМАА','Боржгон','Д.',1,0),
       ('6', 'БОЛОРТУЯА ','123','БОЛОРТУЯА','Боржгон','О.',1,0),
       ('7', 'АДЪЯАБААТАР','123','АДЪЯАБААТАР','Боржгон','Г.',1,0),
       ('8', 'ЛХАМ ','123','ЛХАМ ','Боржгон','О.',1,0),
       ('9', 'АЛТАНАА ','123','АЛТАНАА','Боржгон','Б.',1,0),
       ('10', 'ХАЛИУНАА ','123','ХАЛИУНАА','Боржгон','О.',1,0),
       ('11', 'БЭЛГҮТЭЙ ','123','БЭЛГҮТЭЙ','Боржгон','Б.',1,0),
       ('12', 'ТӨГСБАЯСГАЛАН ','123','ТӨГСБАЯСГАЛАН ','Боржгон','Г.',1,0),
       ('13', 'САРАНЗАЯА ','123','САРАНЗАЯА ','Боржгон','Б.',1,0),
       ('14', 'БАЯРСАЙХАН ','123','БАЯРСАЙХАН ','Боржгон','А.',1,0),
       ('15', 'АЛТАНСУВД ','123','АЛТАНСУВД','Боржгон','Б.',1,0),
       ('16', 'ТӨГӨЛДӨР ','123','ТӨГӨЛДӨР','Боржгон','М.',1,0),
       ('17', 'МӨНХТҮВШИН ','123','МӨНХТҮВШИН ','Боржгон','Д.',1,0),
       ('18', 'СУГАРАА ','123','СУГАРАА ','Боржгон','О.',1,0),
       ('19', 'БУМДАРЬ ','123','БУМДАРЬ ','Боржгон','Б.',1,0),
       ('20', 'ЭНХМАА ','123','ЭНХМАА ','Боржгон','Д.',1,0),
       ('21', 'ЧИНЗОРИГ ','123','ЧИНЗОРИГ','Боржгон','П.',1,0),
       ('22', 'БАТСАЙН ','123','БАТСАЙН','Боржгон','Б.',1,0),
       ('23', 'БАТТУЛГА','123','БАТТУЛГА','Боржгон','Ц.',1,0),
       ('24', 'НАСАНЖАРГАЛ ','123','НАСАНЖАРГАЛ ','Боржгон','О.',1,0),
       ('25', 'ЦОЛМОНБААТАР ','123','ЦОЛМОНБААТАР','Боржгон','Б.',1,0),
       ('26', 'БЯМБАДОРЖ ','123','БЯМБАДОРЖ ','Боржгон','Г.',1,0),
       ('28', 'АЮУШ ','123','АЮУШ','Боржгон','Б.',1,0),
       ('29', 'САРНАЙ','123','САРНАЙ','Боржгон','С.',1,0),
       ('30', 'ХУЛАН','123','ХУЛАН','Боржгон','Х.',1,0),
       ('31', 'ГАНАА','123','ГАНЦЭЦЭГ','Боржгон','Г.',1,0);

INSERT INTO student_schedule(teacher_schedule_id,student_user_id)
VALUES(1,2);

INSERT INTO student_schedule(teacher_schedule_id,student_user_id)
VALUES(3,2),
	  (2,2);

INSERT INTO student_schedule(teacher_schedule_id,student_user_id)
VALUES(1,3),
	  (2,3),
	  (3,3);
      
INSERT INTO student_schedule(teacher_schedule_id,student_user_id)
VALUES(1,27),
	  (2,27),
	  (3,27);

INSERT INTO student_schedule(teacher_schedule_id,student_user_id)
VALUES(1,4),
	  (2,4),
	  (3,4),
      (1,5),
	  (2,5),
	  (3,5),
      (1,6),
	  (2,6),
	  (3,6),
      (1,7),
	  (2,7),
	  (3,7),
      (1,8),
	  (2,8),
	  (3,8),
      (1,9),
	  (2,9),
	  (3,9),
      (1,10),
	  (2,10),
	  (3,10),
      (1,11),
	  (2,11),
	  (3,11),
      (1,12),
	  (2,12),
	  (3,12),
      (1,13),
	  (2,13),
	  (3,13),
      (1,14),
	  (2,14),
	  (3,14),
      (1,15),
	  (2,15),
	  (3,15),
      (1,16),
	  (2,16),
	  (3,16),
      (1,17),
	  (2,17),
	  (3,17),
      (1,18),
	  (2,18),
	  (3,18),
      (1,19),
	  (2,19),
	  (3,19),
      (1,20),
	  (2,20),
	  (3,20);


INSERT INTO student_schedule(teacher_schedule_id,student_user_id)
VALUES (1,21),
	  (2,21),
	  (3,21),
      (1,22),
	  (2,22),
	  (3,22),
      (1,23),
	  (2,23),
	  (3,23),
      (1,24),
	  (2,24),
	  (3,24),
      (1,25),
	  (2,25),
	  (3,25),
      (1,26),
	  (2,26),
	  (3,26);
      
 INSERT INTO student_schedule(teacher_schedule_id,student_user_id)
VALUES   
      (1,28),
	  (2,28),
	  (3,28),
      (1,29),
	  (2,29),
	  (3,29),
      (1,30),
	  (2,30),
	  (3,30),
      (1,31),
	  (2,31),
	  (3,31),
      (1,32),
	  (2,32),
	  (3,32);

INSERT INTO school_user(id, code,school_id,user_id,school_user_type_id,start_date,end_date,profession_class_id,school_user_detail_id)
VALUES (1,'D.IS10',2,1,2, '2010-09-01','2060-09-01',1,1);


INSERT INTO  school_user_detail(id, school_user_id, user_field_id,value)
VALUES (1, 1,4, 'Магистр');

INSERT INTO profession_class(id, start_date, adviser_id,profession_id,user_id)
VALUES (1, '2010-09-01', 1,1,1);

INSERT INTO teacher_schedule(id, week_day,par,class_id,class_type_id,instructor_user_id,class_room_id)
VALUES  (1,1,1,1,1,1,2 ),
		(2,1,1,1,2,1,3 ),
		(3,1,1,1,4,1,3 );
        
INSERT INTO lesson_calendar(id, teacher_schedule_id,lesson_id,lesson_date)
VALUES  (1,1,1,'2018-01-30 08:00:00'),
		(2,2,2,'2018-01-30 09:40:00' ),
        (3,1,3,'2018-02-06 08:00:00'),
        (4,2,4,'2018-02-06 09:40:00'),
        (5,1,5,'2018-02-13 08:00:00'),
        (6,2,6,'2018-02-13 09:40:00'),
        (7,1,7,'2018-02-20 08:00:00'),
        (8,2,8,'2018-02-20 09:40:00'),
        (9,1,9,'2018-02-27 08:00:00'),
        (10,2,10,'2018-02-27 09:40:00'),
        (11,3,11,'2018-02-27 11:20:00'),
        (12,1,12,'2018-03-06 08:00:00'),
        (13,2,13,'2018-03-06 09:40:00'),
        (14,3,14,'2018-03-06 11:20:00'),
        (15,1,15,'2018-03-13 08:00:00'),
        (16,2,16,'2018-03-13 09:40:00'),
        (17,3,17,'2018-03-13 11:20:00'),
        (18,1,18,'2018-03-20 08:00:00'),
        (19,2,19,'2018-03-20 09:40:00'),
        (20,3,20,'2018-03-20 11:20:00'),
        (21,1,21,'2018-03-27 08:00:00'),
        (22,2,22,'2018-03-27 09:40:00'),
        (23,3,23,'2018-03-27 11:20:00'),
        (24,1,24,'2018-04-03 08:00:00'),
        (25,2,25,'2018-04-03 09:40:00'),
        (26,3,26,'2018-04-03 11:20:00'),
        (27,1,27,'2018-04-10 08:00:00'),
        (28,2,28,'2018-04-10 09:40:00'),
        (29,3,29,'2018-04-10 11:20:00'),
        (30,1,30,'2018-04-17 08:00:00'),
        (31,2,31,'2018-04-17 09:40:00'),
        (32,3,32,'2018-04-17 11:20:00'),
        (33,1,33,'2018-04-24 08:00:00'),
        (34,2,34,'2018-04-24 09:40:00'),
        (36,1,36,'2018-05-01 08:00:00'),
        (37,2,37,'2018-05-01 09:40:00'),
        (39,1,39,'2018-05-08 08:00:00'),
        (40,2,40,'2018-05-08 09:40:00'),
        (42,1,42,'2018-05-15 08:00:00'),
        (43,2,43,'2018-05-15 09:40:00');
	   