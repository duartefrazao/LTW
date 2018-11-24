PRAGMA foreign_keys=ON;
.mode columns
.headers on

drop table if exists user;

create table user(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR UNIQUE NOT NULL, 
    password VARCHAR NOT NULL,
    mail VARCHAR NOT NULL,
    creationDate INTEGER NOT NULL
);

drop table if exists story;

create table story(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL, 
    body VARCHAR NOT NULL,
    author INTEGER NOT NULL REFERENCES user, 
    upvotes INTEGER NOT NULL, 
    downvotes INTEGER NOT NULL
);

drop table if exists comment;

create table comment(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    author INTEGER NOT NULL REFERENCES user, 
    story INTEGER NOT NULL REFERENCES story,
    upvotes INTEGER NOT NULL, 
    downvotes INTEGER NOT NULL
);

INSERT INTO user VALUES(NULL, 'admin', '$2y$12$1yTE1UO/FdZy2FxsUtPWk.QINPqg9kzvIp95/7BOldV8v5JKLGXY2', 'admin@password.eu', 1543059947514);
