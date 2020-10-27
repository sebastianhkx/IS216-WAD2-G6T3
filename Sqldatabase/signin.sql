drop database if exists signin;
create database  if not exists signin;
use signin;

CREATE TABLE  if not exists signin (
  userid  varchar(32)    NOT NULL,
  username varchar(64)    NOT NULL,
  userpass  varchar(64)  NOT NULL,
  primary key (userid)
);
   

INSERT INTO user (userid, username, userpass) VALUES ('114514','Tom', '123456', ;
INSERT INTO user (userid, username, userpass) VALUES ('114515','Jerrry', '131421');