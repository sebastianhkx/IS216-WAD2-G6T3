
use `schedule`;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
CREATE DATABASE IF NOT EXISTS `schedule` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `schedule`;
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `date` varchar(32) NOT NULL,
  `time` varchar(32) NOT NULL,
  `location` varchar(32) NOT NULL,
  `description` varchar(32) NOT NULL,
  /*`importance` varchar(32) NOT NULL,
  `complete` varchar(32) NOT NULL,*/
  PRIMARY KEY (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `schedule` (`date`, `time`,`location`,`description`) VALUES
('09/12/2020','11:01 pm','Bugis','Meeting with mary','','Completed'),
('10/21/2020','09:25 am','Orchard','Company Event','Importance',''),
('11/11/2020','01:44 pm','Jurong East','Meeting with mary','','')