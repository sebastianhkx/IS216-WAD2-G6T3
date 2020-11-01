drop database if exists scheduler;

create database scheduler;

use scheduler;

CREATE TABLE if not exists `event_list` (
  `event_id` integer NOT NULL,
  `user_id` integer NOT NULL,
  `date` date NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `location` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `completed` boolean NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE if not exists `task_list` (
  `task_id` integer NOT NULL,
  `user_id` integer NOT NULL,
  `date` date NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `repeatable` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1;