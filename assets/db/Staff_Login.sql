-- Creating staff profile table
CREATE TABLE IF NOT EXISTS `ICT1004_Project`.`staff_details` (
  `staffID` VARCHAR(10) NOT NULL,
  `fname` VARCHAR(45) NULL,
  `lname` VARCHAR(45) NOT NULL,
  `role` VARCHAR(45) NOT NULL,
  `mobile` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_date` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`staffID`),
  UNIQUE INDEX `adminID_UNIQUE` (`staffID` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- Inserting default admin account
INSERT INTO `ICT1004_Project`.`staff_details` (`staffID`,`fname`,`lname`,`role`,`mobile`,`email`,`password`,`created_date`) VALUES ('BossMan000','Cafe','Owner','Manager','92879988','cafe.owner@cafe.com','$2y$10$svCV6CxBLYtgJXKe3TYu/.F6HF/vi3Er7R9GoNhIBcafrgGL2DSV6','12 November 2021');
INSERT INTO `ICT1004_Project`.`staff_details` (`staffID`,`fname`,`lname`,`role`,`mobile`,`email`,`password`,`created_date`) VALUES ('BossMan002','Cafe','Owner2','Manager','98237772','cafe.owner2@cafe.com','$2y$10$svCV6CxBLYtgJXKe3TYu/.F6HF/vi3Er7R9GoNhIBcafrgGL2DSV6','12 November 2021');


-- Creating staff login log table
CREATE TABLE IF NOT EXISTS `ICT1004_Project`.`staff_login_log` (
  `login_id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` VARCHAR(45) NOT NULL COMMENT 'Foreign Key',
  `timestamp` DATETIME NOT NULL,
  `action` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`login_id`),
  UNIQUE INDEX `loginID_UNIQUE` (`login_id` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
