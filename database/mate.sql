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

drop table if exists entity;

create table entity(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL, 
    content VARCHAR,
    author INTEGER NOT NULL REFERENCES user, 
    votes INTEGER NOT NULL, 
    creationDate Integer NOT NULL,
    numComments INTEGER NOT NULL,
    parentEntity INTEGER REFERENCES entity (id)
);

drop table if exists vote;

create table vote(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    entity INTEGER REFERENCES entity (id) NOT NULL,
    user INTEGER REFERENCES user (id) NOT NULL,
    up BOOLEAN NOT NULL
);

INSERT INTO user VALUES(NULL, 'pedro', '$2y$12$QVyJUELIIIdjAh0PmdsLm.2HiJ5zMEvKu9Ipd7lhb1qkNFRdReFAu', 'pedro@pedro.costa', 'no lo sey, chiquita', 1543162027 );
INSERT INTO USER VALUES(NULL, 'miguel','$2y$12$EXk9tujl4nlaDFAkDdleE.0WUTZHAPLZ/gOk/tJRtaSn9ZnvR9S2W', 'miguel@miguel.com', 'yo soy guapo',1543277351);
INSERT INTO entity VALUES(NULL,'Já ninguém me responde no yahoo, este site é bom?','Yahoo é uma porcaria...',1,0,1543158350,1,NULL);
INSERT INTO entity VALUES(NULL,'Acho que o meu pai me anda a roubar dinheiro, ajudem.','Ultimamente anda-me a desaparecer dinheiro da mesinha.',2,0,1543162827,1,NULL);
INSERT INTO entity VALUES(NULL,'O Mate é fixe, também gosto',NULL,1,0,1543274764,0,1);
INSERT INTO entity VALUES(NULL,'Concordo',NULL,1,0,1543162627,0,2);


