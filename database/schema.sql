-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema eschool
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `eschool` ;

-- -----------------------------------------------------
-- Schema eschool
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `eschool` DEFAULT CHARACTER SET utf8 ;
USE `eschool` ;

-- -----------------------------------------------------
-- Table `eschool`.`user_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`user_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`user_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`user` ;

CREATE TABLE IF NOT EXISTS `eschool`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `first_name` VARCHAR(45) NULL,
  `middle_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `user_type_id` INT NOT NULL,
  `recovery_code` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_user_type`
    FOREIGN KEY (`user_type_id`)
    REFERENCES `eschool`.`user_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_user_user_type_idx` ON `eschool`.`user` (`user_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`address` ;

CREATE TABLE IF NOT EXISTS `eschool`.`address` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `parent_id` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_address_address1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `eschool`.`address` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_address_address1_idx` ON `eschool`.`address` (`parent_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`school`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`school` ;

CREATE TABLE IF NOT EXISTS `eschool`.`school` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` TEXT NULL,
  `address` VARCHAR(255) NULL,
  `parent_id` INT NULL,
  `address_id` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_School_School1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `eschool`.`school` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_school_address1`
    FOREIGN KEY (`address_id`)
    REFERENCES `eschool`.`address` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_School_School1_idx` ON `eschool`.`school` (`parent_id` ASC);

CREATE INDEX `fk_school_address1_idx` ON `eschool`.`school` (`address_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`school_user_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`school_user_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`school_user_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`division_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`division_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`division_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`division`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`division` ;

CREATE TABLE IF NOT EXISTS `eschool`.`division` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` TEXT NULL,
  `division_type_id` INT NOT NULL,
  `school_id` INT NOT NULL,
  `parent_id` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_division_division1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `eschool`.`division` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_division_division_type1`
    FOREIGN KEY (`division_type_id`)
    REFERENCES `eschool`.`division_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_division_school1`
    FOREIGN KEY (`school_id`)
    REFERENCES `eschool`.`school` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_division_division1_idx` ON `eschool`.`division` (`parent_id` ASC);

CREATE INDEX `fk_division_division_type1_idx` ON `eschool`.`division` (`division_type_id` ASC);

CREATE INDEX `fk_division_school1_idx` ON `eschool`.`division` (`school_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`profession`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`profession` ;

CREATE TABLE IF NOT EXISTS `eschool`.`profession` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `division_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_profession_division1`
    FOREIGN KEY (`division_id`)
    REFERENCES `eschool`.`division` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_profession_division1_idx` ON `eschool`.`profession` (`division_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`profession_class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`profession_class` ;

CREATE TABLE IF NOT EXISTS `eschool`.`profession_class` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `start_date` DATE NOT NULL,
  `adviser_id` INT NULL,
  `profession_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_profession_class_profession1`
    FOREIGN KEY (`profession_id`)
    REFERENCES `eschool`.`profession` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profession_class_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_profession_class_profession1_idx` ON `eschool`.`profession_class` (`profession_id` ASC);

CREATE INDEX `fk_profession_class_user1_idx` ON `eschool`.`profession_class` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`school_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`school_user` ;

CREATE TABLE IF NOT EXISTS `eschool`.`school_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NULL,
  `school_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `school_user_type_id` INT NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NULL,
  `profession_class_id` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_school_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_school_school1`
    FOREIGN KEY (`school_id`)
    REFERENCES `eschool`.`school` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_school_user_school_user_type1`
    FOREIGN KEY (`school_user_type_id`)
    REFERENCES `eschool`.`school_user_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_school_user_profession_class1`
    FOREIGN KEY (`profession_class_id`)
    REFERENCES `eschool`.`profession_class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_user_school_user1_idx` ON `eschool`.`school_user` (`user_id` ASC);

CREATE INDEX `fk_user_school_school1_idx` ON `eschool`.`school_user` (`school_id` ASC);

CREATE INDEX `fk_school_user_school_user_type1_idx` ON `eschool`.`school_user` (`school_user_type_id` ASC);

CREATE INDEX `fk_school_user_profession_class1_idx` ON `eschool`.`school_user` (`profession_class_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`user_field`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`user_field` ;

CREATE TABLE IF NOT EXISTS `eschool`.`user_field` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`user_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`user_detail` ;

CREATE TABLE IF NOT EXISTS `eschool`.`user_detail` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `user_field_id` INT NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_details_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_details_user_field1`
    FOREIGN KEY (`user_field_id`)
    REFERENCES `eschool`.`user_field` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_user_details_user1_idx` ON `eschool`.`user_detail` (`user_id` ASC);

CREATE INDEX `fk_user_details_user_field1_idx` ON `eschool`.`user_detail` (`user_field_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`class_room`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`class_room` ;

CREATE TABLE IF NOT EXISTS `eschool`.`class_room` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `floor` VARCHAR(3) NULL,
  `capacity` INT NULL,
  `school_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_class_room_school1`
    FOREIGN KEY (`school_id`)
    REFERENCES `eschool`.`school` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_class_room_school1_idx` ON `eschool`.`class_room` (`school_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`relation_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`relation_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`relation_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`relation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`relation` ;

CREATE TABLE IF NOT EXISTS `eschool`.`relation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `related_user_id` INT NOT NULL,
  `relation_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_friend_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_friend_user2`
    FOREIGN KEY (`related_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_relation_relation_type1`
    FOREIGN KEY (`relation_type_id`)
    REFERENCES `eschool`.`relation_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_friend_user1_idx` ON `eschool`.`relation` (`user_id` ASC);

CREATE INDEX `fk_friend_user2_idx` ON `eschool`.`relation` (`related_user_id` ASC);

CREATE INDEX `fk_relation_relation_type1_idx` ON `eschool`.`relation` (`relation_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`course_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`course_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`course_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`course`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`course` ;

CREATE TABLE IF NOT EXISTS `eschool`.`course` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `code` VARCHAR(45) NULL,
  `credit` INT NULL,
  `division_id` INT NOT NULL,
  `course_type_id` INT NOT NULL,
  `description` TEXT NULL,
  `is_diploma` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_course_division1`
    FOREIGN KEY (`division_id`)
    REFERENCES `eschool`.`division` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_course_type1`
    FOREIGN KEY (`course_type_id`)
    REFERENCES `eschool`.`course_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_course_division1_idx` ON `eschool`.`course` (`division_id` ASC);

CREATE INDEX `fk_course_course_type1_idx` ON `eschool`.`course` (`course_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`season`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`season` ;

CREATE TABLE IF NOT EXISTS `eschool`.`season` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`class` ;

CREATE TABLE IF NOT EXISTS `eschool`.`class` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `year` INT NOT NULL,
  `season_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_class_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `eschool`.`course` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_class_season1`
    FOREIGN KEY (`season_id`)
    REFERENCES `eschool`.`season` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_class_course1_idx` ON `eschool`.`class` (`course_id` ASC);

CREATE INDEX `fk_class_season1_idx` ON `eschool`.`class` (`season_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`class_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`class_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`class_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`teacher_schedule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`teacher_schedule` ;

CREATE TABLE IF NOT EXISTS `eschool`.`teacher_schedule` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `week_day` INT NOT NULL,
  `par` INT NOT NULL,
  `class_id` INT NOT NULL,
  `class_type_id` INT NOT NULL,
  `instructor_user_id` INT NOT NULL,
  `class_room_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_teacher_schedule_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `eschool`.`class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_teacher_schedule_user1`
    FOREIGN KEY (`instructor_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_teacher_schedule_class_type1`
    FOREIGN KEY (`class_type_id`)
    REFERENCES `eschool`.`class_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_teacher_schedule_class_room1`
    FOREIGN KEY (`class_room_id`)
    REFERENCES `eschool`.`class_room` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_teacher_schedule_class1_idx` ON `eschool`.`teacher_schedule` (`class_id` ASC);

CREATE INDEX `fk_teacher_schedule_class_type1_idx` ON `eschool`.`teacher_schedule` (`class_type_id` ASC);

