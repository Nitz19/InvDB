-- Create Database
CREATE DATABASE IF NOT EXISTS `InvDb`;

-- Use the Database
USE `InvDb`;

-- Create User Table
CREATE TABLE `user` (
    `userID` int(9) NOT NULL auto_increment,
    `fullname` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL,
    `dateCreated` timestamp NOT NULL DEFAULT current_timestamp,
    `dateDeleted` date DEFAULT NULL,
    PRIMARY KEY (`userID`)
) ENGINE=InnoDB;

-- Create Brand Table
CREATE TABLE `brand` (
    `brandID` int(11) NOT NULL auto_increment,
    `brandName` varchar(100) NOT NULL,
    `brandDesc` text NOT NULL,
    `dateCreated` timestamp NOT NULL DEFAULT current_timestamp,
    `dateDeleted` date DEFAULT NULL,
    PRIMARY KEY (`brandID`)
) ENGINE=InnoDB;

-- Create Category Table
CREATE TABLE `category` (
    `catID` int(11) NOT NULL auto_increment,
    `catName` varchar(100) NOT NULL,
    `catDesc` text NOT NULL,
    `dateCreated` timestamp NOT NULL DEFAULT current_timestamp,
    `dateDeleted` date DEFAULT NULL,
    PRIMARY KEY (`catID`)
) ENGINE=InnoDB;

-- Create Supplier Table
CREATE TABLE `supplier` (
    `supplierID` int(11) NOT NULL auto_increment,
    `supplierName` varchar(100) NOT NULL,
    `supplierDesc` text NOT NULL,
    `dateCreated` timestamp NOT NULL DEFAULT current_timestamp,
    `dateDeleted` date DEFAULT NULL,
    PRIMARY KEY (`supplierID`)
) ENGINE=InnoDB;

-- Create Product Table (LAST)
CREATE TABLE `product` (
    `prodID` int(11) NOT NULL auto_increment,
    `prodName` varchar(100) NOT NULL,
    `prodDesc` text NOT NULL,
    `prodQty` int(5) NOT NULL,
    `prodPrice` decimal(10,2) NOT NULL,
    `brandID` int(11) NOT NULL,
    `catID` int(11) NOT NULL,
    `supplierID` int(11) NOT NULL,
    `userID` int(11) NOT NULL,
    `dateCreated` timestamp NOT NULL DEFAULT current_timestamp,
    `dateDeleted` date DEFAULT NULL,
    PRIMARY KEY (`prodID`),
    FOREIGN KEY (`brandID`) REFERENCES brand(`brandID`) ON DELETE CASCADE,
    FOREIGN KEY (`catID`) REFERENCES category(`catID`) ON DELETE CASCADE,
    FOREIGN KEY (`supplierID`) REFERENCES supplier(`supplierID`) ON DELETE CASCADE,
    FOREIGN KEY (`userID`) REFERENCES user(`userID`) ON DELETE CASCADE
) ENGINE=InnoDB;
