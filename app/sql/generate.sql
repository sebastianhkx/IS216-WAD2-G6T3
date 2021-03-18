drop database if exists PET_APP;

create database PET_APP;

use PET_APP;

CREATE TABLE if not exists pets (
    PETID integer auto_increment primary key,
    imgPath varchar(2000),
    Date_and_Time DateTime,
    BirthDate  date,
    Pet_name varchar(2000),
    Pet_breed varchar(2000),
    Pet_type varchar(2000),
    Pet_info varchar(2000),
    pet_status  varchar(2000),
    Confirm_Adopt  boolean,
    Confirm_Aban  boolean,
    AbandonEmail  varchar(200)
)ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

CREATE TABLE if not exists adopter (
  AdoptID integer auto_increment primary key,
  FirstName varchar(2000),
  LastName varchar(2000),
  AdoptEmail  varchar(2000),
  TeleID varchar(2000),
  Pet_ID varchar(2000),
  Location  varchar(2000),
  DateIndicate varchar(2000)
)ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

CREATE TABLE if not exists abandoner (
    AbandonID  integer auto_increment primary key,
    AbandonEmail  varchar(2000),
    FirstName DateTime,
    BirthDate  date,
    LastName varchar(2000),
    TeleID  varchar(2000),
    ChosenDate  varchar(2000) 
)ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;


