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

CREATE TABLE `Medicine`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `supplier` mediumint(8) unsigned NOT NULL,
    `name` varchar(255) NOT NULL,
    `cost` int(10) unsigned NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`supplier`) REFERENCES `Supplier` (`id`),
    UNIQUE (`name`, `supplier`, `cost`),
    UNIQUE (`name`),
    CHECK (`cost` >= 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Inventory`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `medicine_id` mediumint(8) unsigned NOT NULL,
    `quantity_left` int(10) unsigned NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`medicine_id`) REFERENCES Medicine (`id`),
    UNIQUE (`medicine_id`, `quantity_left`),
    CHECK (`quantity_left` >= 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Patient`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `phone` int(11) unsigned,
    `address` varchar(255),

    PRIMARY KEY (`id`),
    UNIQUE (`name`, `phone`, `address`),
    CHECK (`phone` > 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Patient_Contact`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `phone` int(11) unsigned NOT NULL,
    `patient_id` mediumint(8) unsigned NOT NULL,
    `address` varchar(255) NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`patient_id`) REFERENCES `Patient` (`id`),
    UNIQUE (`name`, `phone`, `address` , `patient_id`),
    CHECK (`phone` > 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Employee`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `salary` mediumint(8) NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Sales`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `cost` int(11) unsigned NOT NULL,
    `employee_id` mediumint(8) unsigned NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`employee_id`) REFERENCES `Employee` (`id`),
    CHECK (`cost` >= 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Medicine_Sold`
(
	`id` mediumint(8) unsigned NOT NULL auto_increment,
    `quantity` int(10) unsigned NOT NULL,
    `medicine_id` mediumint(8) unsigned NOT NULL,
    `sale_id` mediumint(8) unsigned NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`medicine_id`) REFERENCES `Medicine` (`id`),
    FOREIGN KEY (`sale_id`) REFERENCES `Sales` (`id`),
    UNIQUE (`sale_id`, `medicine_id`),
    UNIQUE (`medicine_id`, `quantity`),
    UNIQUE (`sale_id`, `medicine_id`, `quantity`),
    CHECK (`quantity` >= 0)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Employee_Dependent`
(
    `id` mediumint(8) unsigned NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `relation` varchar(255) NOT NULL,
    `employee_id` mediumint(8) unsigned NOT NULL,
    
    PRIMARY KEY (`id`),
    FOREIGN KEY (`employee_id`) REFERENCES `Employee` (`id`),
    UNIQUE (`name`, `relation`, `employee_id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Pharmacist`
(
    `employee_id` mediumint(8) unsigned NOT NULL,
    `designation` char(255) NOT NULL,
    `department` cahr(255) NOT NULL,
    
    FOREIGN KEY (`employee_id`) REFERENCES `Employee` (`id`),
    UNIQUE (`employee_id`, `department`),
    UNIQUE (`employee_id`, `designation`),
    UNIQUE (`employee_id`, `designation`, `department`)
);
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Doctor`
(
    `employee_id` mediumint(8) unsigned NOT NULL,
    `designation` char(255) NOT NULL,
    `department` cahr(255) NOT NULL,
    
    FOREIGN KEY (`employee_id`) REFERENCES `Employee` (`id`),
    UNIQUE (`employee_id`, `department`),
    UNIQUE (`employee_id`, `designation`),
    UNIQUE (`employee_id`, `designation`, `department`)
);
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Sedative`
(
    `medicine_id` mediumint(8) NOT NULL,
    `type` char(255) NOT NULL,

    FOREIGN KEY (`medicine_id`) REFERENCES `Medicine` (`id`),
    UNIQUE (`medicine_id`, `type`)
);
ENGINE = InnpDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Ayurvedic`
(
    `medicine_id` mediumint(8) NOT NULL,
    `type` char(255) NOT NULL,

    FOREIGN KEY (`medicine_id`) REFERENCES `Medicine` (`id`),
    UNIQUE (`medicine_id`, `type`)
);
ENGINE = InnpDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Homeopathic`
(
    `medicine_id` mediumint(8) NOT NULL,
    `type` char(255) NOT NULL,

    FOREIGN KEY (`medicine_id`) REFERENCES `Medicine` (`id`),
    UNIQUE (`medicine_id`, `type`)
);
ENGINE = InnpDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;

CREATE TABLE `Miscellaneous`
(
    `medicine_id` mediumint(8) NOT NULL,
    `type` char(255) NOT NULL,

    FOREIGN KEY (`medicine_id`) REFERENCES `Medicine` (`id`),
    UNIQUE (`medicine_id`, `type`)
);
ENGINE = InnpDB
DEFAULT CHARACTER SET = utf8
AUTO_INCREMENT = 1;
