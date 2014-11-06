CREATE DATABASE db;
USE db;

CREATE TABLE Medicine
(
    ID varchar(255) NOT NULL,
    Supplier varchar(255) NOT NULL,
    Name, char(255) NOT NULL,
    Cost, int(10) NOT NULL,
    
    PRIMARY KEY (ID),
    FOREIGN KEY (Supplier) REFERNECES Supplier (ID),
    UNIQUE (Name, Supplier, Cost)
);

CREATE TABLE Inventory
(
    ID, NOT NULL,
    Name, NOT NULL,
    Quantity_Left, int(10), NOT NULL,

    PRIMARY KEY (ID),
    FOREIGN KEY (Name) REFERNECES Medicine (Name),
    UNIQUE (Name, Quantity_Left)
);

CREATE TABLE Patient
(
    ID varchar(255) NOT NULL,
    Name char(255) NOT NULL,
    Phone int(11),
    Address varchar(500),

    PRIMARY KEY (ID),
    UNIQUE (Name, Phone, Address)
);

CREATE TABLE Patient_Contact
(
    ID varchar(255) NOT NULL,
    Name char(255) NOT NULL,
    Phone int(11) NOT NULL,
    Patient_ID varchar(255) NOT NULL,

    PRIMARY KEY (ID)
    FOREIGN KEY (Patient_ID) REFERNECES Patient (ID)

);

CREATE TABLE Supplier
(
    ID varchar(255) NOT NULL,
    Name char(255) NOT NULL,
    Phone int(11) NOT NULL,
    Address varchar(500) NOT NULL,

    PRIMARY KEY (ID),
    UNIQUE (Name, Phone),
    UNIQUE (Name, Address),
    UNIQUE (Name, Phone, Address)
);

CREATE TABLE Sales
(
    ID varchar(255) NOT NULL,
    Cost int(11) NOT NULL,
    Employee_ID varchar(255),

    PRIMARY KEY (ID),
    FOREIGN KEY (Employee_ID) REFERNECES Employee(ID)
);

CREATE TABLE Medicine_Sold
(
    Quantity int(10) NOT NULL,
    Medicine_ID varchar(255) NOT NULL,
    Sale_ID varchar(255) NOT NULL,

    FOREIGN KEY (Medicine_ID) REFERNECES Medicine (ID),
    FOREIGN KEY (Sale_ID) REFERNECES Sales (ID),
    UNIQUE (Sale_ID, Medicine_ID),
    UNIQUE (Medicine_ID, Quantity),
    UNIQUE (Sale_ID, Medicine_ID, Sale_ID)
);

CREATE TABLE Employee
(
    ID varchar(255) NOT NULL,
    Name char(255) NOT NULL,
    Salary int(8) NOT NULL,

    PRIMARY KEY (ID),
);

CREATE TABLE Employee_Dependent
(
    ID varchar(255) NOT NULL,
    Name char(255) NOT NULL,
    Relation char(255) NOT NULL,
    Employee_ID varchar(255), NOT NULL,
    
    PRIMARY KEY (ID),
    FOREIGN KEY (Employee_ID) REFERNECES Employee (ID),
    UNIQUE (Name, Relation, Employee_ID)
);













































