drop database if exists scheduler;

create database scheduler;

use scheduler;

CREATE TABLE if not exists userbase (
    id integer auto_increment primary key,
    username varchar(200),
    passwordHash varchar(1000)
);
