drop database if exists scheduler;

create database scheduler;

use scheduler;

CREATE TABLE if not exists `goal_table` (
  `goal_id` integer auto_increment primary key,
  `user_id` integer NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
)ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

CREATE TABLE if not exists `event_list` (
  `event_id` integer auto_increment primary key,
  `user_id` integer NOT NULL,
  `date` date NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `location` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `completed` boolean NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

CREATE TABLE if not exists `task_list` (
  `task_id` integer auto_increment primary key,
  `user_id` integer NOT NULL,
  `date` date NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `repeatable` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE if not exists `unavailable_list` (
  `unavailable_id` integer auto_increment primary key,
  `user_id` integer NOT NULL,
  `date` date NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `repeatable` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
