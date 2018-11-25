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

drop table if exists post;

create table post(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL, 
    content VARCHAR NOT NULL,
    author INTEGER NOT NULL REFERENCES user, 
    votes INTEGER NOT NULL, 
    creationDate Integer NOT NULL,
    numComments INTEGER NOT NULL
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

INSERT INTO user VALUES(NULL, 'pedro', '$2y$12$QVyJUELIIIdjAh0PmdsLm.2HiJ5zMEvKu9Ipd7lhb1qkNFRdReFAu', 'pedro@pedro.costa', 'no lo sey, chiquita', 1543162027 );
INSERT INTO post VALUES(NULL,'Já ninguém me responde no yahoo, este site é bom?','Yahoo é uma porcaria...',1,0,1543158350, 2);
INSERT INTO post VALUES(NULL,'Acho que o meu pai me anda a roubar dinheiro, ajudem.','Ultimamente anda-me a desaparecer dinheiro da mesinha.',1,4,1543158550,0);
INSERT INTO comment VALUES(NULL,1,1,'O Mate é fixe, também gosto',1,0,NULL);
INSERT INTO comment VALUES(NULL,1,1,'Concordo',0,1,1);
