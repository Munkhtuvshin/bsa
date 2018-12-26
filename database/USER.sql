
CREATE TABLE `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `user_type_id` int(11) NOT NULL,
  `recovery_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_user_type_idx` (`user_type_id`),
  CONSTRAINT `fk_user_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `user_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE `user_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_field_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_details_user1_idx` (`user_id`),
  KEY `fk_user_details_user_field1_idx` (`user_field_id`),
  CONSTRAINT `fk_user_details_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_details_user_field1` FOREIGN KEY (`user_field_id`) REFERENCES `user_field` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `unblock_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `report_reason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE `block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `report_reason_id` int(11) NOT NULL,
  `blocked_date` datetime DEFAULT NULL,
  `unblocked_date` datetime DEFAULT NULL,
  `unblock_type_id` int(11) NULL,
  `parameter` text,
  PRIMARY KEY (`id`),
  KEY `fk_block_user1_idx` (`user_id`),
  KEY `fk_block_report_reason1_idx` (`report_reason_id`),
  KEY `fk_block_unblock_type1_idx` (`unblock_type_id`),
  CONSTRAINT `fk_block_report_reason1` FOREIGN KEY (`report_reason_id`) REFERENCES `report_reason` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_block_unblock_type1` FOREIGN KEY (`unblock_type_id`) REFERENCES `unblock_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_block_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reported_date` datetime DEFAULT NULL,
  `description` text,
  `report_reason_id` int(11) NOT NULL,
  `reported_by` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_report_report_reason1_idx` (`report_reason_id`),
  KEY `fk_report_user1_idx` (`user_id`),
  KEY `fk_report_user2_idx` (`reported_by`),
  CONSTRAINT `fk_report_report_reason1` FOREIGN KEY (`report_reason_id`) REFERENCES `report_reason` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_report_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_report_user2` FOREIGN KEY (`reported_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

ALTER TABLE user
ADD CONSTRAINT unique_mail UNIQUE (middle_name);

create view temp_users as SELECT user.*, block.blocked_date, block.unblocked_date 
FROM user left join block on block.user_id=user.id;
    
select * from temp_users;
DELIMITER //
CREATE PROCEDURE checkUser (IN param2 varchar(150), IN param3 VARCHAR(50))
 BEGIN
	select * from temp_users where password=param2 and username=param3;
 END;
//
DELIMITER ;

SELECT * FROM temp_users where ((blocked_date is null || unblocked_date is not null) and blocked_date <unblocked_date) or blocked_date is null || unblocked_date is null;

