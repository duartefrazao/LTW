PRAGMA foreign_keys=ON;
.mode columns
.headers on

drop table if exists user;

create table user(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR UNIQUE NOT NULL, 
    password VARCHAR NOT NULL,
    mail VARCHAR NOT NULL,
    description VARCHAR,
    creationDate INTEGER NOT NULL
);

drop table if exists entry;

create table entry(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    author INTEGER NOT NULL REFERENCES user, 
    content VARCHAR NOT NULL,
    creationDate Integer NOT NULL
);

drop table if exists post;

create table post(
    id INTEGER REFERENCES entry (id) PRIMARY KEY ,
    title VARCHAR NOT NULL
);

drop table if exists comment;

create table comment(
    id INTEGER REFERENCES entry (id) PRIMARY KEY ,
    post INTEGER NOT NULL REFERENCES post NOT NULL,
    parentcomment INTEGER REFERENCES entry (id) 
);

drop table if exists vote;

create table vote(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    entry INTEGER REFERENCES entry (id) NOT NULL,
    user INTEGER REFERENCES user (id) NOT NULL,
    up BOOLEAN NOT NULL
);

INSERT INTO user VALUES(NULL, 'pedro', '$2y$12$QVyJUELIIIdjAh0PmdsLm.2HiJ5zMEvKu9Ipd7lhb1qkNFRdReFAu', 'pedro@pedro.costa', 'no lo sey, chiquita', 1543162027 );
INSERT INTO entry VALUES(NULL,1,'Yahoo é uma porcaria...',1543158350);
INSERT INTO post VALUES(1,'Já ninguém me responde no yahoo, este site é bom?');
INSERT INTO vote VALUES(NULL,1,1,'true');
INSERT INTO entry VALUES(NULL,1,'Acho que o meu pai me anda a roubar dinheiro, ajudem.',1543158550);
INSERT INTO post VALUES(2,'Ultimamente anda-me a desaparecer dinheiro da mesinha.');
INSERT INTO vote VALUES(NULL,2,1,'false');
INSERT INTO entry VALUES(NULL,1,'O Mate é fixe, também gosto',1543158350);
INSERT INTO comment VALUES(3,1,NULL);
INSERT INTO entry VALUES(NULL,1,'Yahoo é uma porcaria...',1543158350);
INSERT INTO comment VALUES(4,2,NULL);
