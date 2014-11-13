DROP DATABASE IF EXISTS `db`;

CREATE DATABASE `db`;
USE `db`;

CREATE TABLE `Supplier`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `phone` int(11) NOT NULL,
    `address` varchar(255) NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE (`name`, `phone`),
    UNIQUE (`name`, `address`),
    UNIQUE (`name`, `phone`, `address`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Supplier` ( `name` , `phone` , `address` ) VALUES ( "Supplier 1" , "123456789" , "@ IIIT.AC.IN" );

CREATE TABLE `Medicine`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `supplier_id` mediumint(8) unsigned NOT NULL,
    `name` varchar(255) NOT NULL,
    `cost` int(10) unsigned NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`supplier_id`) REFERENCES `Supplier` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE (`name`, `supplier_id`, `cost`),
    UNIQUE (`name`),
    CHECK (`cost` >= 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Medicine` ( `supplier_id` , `name` , `cost` ) VALUES ( 1 , "Medicine 1" , 22112 );
INSERT INTO `Medicine` ( `supplier_id` , `name` , `cost` ) VALUES ( 1 , "Medicine 2" , 21321 );

CREATE TABLE `Inventory`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `medicine_id` mediumint(8) unsigned NOT NULL,
    `quantity_left` int(10) unsigned NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`medicine_id`) REFERENCES `Medicine` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE (`medicine_id`, `quantity_left`),
    CHECK (`quantity_left` >= 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Inventory` ( `medicine_id` , `quantity_left` ) VALUES ( 1 , 13131 ); 

CREATE TABLE `Patient`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `phone` int(11) unsigned,
    `address` varchar(255),

    PRIMARY KEY (`id`),
    UNIQUE (`name`, `phone`, `address`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Patient` ( `name` , `phone` , `address` ) VALUES ( "Patient 0" , 131313131 , "@ IIIT.AC.IN");
INSERT INTO `Patient` ( `name` , `phone` , `address` ) VALUES ( "Patient 1" , 131314111 , "@ IIIT.AC.IN");

CREATE TABLE `Patient_Contact`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `phone` int(11) unsigned NOT NULL,
    `patient_id` mediumint(8) unsigned NOT NULL,
    `address` varchar(255) NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`patient_id`) REFERENCES `Patient` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE (`name`, `phone`, `address` , `patient_id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Patient_Contact` ( `name` , `phone` , `patient_id` , `address` ) VALUES ( "Contact 1" , 131241311 , 1 , "@ IIIT.AC.IN");

CREATE TABLE `Users`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `user_id` varchar(255) NOT NULL,
    `password_hash` varchar(255) NOT NULL,
    `password_salt` varchar(255) NOT NULL,
    
    PRIMARY KEY (`id`),
    UNIQUE (`user_id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Users` ( `user_id` , `password_hash` , `password_salt` ) VALUES ( "admin_user" , "cW6loT9bBdRF+JxboyTVuonhokDxJGcC" , "WcxbQOOOoKTX+yl6IqDuRNlv2Wr8DPPE");
INSERT INTO `Users` ( `user_id` , `password_hash` , `password_salt` ) VALUES ( "normal_user" , "cW6loT9bBdRF+JxboyTVuonhokDxJGcC" , "WcxbQOOOoKTX+yl6IqDuRNlv2Wr8DPPE");

CREATE TABLE `Employee`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `salary` mediumint(8) NOT NULL,
	`user_id` mediumint(8) unsigned NOT NULL,

    PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Employee` ( `name` , `salary` , `user_id` ) VALUES ("Admin User" , 1000 , 1);
INSERT INTO `Employee` ( `name` , `salary` , `user_id` ) VALUES ("Normal User" , 1000 , 2);

CREATE TABLE `Sales`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `cost` int(11) unsigned NOT NULL,
    `employee_id` mediumint(8) unsigned NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`employee_id`) REFERENCES `Employee` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
    CHECK (`cost` >= 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Sales` ( `cost` , `employee_id` ) VALUES ( 1000 , 2 );
INSERT INTO `Sales` ( `cost` , `employee_id` ) VALUES ( 100 , 2 );

CREATE TABLE `Medicine_Sold`
(
	`id` mediumint(8) unsigned NOT NULL auto_increment,
    `quantity` int(10) unsigned NOT NULL,
    `medicine_id` mediumint(8) unsigned NOT NULL,
    `sale_id` mediumint(8) unsigned NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`medicine_id`) REFERENCES `Medicine` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`sale_id`) REFERENCES `Sales` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE (`sale_id`, `medicine_id`),
    CHECK (`quantity` >= 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Medicine_Sold` ( `quantity` , `medicine_id` , `sale_id` ) VALUES ( 100 , 1 , 1 );
INSERT INTO `Medicine_Sold` ( `quantity` , `medicine_id` , `sale_id` ) VALUES ( 100 , 2 , 1 );
INSERT INTO `Medicine_Sold` ( `quantity` , `medicine_id` , `sale_id` ) VALUES ( 100 , 1 , 2 );
INSERT INTO `Medicine_Sold` ( `quantity` , `medicine_id` , `sale_id` ) VALUES ( 100 , 2 , 2 );

CREATE TABLE `Employee_Dependent`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `relation` varchar(255) NOT NULL,
    `employee_id` mediumint(8) unsigned NOT NULL,
    
    PRIMARY KEY (`id`),
    FOREIGN KEY (`employee_id`) REFERENCES `Employee` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE (`name`, `relation`, `employee_id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Employee_Dependent` ( `name` , `relation` , `employee_id` ) VALUES ( "Dependent 1" , "Relation" , 2);
INSERT INTO `Employee_Dependent` ( `name` , `relation` , `employee_id` ) VALUES ( "Dependent 2" , "Relation" , 2);

CREATE TABLE `Admins` 
(
	`id` mediumint(8) unsigned NOT NULL auto_increment,
	`user_id` mediumint(8) unsigned NOT NULL,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

INSERT INTO `Admins` ( `user_id` ) VALUES ( 1 );
