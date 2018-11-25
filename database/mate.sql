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

drop table if exists post;

create table post(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL, 
    content VARCHAR NOT NULL,
    author INTEGER NOT NULL REFERENCES user, 
    votes INTEGER NOT NULL, 
    creationDate Integer NOT NULL
);

drop table if exists comment;

create table comment(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    author INTEGER NOT NULL REFERENCES user, 
    post INTEGER NOT NULL REFERENCES post,
    content VARCHAR NOT NULL,
    upvotes INTEGER NOT NULL, 
    downvotes INTEGER NOT NULL,
    parentcomment INTEGER
);

INSERT INTO user VALUES(NULL, 'admin', '$2y$12$1yTE1UO/FdZy2FxsUtPWk.QINPqg9kzvIp95/7BOldV8v5JKLGXY2', 'admin@password.eu', 1543059947514);
INSERT INTO user VALUES(NULL, 'Jonh Doe', '$2y$12$1yTE1UO/FdZy2FxsUtPWk.QINPqg9kzvIp95/7BOldV8v5JKLGXY2', 'jonh@password.eu', 1543060825656);
INSERT INTO user VALUES(NULL, 'Pedro Costa', '$2y$12$1yTE1UO/FdZy2FxsUtPWk.QINPqg9kzvIp95/7BOldV8v5JKLGXY2', 'pedro@password.eu', 1543060825056);
INSERT INTO user VALUES(NULL, 'Duarte Frazão', '$2y$12$1yTE1UO/FdZy2FxsUtPWk.QINPqg9kzvIp95/7BOldV8v5JKLGXY2', 'duarte@password.eu', 1543020825656);
INSERT INTO user VALUES(NULL, 'César Medeiros', '$2y$12$1yTE1UO/FdZy2FxsUtPWk.QINPqg9kzvIp95/7BOldV8v5JKLGXY2', 'cesar@password.eu', 1543260825656);
INSERT INTO post VALUES(NULL,'Já ninguém me responde no yahoo, este site é bom?','Yahoo é uma porcaria...',1,0,1543260825656);
INSERT INTO comment VALUES(1,2,1,'O Mate é fixe, também gosto',1,0,NULL);
INSERT INTO comment VALUES(2,1,1,'Concordo',0,1,1);