CREATE INDEX `fk_teacher_schedule_class_room1_idx` ON `eschool`.`teacher_schedule` (`class_room_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`par`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`par` ;

CREATE TABLE IF NOT EXISTS `eschool`.`par` (
  `school_id` INT NOT NULL,
  `id` INT NOT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME NOT NULL,
  PRIMARY KEY (`school_id`, `id`),
  CONSTRAINT `fk_par_school1`
    FOREIGN KEY (`school_id`)
    REFERENCES `eschool`.`school` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_par_school1_idx` ON `eschool`.`par` (`school_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`student_schedule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`student_schedule` ;

CREATE TABLE IF NOT EXISTS `eschool`.`student_schedule` (
  `teacher_schedule_id` INT NOT NULL,
  `student_user_id` INT NOT NULL,
  PRIMARY KEY (`teacher_schedule_id`, `student_user_id`),
  CONSTRAINT `fk_student_schedule_teacher_schedule1`
    FOREIGN KEY (`teacher_schedule_id`)
    REFERENCES `eschool`.`teacher_schedule` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_schedule_user1`
    FOREIGN KEY (`student_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_student_schedule_teacher_schedule1_idx` ON `eschool`.`student_schedule` (`teacher_schedule_id` ASC);

CREATE INDEX `fk_student_schedule_user1_idx` ON `eschool`.`student_schedule` (`student_user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`lesson`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`lesson` ;

CREATE TABLE IF NOT EXISTS `eschool`.`lesson` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `class_type_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_lesson_class_type1`
    FOREIGN KEY (`class_type_id`)
    REFERENCES `eschool`.`class_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lesson_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `eschool`.`class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_lesson_class_type1_idx` ON `eschool`.`lesson` (`class_type_id` ASC);

CREATE INDEX `fk_lesson_class1_idx` ON `eschool`.`lesson` (`class_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`course_dependency_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`course_dependency_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`course_dependency_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`course_dependency`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`course_dependency` ;

CREATE TABLE IF NOT EXISTS `eschool`.`course_dependency` (
  `course_id` INT NOT NULL,
  `required_course_id` INT NOT NULL,
  `cource_dependency_type_id` INT NOT NULL,
  PRIMARY KEY (`course_id`, `required_course_id`),
  CONSTRAINT `fk_course_dependency_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `eschool`.`course` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_dependency_course2`
    FOREIGN KEY (`required_course_id`)
    REFERENCES `eschool`.`course` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_dependency_cource_dependency_type1`
    FOREIGN KEY (`cource_dependency_type_id`)
    REFERENCES `eschool`.`course_dependency_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_course_dependency_course1_idx` ON `eschool`.`course_dependency` (`course_id` ASC);

CREATE INDEX `fk_course_dependency_course2_idx` ON `eschool`.`course_dependency` (`required_course_id` ASC);

CREATE INDEX `fk_course_dependency_cource_dependency_type1_idx` ON `eschool`.`course_dependency` (`cource_dependency_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`school_user_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`school_user_detail` ;

CREATE TABLE IF NOT EXISTS `eschool`.`school_user_detail` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `school_user_id` INT NOT NULL,
  `user_field_id` INT NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_school_user_detail_user_field1`
    FOREIGN KEY (`user_field_id`)
    REFERENCES `eschool`.`user_field` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_school_user_detail_school_user1`
    FOREIGN KEY (`school_user_id`)
    REFERENCES `eschool`.`school_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_school_user_detail_user_field1_idx` ON `eschool`.`school_user_detail` (`user_field_id` ASC);

CREATE INDEX `fk_school_user_detail_school_user1_idx` ON `eschool`.`school_user_detail` (`school_user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`course_class_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`course_class_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`course_class_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `class_type_id` INT NOT NULL,
  `time` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_course_class_type_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `eschool`.`course` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_class_type_class_type1`
    FOREIGN KEY (`class_type_id`)
    REFERENCES `eschool`.`class_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_course_class_type_course1_idx` ON `eschool`.`course_class_type` (`course_id` ASC);

CREATE INDEX `fk_course_class_type_class_type1_idx` ON `eschool`.`course_class_type` (`class_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`course_season`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`course_season` ;

CREATE TABLE IF NOT EXISTS `eschool`.`course_season` (
  `course_id` INT NOT NULL,
  `season_id` INT NOT NULL,
  PRIMARY KEY (`course_id`, `season_id`),
  CONSTRAINT `fk_course_season_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `eschool`.`course` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_season_season1`
    FOREIGN KEY (`season_id`)
    REFERENCES `eschool`.`season` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_course_season_course1_idx` ON `eschool`.`course_season` (`course_id` ASC);

CREATE INDEX `fk_course_season_season1_idx` ON `eschool`.`course_season` (`season_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`course_book`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`course_book` ;

CREATE TABLE IF NOT EXISTS `eschool`.`course_book` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `is_required` TINYINT NULL,
  `class_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_course_book_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `eschool`.`class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_course_book_class1_idx` ON `eschool`.`course_book` (`class_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`lesson_point`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`lesson_point` ;

CREATE TABLE IF NOT EXISTS `eschool`.`lesson_point` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `start_date` DATETIME NULL,
  `end_date` DATETIME NULL,
  `point` INT NOT NULL,
  `lesson_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_lesson_point_lesson1`
    FOREIGN KEY (`lesson_id`)
    REFERENCES `eschool`.`lesson` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_lesson_point_lesson1_idx` ON `eschool`.`lesson_point` (`lesson_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`student_lesson`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`student_lesson` ;

CREATE TABLE IF NOT EXISTS `eschool`.`student_lesson` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `point` INT NULL,
  `description` TEXT NULL,
  `lesson_id` INT NOT NULL,
  `student_user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_student_lesson_lesson1`
    FOREIGN KEY (`lesson_id`)
    REFERENCES `eschool`.`lesson` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_lesson_user1`
    FOREIGN KEY (`student_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_student_lesson_lesson1_idx` ON `eschool`.`student_lesson` (`lesson_id` ASC);

CREATE INDEX `fk_student_lesson_user1_idx` ON `eschool`.`student_lesson` (`student_user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`table`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`table` ;

CREATE TABLE IF NOT EXISTS `eschool`.`table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`album`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`album` ;

CREATE TABLE IF NOT EXISTS `eschool`.`album` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `item_count` INT NULL,
  `user_id` INT NOT NULL,
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_album_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_album_owner_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_album_user1_idx` ON `eschool`.`album` (`user_id` ASC);

CREATE INDEX `fk_album_owner_type1_idx` ON `eschool`.`album` (`table_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`album_item_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`album_item_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`album_item_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`access_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`access_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`access_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`album_item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`album_item` ;

CREATE TABLE IF NOT EXISTS `eschool`.`album_item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `location` VARCHAR(255) NULL,
  `item_date` DATETIME NOT NULL,
  `album_id` INT NOT NULL,
  `album_item_type_id` INT NOT NULL,
  `access_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_album_item_album1`
    FOREIGN KEY (`album_id`)
    REFERENCES `eschool`.`album` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_album_item_album_item_type1`
    FOREIGN KEY (`album_item_type_id`)
    REFERENCES `eschool`.`album_item_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_album_item_access_type1`
    FOREIGN KEY (`access_type_id`)
    REFERENCES `eschool`.`access_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_album_item_album1_idx` ON `eschool`.`album_item` (`album_id` ASC);

CREATE INDEX `fk_album_item_album_item_type1_idx` ON `eschool`.`album_item` (`album_item_type_id` ASC);

CREATE INDEX `fk_album_item_access_type1_idx` ON `eschool`.`album_item` (`access_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`report_reason`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`report_reason` ;

CREATE TABLE IF NOT EXISTS `eschool`.`report_reason` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`report`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`report` ;

CREATE TABLE IF NOT EXISTS `eschool`.`report` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `reported_date` DATETIME NOT NULL,
  `description` TEXT NULL,
  `report_reason_id` INT NOT NULL,
  `reported_by` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_report_report_reason1`
    FOREIGN KEY (`report_reason_id`)
    REFERENCES `eschool`.`report_reason` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_report_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_report_user2`
    FOREIGN KEY (`reported_by`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_report_report_reason1_idx` ON `eschool`.`report` (`report_reason_id` ASC);

CREATE INDEX `fk_report_user1_idx` ON `eschool`.`report` (`user_id` ASC);

CREATE INDEX `fk_report_user2_idx` ON `eschool`.`report` (`reported_by` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`unblock_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`unblock_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`unblock_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`block`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`block` ;

CREATE TABLE IF NOT EXISTS `eschool`.`block` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `report_reason_id` INT NOT NULL,
  `blocked_date` DATETIME NULL,
  `unblocked_date` DATETIME NULL,
  `unblock_type_id` INT NOT NULL,
  `parameter` TEXT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_block_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_block_report_reason1`
    FOREIGN KEY (`report_reason_id`)
    REFERENCES `eschool`.`report_reason` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_block_unblock_type1`
    FOREIGN KEY (`unblock_type_id`)
    REFERENCES `eschool`.`unblock_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_block_user1_idx` ON `eschool`.`block` (`user_id` ASC);

CREATE INDEX `fk_block_report_reason1_idx` ON `eschool`.`block` (`report_reason_id` ASC);

CREATE INDEX `fk_block_unblock_type1_idx` ON `eschool`.`block` (`unblock_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`todo_list_category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`todo_list_category` ;

CREATE TABLE IF NOT EXISTS `eschool`.`todo_list_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  `created_user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_todo_list_category_owner_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_todo_list_category_user1`
    FOREIGN KEY (`created_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_todo_list_category_owner_type1_idx` ON `eschool`.`todo_list_category` (`table_id` ASC);

CREATE INDEX `fk_todo_list_category_user1_idx` ON `eschool`.`todo_list_category` (`created_user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`todo_list`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`todo_list` ;

CREATE TABLE IF NOT EXISTS `eschool`.`todo_list` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `created_user_id` INT NOT NULL,
  `todo_list_category_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_todo_list_user1`
    FOREIGN KEY (`created_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_todo_list_todo_list_category1`
    FOREIGN KEY (`todo_list_category_id`)
    REFERENCES `eschool`.`todo_list_category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_todo_list_user1_idx` ON `eschool`.`todo_list` (`created_user_id` ASC);

CREATE INDEX `fk_todo_list_todo_list_category1_idx` ON `eschool`.`todo_list` (`todo_list_category_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`task`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`task` ;

CREATE TABLE IF NOT EXISTS `eschool`.`task` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `start_date` DATETIME NULL,
  `end_date` DATETIME NULL,
  `started_date` DATETIME NULL,
  `ended_date` DATETIME NULL,
  `todo_list_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `created_user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_task_todo_list1`
    FOREIGN KEY (`todo_list_id`)
    REFERENCES `eschool`.`todo_list` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_user2`
    FOREIGN KEY (`created_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_task_todo_list1_idx` ON `eschool`.`task` (`todo_list_id` ASC);

CREATE INDEX `fk_task_user1_idx` ON `eschool`.`task` (`user_id` ASC);

CREATE INDEX `fk_task_user2_idx` ON `eschool`.`task` (`created_user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`file`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`file` ;

CREATE TABLE IF NOT EXISTS `eschool`.`file` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `user_id` INT NOT NULL,
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_file_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_file_owner_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_file_user1_idx` ON `eschool`.`file` (`user_id` ASC);

CREATE INDEX `fk_file_owner_type1_idx` ON `eschool`.`file` (`table_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`post_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`post_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`post_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`post` ;

CREATE TABLE IF NOT EXISTS `eschool`.`post` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` TEXT NOT NULL,
  `created_date` DATETIME NULL,
  `created_user_id` INT NOT NULL,
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  `post_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_post_user1`
    FOREIGN KEY (`created_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_owner_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_post_type1`
    FOREIGN KEY (`post_type_id`)
    REFERENCES `eschool`.`post_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_post_user1_idx` ON `eschool`.`post` (`created_user_id` ASC);

CREATE INDEX `fk_post_owner_type1_idx` ON `eschool`.`post` (`table_id` ASC);

CREATE INDEX `fk_post_post_type1_idx` ON `eschool`.`post` (`post_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`album_item_tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`album_item_tag` ;

CREATE TABLE IF NOT EXISTS `eschool`.`album_item_tag` (
  `album_item_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`album_item_id`, `user_id`),
  CONSTRAINT `fk_album_item_tag_album_item1`
    FOREIGN KEY (`album_item_id`)
    REFERENCES `eschool`.`album_item` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_album_item_tag_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_album_item_tag_user1_idx` ON `eschool`.`album_item_tag` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`poll`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`poll` ;

CREATE TABLE IF NOT EXISTS `eschool`.`poll` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question` TEXT NOT NULL,
  `created_user_id` INT NOT NULL,
  `created_date` DATETIME NULL,
  `has_multi_choise` TINYINT NULL,
  `start_date` DATETIME NULL,
  `end_date` DATETIME NULL,
  `can_add_option` TINYINT NULL,
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_poll_user1`
    FOREIGN KEY (`created_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_poll_content_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_poll_user1_idx` ON `eschool`.`poll` (`created_user_id` ASC);

CREATE INDEX `fk_poll_content_type1_idx` ON `eschool`.`poll` (`table_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`poll_option`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`poll_option` ;

CREATE TABLE IF NOT EXISTS `eschool`.`poll_option` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `poll_id` INT NOT NULL,
  `option` TEXT NOT NULL,
  `created_user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_poll_option_poll1`
    FOREIGN KEY (`poll_id`)
    REFERENCES `eschool`.`poll` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_poll_option_user1`
    FOREIGN KEY (`created_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_poll_option_poll1_idx` ON `eschool`.`poll_option` (`poll_id` ASC);

CREATE INDEX `fk_poll_option_user1_idx` ON `eschool`.`poll_option` (`created_user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`user_poll_option`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`user_poll_option` ;

CREATE TABLE IF NOT EXISTS `eschool`.`user_poll_option` (
  `poll_option_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`poll_option_id`, `user_id`),
  CONSTRAINT `fk_user_poll_option_poll_option1`
    FOREIGN KEY (`poll_option_id`)
    REFERENCES `eschool`.`poll_option` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_poll_option_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_user_poll_option_user1_idx` ON `eschool`.`user_poll_option` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`attendance_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`attendance_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`attendance_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`lesson_calendar`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`lesson_calendar` ;

CREATE TABLE IF NOT EXISTS `eschool`.`lesson_calendar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `teacher_schedule_id` INT NOT NULL,
  `lesson_id` INT NOT NULL,
  `lesson_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_table1_lesson1`
    FOREIGN KEY (`lesson_id`)
    REFERENCES `eschool`.`lesson` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lesson_calendar_teacher_schedule1`
    FOREIGN KEY (`teacher_schedule_id`)
    REFERENCES `eschool`.`teacher_schedule` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_table1_lesson1_idx` ON `eschool`.`lesson_calendar` (`lesson_id` ASC);

CREATE INDEX `fk_lesson_calendar_teacher_schedule1_idx` ON `eschool`.`lesson_calendar` (`teacher_schedule_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`student_attendance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`student_attendance` ;

CREATE TABLE IF NOT EXISTS `eschool`.`student_attendance` (
  `student_user_id` INT NOT NULL,
  `lesson_calendar_id` INT NOT NULL,
  `attendance_type_id` INT NOT NULL,
  PRIMARY KEY (`attendance_type_id`, `lesson_calendar_id`, `student_user_id`),
  CONSTRAINT `fk_student_attendance_user1`
    FOREIGN KEY (`student_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_attendance_lesson_calendar1`
    FOREIGN KEY (`lesson_calendar_id`)
    REFERENCES `eschool`.`lesson_calendar` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_attendance_attendance_type1`
    FOREIGN KEY (`attendance_type_id`)
    REFERENCES `eschool`.`attendance_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_student_attendance_user1_idx` ON `eschool`.`student_attendance` (`student_user_id` ASC);

CREATE INDEX `fk_student_attendance_lesson_calendar1_idx` ON `eschool`.`student_attendance` (`lesson_calendar_id` ASC);

CREATE INDEX `fk_student_attendance_attendance_type1_idx` ON `eschool`.`student_attendance` (`attendance_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`attendance_point_rule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`attendance_point_rule` ;

CREATE TABLE IF NOT EXISTS `eschool`.`attendance_point_rule` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `instructor_user_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `attendance_type_id` INT NOT NULL,
  `point` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_onoo_user1`
    FOREIGN KEY (`instructor_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_onoo_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `eschool`.`class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_attendance_point_rule_attendance_type1`
    FOREIGN KEY (`attendance_type_id`)
    REFERENCES `eschool`.`attendance_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_onoo_user1_idx` ON `eschool`.`attendance_point_rule` (`instructor_user_id` ASC);

CREATE INDEX `fk_onoo_class1_idx` ON `eschool`.`attendance_point_rule` (`class_id` ASC);

CREATE INDEX `fk_attendance_point_rule_attendance_type1_idx` ON `eschool`.`attendance_point_rule` (`attendance_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`examination`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`examination` ;

CREATE TABLE IF NOT EXISTS `eschool`.`examination` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `start_date` DATETIME NULL,
  `end_date` DATETIME NULL,
  `point` INT NULL,
  `schedule_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_examination_teacher_schedule1`
    FOREIGN KEY (`schedule_id`)
    REFERENCES `eschool`.`teacher_schedule` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_examination_teacher_schedule1_idx` ON `eschool`.`examination` (`schedule_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`variant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`variant` ;

CREATE TABLE IF NOT EXISTS `eschool`.`variant` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `examination_id` INT NOT NULL,
  `total_point` FLOAT NOT NULL,
  `max_point` FLOAT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_variant_examination1`
    FOREIGN KEY (`examination_id`)
    REFERENCES `eschool`.`examination` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_variant_examination1_idx` ON `eschool`.`variant` (`examination_id` ASC);

CREATE UNIQUE INDEX `examination_id_UNIQUE` ON `eschool`.`variant` (`examination_id` ASC, `name` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`student_examination`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`student_examination` ;

CREATE TABLE IF NOT EXISTS `eschool`.`student_examination` (
  `examination_id` INT NOT NULL,
  `student_user_id` INT NOT NULL,
  `point` FLOAT NOT NULL,
  `start` DATETIME NULL,
  `end` DATETIME NULL,
  `total_point` VARCHAR(45) NULL,
  `variant_id` INT NULL,
  PRIMARY KEY (`examination_id`, `student_user_id`),
  CONSTRAINT `fk_student_examination_examination1`
    FOREIGN KEY (`examination_id`)
    REFERENCES `eschool`.`examination` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_examination_user1`
    FOREIGN KEY (`student_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_examination_variant1`
    FOREIGN KEY (`variant_id`)
    REFERENCES `eschool`.`variant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_student_examination_examination1_idx` ON `eschool`.`student_examination` (`examination_id` ASC);

CREATE INDEX `fk_student_examination_user1_idx` ON `eschool`.`student_examination` (`student_user_id` ASC);

CREATE INDEX `fk_student_examination_variant1_idx` ON `eschool`.`student_examination` (`variant_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`student_grade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`student_grade` ;

CREATE TABLE IF NOT EXISTS `eschool`.`student_grade` (
  `user_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `grade` INT NOT NULL,
  PRIMARY KEY (`user_id`, `class_id`),
  CONSTRAINT `fk_student_grade_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_grade_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `eschool`.`class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_student_grade_user1_idx` ON `eschool`.`student_grade` (`user_id` ASC);

CREATE INDEX `fk_student_grade_class1_idx` ON `eschool`.`student_grade` (`class_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`vertical_table_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`vertical_table_status` ;

CREATE TABLE IF NOT EXISTS `eschool`.`vertical_table_status` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`vertical_table`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`vertical_table` ;

CREATE TABLE IF NOT EXISTS `eschool`.`vertical_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `instructor_user_id` INT NOT NULL,
  `created_date` DATETIME NULL,
  `checked_user_id` INT NOT NULL,
  `revised_user_id` INT NOT NULL,
  `leader_user_id` INT NOT NULL,
  `vice_director_user_id` INT NOT NULL,
  `vertical_table_status_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_vertical_table_user1`
    FOREIGN KEY (`instructor_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vertical_table_user2`
    FOREIGN KEY (`checked_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vertical_table_user3`
    FOREIGN KEY (`revised_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vertical_table_user4`
    FOREIGN KEY (`leader_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vertical_table_user5`
    FOREIGN KEY (`vice_director_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vertical_table_vertical_table_status1`
    FOREIGN KEY (`vertical_table_status_id`)
    REFERENCES `eschool`.`vertical_table_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_vertical_table_user1_idx` ON `eschool`.`vertical_table` (`instructor_user_id` ASC);

CREATE INDEX `fk_vertical_table_user2_idx` ON `eschool`.`vertical_table` (`checked_user_id` ASC);

CREATE INDEX `fk_vertical_table_user3_idx` ON `eschool`.`vertical_table` (`revised_user_id` ASC);

CREATE INDEX `fk_vertical_table_user4_idx` ON `eschool`.`vertical_table` (`leader_user_id` ASC);

CREATE INDEX `fk_vertical_table_user5_idx` ON `eschool`.`vertical_table` (`vice_director_user_id` ASC);

CREATE INDEX `fk_vertical_table_vertical_table_status1_idx` ON `eschool`.`vertical_table` (`vertical_table_status_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`instructor_credit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`instructor_credit` ;

CREATE TABLE IF NOT EXISTS `eschool`.`instructor_credit` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `summary` INT NULL,
  `norm` INT NULL,
  `odds_40` INT NULL,
  `odds_60` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_instructor_credit_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_instructor_credit_user1_idx` ON `eschool`.`instructor_credit` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`event_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`event_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`event_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`event` ;

CREATE TABLE IF NOT EXISTS `eschool`.`event` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` TEXT NULL,
  `cover_image` VARCHAR(45) NULL,
  `start_date` DATETIME NULL,
  `end_date` DATETIME NULL,
  `address` VARCHAR(45) NULL,
  `address_id` INT NULL,
  `created_user_id` INT NOT NULL,
  `event_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_event_address1`
    FOREIGN KEY (`address_id`)
    REFERENCES `eschool`.`address` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_user1`
    FOREIGN KEY (`created_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_event_type1`
    FOREIGN KEY (`event_type_id`)
    REFERENCES `eschool`.`event_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_event_address1_idx` ON `eschool`.`event` (`address_id` ASC);

CREATE INDEX `fk_event_user1_idx` ON `eschool`.`event` (`created_user_id` ASC);

CREATE INDEX `fk_event_event_type1_idx` ON `eschool`.`event` (`event_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`map`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`map` ;

CREATE TABLE IF NOT EXISTS `eschool`.`map` (
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  `longitude` VARCHAR(45) NOT NULL,
  `latitude` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`table_id`, `table_pk`),
  CONSTRAINT `fk_map_owner_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`event_user_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`event_user_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`event_user_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`event_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`event_user` ;

CREATE TABLE IF NOT EXISTS `eschool`.`event_user` (
  `user_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  `event_user_type_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `event_id`),
  CONSTRAINT `fk_event_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_user_event1`
    FOREIGN KEY (`event_id`)
    REFERENCES `eschool`.`event` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_user_event_user_type1`
    FOREIGN KEY (`event_user_type_id`)
    REFERENCES `eschool`.`event_user_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_event_user_user1_idx` ON `eschool`.`event_user` (`user_id` ASC);

CREATE INDEX `fk_event_user_event1_idx` ON `eschool`.`event_user` (`event_id` ASC);

CREATE INDEX `fk_event_user_event_user_type1_idx` ON `eschool`.`event_user` (`event_user_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`notification` ;

CREATE TABLE IF NOT EXISTS `eschool`.`notification` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sender_user_id` INT NOT NULL,
  `receiver_user_id` INT NOT NULL,
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `created_date` DATETIME NULL,
  `read_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_notification_user1`
    FOREIGN KEY (`receiver_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notification_owner_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notification_user2`
    FOREIGN KEY (`sender_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_notification_user1_idx` ON `eschool`.`notification` (`receiver_user_id` ASC);

CREATE INDEX `fk_notification_owner_type1_idx` ON `eschool`.`notification` (`table_id` ASC);

CREATE INDEX `fk_notification_user2_idx` ON `eschool`.`notification` (`sender_user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`disabled_notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`disabled_notification` ;

CREATE TABLE IF NOT EXISTS `eschool`.`disabled_notification` (
  `user_id` INT NOT NULL,
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  PRIMARY KEY (`table_pk`, `table_id`, `user_id`),
  CONSTRAINT `fk_disabled_notification_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_disabled_notification_owner_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_disabled_notification_user1_idx` ON `eschool`.`disabled_notification` (`user_id` ASC);

CREATE INDEX `fk_disabled_notification_owner_type1_idx` ON `eschool`.`disabled_notification` (`table_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`chat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`chat` ;

CREATE TABLE IF NOT EXISTS `eschool`.`chat` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `color` VARCHAR(45) NULL,
  `emoji` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`chat_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`chat_user` ;

CREATE TABLE IF NOT EXISTS `eschool`.`chat_user` (
  `user_id` INT NOT NULL,
  `group_chat_id` INT NOT NULL,
  `nick_name` VARCHAR(45) NULL,
  `is_archived` TINYINT NULL,
  `left_date` DATETIME NULL,
  `added_date` DATETIME NULL,
  `is_muted` TINYINT NULL,
  `is_admin` TINYINT NULL,
  PRIMARY KEY (`user_id`, `group_chat_id`),
  CONSTRAINT `fk_group_chat_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_group_chat_user_group_chat1`
    FOREIGN KEY (`group_chat_id`)
    REFERENCES `eschool`.`chat` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_group_chat_user_user1_idx` ON `eschool`.`chat_user` (`user_id` ASC);

CREATE INDEX `fk_group_chat_user_group_chat1_idx` ON `eschool`.`chat_user` (`group_chat_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`conversation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`conversation` ;

CREATE TABLE IF NOT EXISTS `eschool`.`conversation` (
  `id` INT NOT NULL,
  `message` TEXT NOT NULL,
  `sent_date` DATETIME NULL,
  `delivered_date` DATETIME NULL,
  `seen_date` DATETIME NULL,
  `sender_user_id` INT NOT NULL,
  `chat_user_user_id` INT NOT NULL,
  `chat_user_group_chat_id` INT NOT NULL,
  `reaction` TEXT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_chat_user1`
    FOREIGN KEY (`sender_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_conversation_chat_user1`
    FOREIGN KEY (`chat_user_user_id` , `chat_user_group_chat_id`)
    REFERENCES `eschool`.`chat_user` (`user_id` , `group_chat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_chat_user1_idx` ON `eschool`.`conversation` (`sender_user_id` ASC);

CREATE INDEX `fk_conversation_chat_user1_idx` ON `eschool`.`conversation` (`chat_user_user_id` ASC, `chat_user_group_chat_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`chat_block`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`chat_block` ;

CREATE TABLE IF NOT EXISTS `eschool`.`chat_block` (
  `blocker_user_id` INT NOT NULL,
  `blocked_user_id` INT NOT NULL,
  CONSTRAINT `fk_chat_block_user1`
    FOREIGN KEY (`blocker_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_chat_block_user2`
    FOREIGN KEY (`blocked_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_chat_block_user1_idx` ON `eschool`.`chat_block` (`blocker_user_id` ASC);

CREATE INDEX `fk_chat_block_user2_idx` ON `eschool`.`chat_block` (`blocked_user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`survey`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`survey` ;

CREATE TABLE IF NOT EXISTS `eschool`.`survey` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` TEXT NULL,
  `created_user_id` INT NOT NULL,
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Survey_user1`
    FOREIGN KEY (`created_user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_survey_owner_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_Survey_user1_idx` ON `eschool`.`survey` (`created_user_id` ASC);

CREATE INDEX `fk_survey_owner_type1_idx` ON `eschool`.`survey` (`table_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`survey_question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`survey_question` ;

CREATE TABLE IF NOT EXISTS `eschool`.`survey_question` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question` TEXT NOT NULL,
  `survey_id` INT NOT NULL,
  `has_multi_choice` TINYINT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_question_Survey1`
    FOREIGN KEY (`survey_id`)
    REFERENCES `eschool`.`survey` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_question_Survey1_idx` ON `eschool`.`survey_question` (`survey_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`survey_question_answer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`survey_question_answer` ;

CREATE TABLE IF NOT EXISTS `eschool`.`survey_question_answer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `answer` VARCHAR(45) NOT NULL,
  `survey_question_id` INT NOT NULL,
  `can_suggest` TINYINT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_survey_question_answer_survey_question1`
    FOREIGN KEY (`survey_question_id`)
    REFERENCES `eschool`.`survey_question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_survey_question_answer_survey_question1_idx` ON `eschool`.`survey_question_answer` (`survey_question_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`survery_question_answer_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`survery_question_answer_user` ;

CREATE TABLE IF NOT EXISTS `eschool`.`survery_question_answer_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `survey_question_answer_id` INT NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_survery_question_answer_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_survery_question_answer_user_survey_question_answer1`
    FOREIGN KEY (`survey_question_answer_id`)
    REFERENCES `eschool`.`survey_question_answer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_survery_question_answer_user_user1_idx` ON `eschool`.`survery_question_answer_user` (`user_id` ASC);

CREATE INDEX `fk_survery_question_answer_user_survey_question_answer1_idx` ON `eschool`.`survery_question_answer_user` (`survey_question_answer_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`sticker_album`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`sticker_album` ;

CREATE TABLE IF NOT EXISTS `eschool`.`sticker_album` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `image_url` VARCHAR(255) NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_sticker_album_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_sticker_album_user1_idx` ON `eschool`.`sticker_album` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`sticker`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`sticker` ;

CREATE TABLE IF NOT EXISTS `eschool`.`sticker` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `sticker_album_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_sticker_sticker_album1`
    FOREIGN KEY (`sticker_album_id`)
    REFERENCES `eschool`.`sticker_album` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_sticker_sticker_album1_idx` ON `eschool`.`sticker` (`sticker_album_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`emoji_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`emoji_group` ;

CREATE TABLE IF NOT EXISTS `eschool`.`emoji_group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `image_url` VARCHAR(45) NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_emoji_group_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_emoji_group_user1_idx` ON `eschool`.`emoji_group` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`emoji`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`emoji` ;

CREATE TABLE IF NOT EXISTS `eschool`.`emoji` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `symbol` VARCHAR(45) NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `emoji_group_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_emoji_emoji_group1`
    FOREIGN KEY (`emoji_group_id`)
    REFERENCES `eschool`.`emoji_group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_emoji_emoji_group1_idx` ON `eschool`.`emoji` (`emoji_group_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`comment` ;

CREATE TABLE IF NOT EXISTS `eschool`.`comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `comment` TEXT NOT NULL,
  `user_id` INT NOT NULL,
  `created_date` DATETIME NOT NULL,
  `reaction` TEXT NULL,
  `parent_id` INT NULL,
  `hidden` TEXT NULL,
  `table_id` INT NOT NULL,
  `table_pk` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `eschool`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_comment1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `eschool`.`comment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_content_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_comment_user1_idx` ON `eschool`.`comment` (`user_id` ASC);

CREATE INDEX `fk_comment_comment1_idx` ON `eschool`.`comment` (`parent_id` ASC);

CREATE INDEX `fk_comment_content_type1_idx` ON `eschool`.`comment` (`table_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`group` ;

CREATE TABLE IF NOT EXISTS `eschool`.`group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `table_pk` INT NOT NULL,
  `params` TEXT NULL,
  `table_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_group_content_type1`
    FOREIGN KEY (`table_id`)
    REFERENCES `eschool`.`table` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `content_id_UNIQUE` ON `eschool`.`group` (`table_pk` ASC);

CREATE INDEX `fk_group_content_type1_idx` ON `eschool`.`group` (`table_id` ASC);

CREATE UNIQUE INDEX `content_type_id_UNIQUE` ON `eschool`.`group` (`table_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`topic`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`topic` ;

CREATE TABLE IF NOT EXISTS `eschool`.`topic` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `parent_id` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_course_topic_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `eschool`.`course` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_topic_course_topic1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `eschool`.`topic` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_course_topic_course1_idx` ON `eschool`.`topic` (`course_id` ASC);

CREATE INDEX `fk_course_topic_course_topic1_idx` ON `eschool`.`topic` (`parent_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`level`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`level` ;

CREATE TABLE IF NOT EXISTS `eschool`.`level` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `point` FLOAT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`answer_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`answer_type` ;

CREATE TABLE IF NOT EXISTS `eschool`.`answer_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eschool`.`question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`question` ;

CREATE TABLE IF NOT EXISTS `eschool`.`question` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question` TEXT NOT NULL,
  `parent_id` INT NULL,
  `answer` TEXT NOT NULL,
  `level_id` INT NOT NULL,
  `topic_id` INT NOT NULL,
  `hint` INT NULL,
  `answer_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_question_question1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `eschool`.`question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_question_level1`
    FOREIGN KEY (`level_id`)
    REFERENCES `eschool`.`level` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_course_topic1`
    FOREIGN KEY (`topic_id`)
    REFERENCES `eschool`.`topic` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_answer_type1`
    FOREIGN KEY (`answer_type_id`)
    REFERENCES `eschool`.`answer_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_question_question1_idx` ON `eschool`.`question` (`parent_id` ASC);

CREATE INDEX `fk_question_question_level1_idx` ON `eschool`.`question` (`level_id` ASC);

CREATE INDEX `fk_question_course_topic1_idx` ON `eschool`.`question` (`topic_id` ASC);

CREATE INDEX `fk_question_answer_type1_idx` ON `eschool`.`question` (`answer_type_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`student_question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`student_question` ;

CREATE TABLE IF NOT EXISTS `eschool`.`student_question` (
  `examination_id` INT NOT NULL,
  `student_user_id` INT NOT NULL,
  `question_id` INT NOT NULL,
  `answer` TEXT NULL,
  `point` FLOAT NULL,
  PRIMARY KEY (`examination_id`, `student_user_id`, `question_id`),
  CONSTRAINT `fk_student_question_student_examination1`
    FOREIGN KEY (`examination_id` , `student_user_id`)
    REFERENCES `eschool`.`student_examination` (`examination_id` , `student_user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_question_question1`
    FOREIGN KEY (`question_id`)
    REFERENCES `eschool`.`question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_student_question_student_examination1_idx` ON `eschool`.`student_question` (`examination_id` ASC, `student_user_id` ASC);

CREATE INDEX `fk_student_question_question1_idx` ON `eschool`.`student_question` (`question_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`variant_question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`variant_question` ;

CREATE TABLE IF NOT EXISTS `eschool`.`variant_question` (
  `variant_id` INT NOT NULL,
  `question_id` INT NOT NULL,
  `question` TEXT NULL,
  `parent_id` INT NULL,
  `answer` TEXT NULL,
  `topic_id` INT NOT NULL,
  `level_id` INT NOT NULL,
  `type_id` INT NULL,
  `point` FLOAT NULL,
  CONSTRAINT `fk_variant_question_variant1`
    FOREIGN KEY (`variant_id`)
    REFERENCES `eschool`.`variant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_variant_question_question1`
    FOREIGN KEY (`question_id`)
    REFERENCES `eschool`.`question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_variant_question_course_topic1`
    FOREIGN KEY (`topic_id`)
    REFERENCES `eschool`.`topic` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_variant_question_question_level1`
    FOREIGN KEY (`level_id`)
    REFERENCES `eschool`.`level` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_variant_question_variant1_idx` ON `eschool`.`variant_question` (`variant_id` ASC);

CREATE INDEX `fk_variant_question_question1_idx` ON `eschool`.`variant_question` (`question_id` ASC);

CREATE INDEX `fk_variant_question_course_topic1_idx` ON `eschool`.`variant_question` (`topic_id` ASC);

CREATE INDEX `fk_variant_question_question_level1_idx` ON `eschool`.`variant_question` (`level_id` ASC);


-- -----------------------------------------------------
-- Table `eschool`.`lesson_topic`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eschool`.`lesson_topic` ;

CREATE TABLE IF NOT EXISTS `eschool`.`lesson_topic` (
  `lesson_id` INT NOT NULL,
  `topic_id` INT NOT NULL,
  CONSTRAINT `fk_lesson_topic_lesson1`
    FOREIGN KEY (`lesson_id`)
    REFERENCES `eschool`.`lesson` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lesson_topic_course_topic1`
    FOREIGN KEY (`topic_id`)
    REFERENCES `eschool`.`topic` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_lesson_topic_lesson1_idx` ON `eschool`.`lesson_topic` (`lesson_id` ASC);

CREATE INDEX `fk_lesson_topic_course_topic1_idx` ON `eschool`.`lesson_topic` (`topic_id` ASC);


-- -----------------------------------------------------
-- Data for table `eschool`.`user_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`user_type` (`id`, `name`) VALUES (1, 'Энгийн хэрэглэгч');
INSERT INTO `eschool`.`user_type` (`id`, `name`) VALUES (2, 'Системийн админ');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (1, 'zolboo', '2dc0bac778c9f6d27139739b54df647f', 'Золбоо', 'Төмөрболд', 'Тэмээт', 1, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (2, 'B140910825', '2dc0bac778c9f6d27139739b54df647f', 'СУГАР', '', '', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (3, 'B140920047 ', '2dc0bac778c9f6d27139739b54df647f', 'МӨНХ-ЭРДЭНЭ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (4, 'B140950419 ', '2dc0bac778c9f6d27139739b54df647f', 'НАРАНГЭРЭЛ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (5, 'B160910004 ', '2dc0bac778c9f6d27139739b54df647f', 'ЭНЭБИШ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (6, 'B160910010 ', '2dc0bac778c9f6d27139739b54df647f', 'ЭЛБЭГ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (7, 'B160910014 ', '2dc0bac778c9f6d27139739b54df647f', 'БАЯНБОЛД ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (8, 'B160910028 ', '2dc0bac778c9f6d27139739b54df647f', 'НОМИН ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (9, 'B160910051 ', '2dc0bac778c9f6d27139739b54df647f', 'ДӨЛБАДРАХ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (10, 'B160910821 ', '2dc0bac778c9f6d27139739b54df647f', 'ЭРДЭНЭБААТАР ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (11, 'B160920012 ', '2dc0bac778c9f6d27139739b54df647f', 'ДАЛАЙХҮҮ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (12, 'B160920027 ', '2dc0bac778c9f6d27139739b54df647f', 'БАЛЖОРДАШИЙМАА ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (13, 'B160930104 ', '2dc0bac778c9f6d27139739b54df647f', 'МЯГМАРНАРАН ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (14, 'B160970005 ', '2dc0bac778c9f6d27139739b54df647f', 'НУРЖАНАТ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (15, 'B170910029 ', '2dc0bac778c9f6d27139739b54df647f', 'СОНИНХҮҮ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (16, 'B170910049 ', '2dc0bac778c9f6d27139739b54df647f', 'ЕСҮЙ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (17, 'B170920024 ', '2dc0bac778c9f6d27139739b54df647f', 'ЗОРИГТБААТАР ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (18, 'B170920033 ', '2dc0bac778c9f6d27139739b54df647f', 'СЕРИГЖАН ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (19, 'B170920053 ', '2dc0bac778c9f6d27139739b54df647f', 'БАТГЭРЭЛ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (20, 'B170930012 ', '2dc0bac778c9f6d27139739b54df647f', 'МӨНХБАЯСГАЛАН ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (21, 'B170930043 ', '2dc0bac778c9f6d27139739b54df647f', 'ЧУЛУУНБАТ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (22, 'B170960015 ', '2dc0bac778c9f6d27139739b54df647f', 'НАМУУНАА ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (23, 'B170960018 ', '2dc0bac778c9f6d27139739b54df647f', 'МӨНГӨНЦЭЦЭГ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (24, 'B170960019 ', '2dc0bac778c9f6d27139739b54df647f', 'ЦЭРЭНБЯМБА ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (25, 'B170960051 ', '2dc0bac778c9f6d27139739b54df647f', 'ТУНГАЛАГ ', '', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (26, 'B170960059 ', '2dc0bac778c9f6d27139739b54df647f', 'ЦЭЭНЭ', '', '', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (27, 'B140910648 ', '2dc0bac778c9f6d27139739b54df647f', 'Э.ОТГОНДЭМБЭРЭЛ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (28, 'B150970018 ', '2dc0bac778c9f6d27139739b54df647f', 'Ш.АМАРБАТ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (29, 'B160930019 ', '2dc0bac778c9f6d27139739b54df647f', 'Л.САРУУЛ-ЭРДЭНЭ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (30, 'B160930036 ', '2dc0bac778c9f6d27139739b54df647f', 'У.ЛУНДИАДОРЖ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (31, 'B160930046 ', '2dc0bac778c9f6d27139739b54df647f', 'У.ЗОЛБОО ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (32, 'B160970004 ', '2dc0bac778c9f6d27139739b54df647f', 'М.ГАНЗОРИГ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (33, 'B160970027 ', '2dc0bac778c9f6d27139739b54df647f', 'М.МӨНХ-ЭРДЭНЭ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (34, 'B160970029 ', '2dc0bac778c9f6d27139739b54df647f', 'Д.МӨНГӨНХҮҮ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (35, 'B160970035 ', '2dc0bac778c9f6d27139739b54df647f', 'Н.УНДРАХБАЯР ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (36, 'B170910018 ', '2dc0bac778c9f6d27139739b54df647f', 'Б.ЦОГТБАЯР ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (37, 'B170920012 ', '2dc0bac778c9f6d27139739b54df647f', 'Н.НАРАНДЭЛГЭР ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (38, 'B170920020 ', '2dc0bac778c9f6d27139739b54df647f', 'М.МӨНХ-ОРГИЛ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (39, 'B170930019 ', '2dc0bac778c9f6d27139739b54df647f', 'З.МӨНХБАЯР ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (40, 'B170930024 ', '2dc0bac778c9f6d27139739b54df647f', 'Б.БАТЗАЯА ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (41, 'B170930030 ', '2dc0bac778c9f6d27139739b54df647f', 'Д.БУЯНЗАЯА ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (42, 'B170930035 ', '2dc0bac778c9f6d27139739b54df647f', 'Г.ЭНХЦЭЦЭГ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (43, 'B170930045 ', '2dc0bac778c9f6d27139739b54df647f', 'Б.СОДНЯМ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (44, 'B170930104 ', '2dc0bac778c9f6d27139739b54df647f', 'Г.ЭРДЭНЭБАТ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (45, 'B170930106 ', '2dc0bac778c9f6d27139739b54df647f', 'Ц.НАРМАНДАХ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (46, 'B170960006 ', '2dc0bac778c9f6d27139739b54df647f', 'А.ЦЭНДСҮРЭН ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (47, 'B170970027 ', '2dc0bac778c9f6d27139739b54df647f', 'Б.ТЭМҮҮЛЭН ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (48, 'B170970062 ', '2dc0bac778c9f6d27139739b54df647f', 'Н.ЭНХБАТ ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (49, 'B170970066 ', '2dc0bac778c9f6d27139739b54df647f', 'Б.ЁНДОНРИНЧИН ', ' ', ' ', 2, NULL);
INSERT INTO `eschool`.`user` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`, `recovery_code`) VALUES (50, 'B170970067 ', '2dc0bac778c9f6d27139739b54df647f', 'Т.БҮТЭНБАЯР', '', ' ', 2, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`address`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`address` (`id`, `name`, `parent_id`) VALUES (1, 'Монгол Улс', NULL);
INSERT INTO `eschool`.`address` (`id`, `name`, `parent_id`) VALUES (2, 'ОХУ', NULL);
INSERT INTO `eschool`.`address` (`id`, `name`, `parent_id`) VALUES (3, 'БНХАУ', NULL);
INSERT INTO `eschool`.`address` (`id`, `name`, `parent_id`) VALUES (4, 'Улаанбаатар хот', 1);
INSERT INTO `eschool`.`address` (`id`, `name`, `parent_id`) VALUES (5, 'Баярзүрх дүүрэг', 4);
INSERT INTO `eschool`.`address` (`id`, `name`, `parent_id`) VALUES (6, '22-р хороо', 5);
INSERT INTO `eschool`.`address` (`id`, `name`, `parent_id`) VALUES (7, 'Дархан-Уул аймаг', 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`school`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`school` (`id`, `name`, `description`, `address`, `parent_id`, `address_id`) VALUES (1, 'ШУТИС', '{\"about\":\"Сургуулийн туахй\"}', NULL, NULL, NULL);
INSERT INTO `eschool`.`school` (`id`, `name`, `description`, `address`, `parent_id`, `address_id`) VALUES (2, 'МХТС', '{\"about\":\"сургуулийн тухай\"}', 'Монгол Улсын Шинжлэх Ухаан Технологийн Их Сургуулийн 6-р байр', 1, 6);
INSERT INTO `eschool`.`school` (`id`, `name`, `description`, `address`, `parent_id`, `address_id`) VALUES (3, 'БУХС', '{\"about\":\"сургуулийн тухай\"}', NULL, 1, NULL);
INSERT INTO `eschool`.`school` (`id`, `name`, `description`, `address`, `parent_id`, `address_id`) VALUES (4, 'ИХИС', '{\"about\":\"сургуулийн тухай\"}', NULL, 1, NULL);
INSERT INTO `eschool`.`school` (`id`, `name`, `description`, `address`, `parent_id`, `address_id`) VALUES (5, 'МУИС', '{\"about\":\"сургуулийн тухай\"}', NULL, NULL, NULL);
INSERT INTO `eschool`.`school` (`id`, `name`, `description`, `address`, `parent_id`, `address_id`) VALUES (6, 'ХТИС', '{\"about\":\"сургуулийн тухай\"}', NULL, 1, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`school_user_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`school_user_type` (`id`, `name`) VALUES (1, 'Оюутан');
INSERT INTO `eschool`.`school_user_type` (`id`, `name`) VALUES (2, 'Багш');
INSERT INTO `eschool`.`school_user_type` (`id`, `name`) VALUES (3, 'Сургалтын албаны ажилтан');
INSERT INTO `eschool`.`school_user_type` (`id`, `name`) VALUES (4, 'Захирал');
INSERT INTO `eschool`.`school_user_type` (`id`, `name`) VALUES (5, 'Нягтлах');
INSERT INTO `eschool`.`school_user_type` (`id`, `name`) VALUES (6, 'Захиралын туслах');
INSERT INTO `eschool`.`school_user_type` (`id`, `name`) VALUES (7, 'Тэнхимийн эрхлэгч');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`division_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`division_type` (`id`, `name`) VALUES (1, 'Салбар');
INSERT INTO `eschool`.`division_type` (`id`, `name`) VALUES (2, 'Тэнхим');
INSERT INTO `eschool`.`division_type` (`id`, `name`) VALUES (3, 'Профессорын баг');
INSERT INTO `eschool`.`division_type` (`id`, `name`) VALUES (4, 'Захиргаа');
INSERT INTO `eschool`.`division_type` (`id`, `name`) VALUES (5, 'Алба');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`division`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`division` (`id`, `name`, `description`, `division_type_id`, `school_id`, `parent_id`) VALUES (1, 'Компьютерийн Ухааны салбар', '{\"about\":\"Танилцуулга\"}', 1, 2, NULL);
INSERT INTO `eschool`.`division` (`id`, `name`, `description`, `division_type_id`, `school_id`, `parent_id`) VALUES (2, 'Мэдээллийн Технологийн салбар', '{\"about\":\"Танилцуулга\"}', 1, 2, NULL);
INSERT INTO `eschool`.`division` (`id`, `name`, `description`, `division_type_id`, `school_id`, `parent_id`) VALUES (3, 'Холбооны салбар', '{\"about\":\"Танилцуулга\"}', 1, 2, NULL);
INSERT INTO `eschool`.`division` (`id`, `name`, `description`, `division_type_id`, `school_id`, `parent_id`) VALUES (4, 'Электрон техникийн салбар', '{\"about\":\"Танилцуулга\"}', 1, 2, NULL);
INSERT INTO `eschool`.`division` (`id`, `name`, `description`, `division_type_id`, `school_id`, `parent_id`) VALUES (5, 'Mэдээллийн сүлжээ, аюулгүй байдлын салбар', '{\"about\":\"Танилцуулга\"}', 1, 2, NULL);
INSERT INTO `eschool`.`division` (`id`, `name`, `description`, `division_type_id`, `school_id`, `parent_id`) VALUES (6, 'Номын сан', '{\"about\":\"Танилцуулга\"}', 1, 2, NULL);
INSERT INTO `eschool`.`division` (`id`, `name`, `description`, `division_type_id`, `school_id`, `parent_id`) VALUES (7, 'Сургалтын алба', '{\"about\":\"Танилцуулга\"}', 1, 2, NULL);
INSERT INTO `eschool`.`division` (`id`, `name`, `description`, `division_type_id`, `school_id`, `parent_id`) VALUES (8, 'Аж ахуй', '{\"about\":\"Танилцуулга\"}', 1, 2, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`profession`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`profession` (`id`, `name`, `division_id`) VALUES (1, 'Мэдээллийн систем', 2);
INSERT INTO `eschool`.`profession` (`id`, `name`, `division_id`) VALUES (2, 'Мэдээллийн технологи', 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`profession_class`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`profession_class` (`id`, `start_date`, `adviser_id`, `profession_id`, `user_id`) VALUES (1, '2018-08-20', 1, 1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`school_user`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (1, 'D.IS10', 2, 1, 2, '2010-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (2, 'B140910825', 2, 2, 1, '2014-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (3, 'B140920047 ', 2, 3, 1, '2014-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (4, 'B140950419 ', 2, 4, 1, '2014-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (5, 'B160910004 ', 2, 5, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (6, 'B160910010 ', 2, 6, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (7, 'B160910014 ', 2, 7, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (8, 'B160910028 ', 2, 8, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (9, 'B160910051 ', 2, 9, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (10, 'B160910821 ', 2, 10, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (11, 'B160920012 ', 2, 11, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (12, 'B160920027 ', 2, 12, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (13, 'B160930104 ', 2, 13, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (14, 'B160970005 ', 2, 14, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (15, 'B170910029 ', 2, 15, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (16, 'B170910049 ', 2, 16, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (17, 'B170920024 ', 2, 17, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (18, 'B170920033 ', 2, 18, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (19, 'B170920053 ', 2, 19, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (20, 'B170930012 ', 2, 20, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (21, 'B170930043 ', 2, 21, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (22, 'B170960015 ', 2, 22, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (23, 'B170960018 ', 2, 23, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (24, 'B170960019 ', 2, 24, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (25, 'B170960051 ', 2, 25, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (26, 'B170960059 ', 2, 26, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (27, 'B140910648 ', 2, 27, 1, '2014-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (28, 'B150970018 ', 2, 28, 1, '2015-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (29, 'B160930019 ', 2, 29, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (30, 'B160930036 ', 2, 30, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (31, 'B160930046 ', 2, 31, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (32, 'B160970004 ', 2, 32, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (33, 'B160970027 ', 2, 33, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (34, 'B160970029 ', 2, 34, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (35, 'B160970035 ', 2, 35, 1, '2016-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (36, 'B170910018 ', 2, 36, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (37, 'B170920012 ', 2, 37, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (38, 'B170920020 ', 2, 38, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (39, 'B170930019 ', 2, 39, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (40, 'B170930024 ', 2, 40, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (41, 'B170930030 ', 2, 41, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (42, 'B170930035 ', 2, 42, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (43, 'B170930045 ', 2, 43, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (44, 'B170930104 ', 2, 44, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (45, 'B170930106 ', 2, 45, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (46, 'B170960006 ', 2, 46, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (47, 'B170970027 ', 2, 47, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (48, 'B170970062 ', 2, 48, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (49, 'B170970066 ', 2, 49, 1, '2017-08-20', NULL, NULL);
INSERT INTO `eschool`.`school_user` (`id`, `code`, `school_id`, `user_id`, `school_user_type_id`, `start_date`, `end_date`, `profession_class_id`) VALUES (50, 'B170970067 ', 2, 50, 1, '2017-08-20', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`user_field`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`user_field` (`id`, `name`) VALUES (1, 'Төрсөн огноо');
INSERT INTO `eschool`.`user_field` (`id`, `name`) VALUES (2, 'Гэр бүлийн байдал');
INSERT INTO `eschool`.`user_field` (`id`, `name`) VALUES (3, 'Утас');
INSERT INTO `eschool`.`user_field` (`id`, `name`) VALUES (4, 'Цахим шуудан');
INSERT INTO `eschool`.`user_field` (`id`, `name`) VALUES (5, 'Хүйс');
INSERT INTO `eschool`.`user_field` (`id`, `name`) VALUES (6, 'Шашин шүтлэг');
INSERT INTO `eschool`.`user_field` (`id`, `name`) VALUES (7, 'Хэл');
INSERT INTO `eschool`.`user_field` (`id`, `name`) VALUES (8, 'Профайл зураг');
INSERT INTO `eschool`.`user_field` (`id`, `name`) VALUES (9, 'Ковер зураг');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`user_detail`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`user_detail` (`id`, `user_id`, `user_field_id`, `value`) VALUES (1, 1, 7, 'Монгол');
INSERT INTO `eschool`.`user_detail` (`id`, `user_id`, `user_field_id`, `value`) VALUES (2, 1, 3, '99993396');
INSERT INTO `eschool`.`user_detail` (`id`, `user_id`, `user_field_id`, `value`) VALUES (3, 1, 5, 'Эрэгтэй');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`class_room`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`class_room` (`id`, `name`, `floor`, `capacity`, `school_id`) VALUES (1, '320', '3', 25, 2);
INSERT INTO `eschool`.`class_room` (`id`, `name`, `floor`, `capacity`, `school_id`) VALUES (2, '324', '3', 25, 2);
INSERT INTO `eschool`.`class_room` (`id`, `name`, `floor`, `capacity`, `school_id`) VALUES (3, '225', '3', 150, 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`relation_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (1, 'Эцэг');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (2, 'Эх');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (3, 'Ах');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (4, 'Эгч');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (5, 'Эрэгтэй дүү');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (6, 'Эмэгтэй дүү');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (7, 'Нөхөр');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (8, 'Эхнэр');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (9, 'Хүү');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (10, 'Охин');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (11, 'Найз');
INSERT INTO `eschool`.`relation_type` (`id`, `name`) VALUES (12, 'Танил');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`course_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`course_type` (`id`, `name`) VALUES (1, 'Заавал');
INSERT INTO `eschool`.`course_type` (`id`, `name`) VALUES (2, 'Заавал сонгон');
INSERT INTO `eschool`.`course_type` (`id`, `name`) VALUES (3, 'Сонгон');
INSERT INTO `eschool`.`course_type` (`id`, `name`) VALUES (4, 'Бусад');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`course`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`course` (`id`, `name`, `code`, `credit`, `division_id`, `course_type_id`, `description`, `is_diploma`) VALUES (1, 'Вэб зохиомж', 'F.IT202', 3, 2, 1, 'Энэ хичээлээр HTML, HTML 5, CSS, CSS 3, JavaScript, jQuery -н талаар ерөнхийд нь үзнэ. Хичээлийн зорилго нь веб хуудас хийх анхан шатны мэдлэгийг олж авах бөгөөд хичээлийн улирлын төгсгөлд статик веб хуудас хийж сурсан байна. Мөн динамик веб хуудас хийх үндэс болно.', 0);
INSERT INTO `eschool`.`course` (`id`, `name`, `code`, `credit`, `division_id`, `course_type_id`, `description`, `is_diploma`) VALUES (2, 'Мэдээллийн системийн хөгжүүлэлт', 'F.IT331', 3, 2, 1, NULL, 0);
INSERT INTO `eschool`.`course` (`id`, `name`, `code`, `credit`, `division_id`, `course_type_id`, `description`, `is_diploma`) VALUES (3, 'Мэдээллийн системийн төсөл I', 'F.IT335', 3, 2, 1, NULL, 0);
INSERT INTO `eschool`.`course` (`id`, `name`, `code`, `credit`, `division_id`, `course_type_id`, `description`, `is_diploma`) VALUES (4, 'Үйлдвэрлэлийн дадлага', 'J.IS360', 1, 2, 1, NULL, 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`season`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`season` (`id`, `name`) VALUES (1, 'Намар');
INSERT INTO `eschool`.`season` (`id`, `name`) VALUES (2, 'Өвөл');
INSERT INTO `eschool`.`season` (`id`, `name`) VALUES (3, 'Хавар');
INSERT INTO `eschool`.`season` (`id`, `name`) VALUES (4, 'Зун');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`class`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`class` (`id`, `course_id`, `year`, `season_id`) VALUES (1, 1, 2018, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`class_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`class_type` (`id`, `name`) VALUES (1, 'Лекц');
INSERT INTO `eschool`.`class_type` (`id`, `name`) VALUES (2, 'Семинар');
INSERT INTO `eschool`.`class_type` (`id`, `name`) VALUES (3, 'Лаборатори');
INSERT INTO `eschool`.`class_type` (`id`, `name`) VALUES (4, 'Бие даалт');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`teacher_schedule`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`teacher_schedule` (`id`, `week_day`, `par`, `class_id`, `class_type_id`, `instructor_user_id`, `class_room_id`) VALUES (1, 1, 6, 1, 1, 1, 3);
INSERT INTO `eschool`.`teacher_schedule` (`id`, `week_day`, `par`, `class_id`, `class_type_id`, `instructor_user_id`, `class_room_id`) VALUES (2, 1, 7, 1, 3, 1, 2);
INSERT INTO `eschool`.`teacher_schedule` (`id`, `week_day`, `par`, `class_id`, `class_type_id`, `instructor_user_id`, `class_room_id`) VALUES (3, 2, 1, 1, 3, 1, 2);
INSERT INTO `eschool`.`teacher_schedule` (`id`, `week_day`, `par`, `class_id`, `class_type_id`, `instructor_user_id`, `class_room_id`) VALUES (4, 2, 2, 1, 3, 1, 2);
INSERT INTO `eschool`.`teacher_schedule` (`id`, `week_day`, `par`, `class_id`, `class_type_id`, `instructor_user_id`, `class_room_id`) VALUES (5, 2, 3, 1, 3, 1, 2);
INSERT INTO `eschool`.`teacher_schedule` (`id`, `week_day`, `par`, `class_id`, `class_type_id`, `instructor_user_id`, `class_room_id`) VALUES (6, 2, 5, 1, 3, 1, 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`par`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`par` (`school_id`, `id`, `start_time`, `end_time`) VALUES (2, 1, '2018-01-01 08:00', '2018-01-01 09:30');
INSERT INTO `eschool`.`par` (`school_id`, `id`, `start_time`, `end_time`) VALUES (2, 2, '2018-01-01 09:40', '2018-01-01 11:10');
INSERT INTO `eschool`.`par` (`school_id`, `id`, `start_time`, `end_time`) VALUES (2, 3, '2018-01-01 11:20', '2018-01-01 12:50');
INSERT INTO `eschool`.`par` (`school_id`, `id`, `start_time`, `end_time`) VALUES (2, 4, '2018-01-01 13:20', '2018-01-01 14:50');
INSERT INTO `eschool`.`par` (`school_id`, `id`, `start_time`, `end_time`) VALUES (2, 5, '2018-01-01 15:00', '2018-01-01 16:30');
INSERT INTO `eschool`.`par` (`school_id`, `id`, `start_time`, `end_time`) VALUES (2, 6, '2018-01-01 16:40', '2018-01-01 18:10');
INSERT INTO `eschool`.`par` (`school_id`, `id`, `start_time`, `end_time`) VALUES (2, 7, '2018-01-01 18:20', '2018-01-01 19:50');
INSERT INTO `eschool`.`par` (`school_id`, `id`, `start_time`, `end_time`) VALUES (2, 8, '2018-01-01 20:00', '2018-01-01 21:30');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`student_schedule`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 2);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 3);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 4);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 5);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 6);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 7);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 8);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 9);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 10);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 11);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 12);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 13);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 14);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 15);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 16);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 17);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 18);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 19);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 20);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 21);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 22);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 23);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 24);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 25);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (2, 26);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 27);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 28);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 29);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 30);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 31);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 32);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 33);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 34);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 35);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 36);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 37);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 38);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 39);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 40);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 41);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 42);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 43);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 44);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 45);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 46);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 47);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 48);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 49);
INSERT INTO `eschool`.`student_schedule` (`teacher_schedule_id`, `student_user_id`) VALUES (3, 50);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`lesson`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (1, 1, 1, 'Интернэт болон Веб хуудасны тухай ерөнхий ойлголт', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (2, 1, 1, 'HTML үндсэн тагууд', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (3, 1, 1, 'HTML маягт ба фрем', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (4, 1, 1, 'CSS', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (5, 1, 1, 'JavaScript үндсэн ойлголт', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (6, 1, 1, 'JavaScript функц', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (7, 1, 1, 'Browser BOM', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (8, 1, 1, 'JavaScript хэрэглээ', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (9, 1, 1, 'JavaScript DOM', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (10, 1, 1, 'Респонсив вэб', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (11, 1, 1, 'CSS 3 хөдөлгөөн', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (12, 1, 1, 'JavaScript хүсэлт', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (13, 1, 1, 'CSS 3', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (14, 1, 1, 'jQuery', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (15, 1, 1, 'AngularJS', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (16, 1, 1, 'Дүгнэлт', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (17, 3, 1, 'Hello World хуудас', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (18, 3, 1, 'HTML вэб хуудас', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (19, 3, 1, 'Frame & Form', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (20, 3, 1, 'HTML, CSS вэб хуудас', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (21, 3, 1, 'JavaScript Event', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (22, 3, 1, 'Browser', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (23, 3, 1, 'Image Slider', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (24, 3, 1, 'Бөмбөлөг буудагч тоглоом', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (25, 3, 1, 'Versus', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (26, 3, 1, 'Респонсив вэб', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (27, 3, 1, '“Банхарнаторын аялал” анимешин', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (28, 3, 1, 'Ajax & JSON', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (29, 3, 1, 'Transition & gradient & border & background', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (30, 3, 1, 'HTML, CSS3, JavaScript ашиглан 64 буудалт даам дүрслэх', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (31, 3, 1, 'JavaScript ашиглан дааманд үйлдэл хийх', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (32, 4, 1, 'Статик вэб хуудас', NULL);
INSERT INTO `eschool`.`lesson` (`id`, `class_type_id`, `class_id`, `subject`, `description`) VALUES (33, 4, 1, 'Хөдөлгөөнт вэб хуудас', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`course_dependency_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`course_dependency_type` (`id`, `name`) VALUES (1, 'Өмнөх холбоо');
INSERT INTO `eschool`.`course_dependency_type` (`id`, `name`) VALUES (2, 'Хамтрах холбоо');
INSERT INTO `eschool`.`course_dependency_type` (`id`, `name`) VALUES (3, 'Сонгох өмнөх холбоо');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`course_class_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`course_class_type` (`id`, `course_id`, `class_type_id`, `time`) VALUES (1, 1, 1, 2);
INSERT INTO `eschool`.`course_class_type` (`id`, `course_id`, `class_type_id`, `time`) VALUES (2, 2, 2, 0);
INSERT INTO `eschool`.`course_class_type` (`id`, `course_id`, `class_type_id`, `time`) VALUES (3, 3, 3, 2);
INSERT INTO `eschool`.`course_class_type` (`id`, `course_id`, `class_type_id`, `time`) VALUES (4, 4, 4, 5);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`course_season`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`course_season` (`course_id`, `season_id`) VALUES (1, 1);
INSERT INTO `eschool`.`course_season` (`course_id`, `season_id`) VALUES (2, 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`topic`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (1, 1, 'Интернэт болон Веб хуудасны тухай ерөнхий ойлголт', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (2, 1, 'HTML үндсэн тагууд', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (3, 1, 'HTML маягт ба фрем', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (4, 1, 'CSS', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (5, 1, 'JavaScript үндсэн ойлголт', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (6, 1, 'JavaScript функц', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (7, 1, 'Browser BOM', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (8, 1, 'JavaScript хэрэглээ', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (9, 1, 'JavaScript DOM', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (10, 1, 'Респонсив вэб', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (11, 1, 'CSS 3 хөдөлгөөн', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (12, 1, 'JavaScript хүсэлт', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (13, 1, 'CSS 3', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (14, 1, 'jQuery', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (15, 1, 'AngularJS', NULL);
INSERT INTO `eschool`.`topic` (`id`, `course_id`, `name`, `parent_id`) VALUES (16, 1, 'Дүгнэлт', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`level`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`level` (`id`, `name`, `point`) VALUES (1, 'Энгийн', 1);
INSERT INTO `eschool`.`level` (`id`, `name`, `point`) VALUES (2, 'Дунд', 2);
INSERT INTO `eschool`.`level` (`id`, `name`, `point`) VALUES (3, 'Ахисан', 4);
INSERT INTO `eschool`.`level` (`id`, `name`, `point`) VALUES (4, 'Хүнд', 5);

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`answer_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`answer_type` (`id`, `name`) VALUES (1, 'Нэг сонголттой');
INSERT INTO `eschool`.`answer_type` (`id`, `name`) VALUES (2, 'Олон сонголттой');
INSERT INTO `eschool`.`answer_type` (`id`, `name`) VALUES (3, 'Үнэн худал');
INSERT INTO `eschool`.`answer_type` (`id`, `name`) VALUES (4, 'Бөглөдөг');
INSERT INTO `eschool`.`answer_type` (`id`, `name`) VALUES (5, 'Харгалзуулдаг');
INSERT INTO `eschool`.`answer_type` (`id`, `name`) VALUES (6, 'Бичвэр');
INSERT INTO `eschool`.`answer_type` (`id`, `name`) VALUES (7, 'Багц асуулт');

COMMIT;


-- -----------------------------------------------------
-- Data for table `eschool`.`lesson_topic`
-- -----------------------------------------------------
START TRANSACTION;
USE `eschool`;
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (1, 1);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (2, 2);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (3, 3);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (4, 4);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (5, 5);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (6, 6);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (7, 7);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (8, 8);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (9, 9);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (10, 10);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (11, 11);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (12, 12);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (13, 13);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (14, 14);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (15, 15);
INSERT INTO `eschool`.`lesson_topic` (`lesson_id`, `topic_id`) VALUES (16, 16);

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

