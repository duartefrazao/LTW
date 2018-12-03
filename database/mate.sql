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
    entity INTEGER REFERENCES entity (id) NOT NULL,
    user INTEGER REFERENCES user (id) NOT NULL,
    up BOOLEAN NOT NULL,
    PRIMARY KEY (entity,user)
);


CREATE TRIGGER if not exists UpdateVotesOnInsert
BEFORE INSERT ON VOTE
BEGIN
    UPDATE entity
        SET votes = votes +1
        WHERE new.entity=entity.id AND new.up='true';
    UPDATE entity
        SET votes = votes -1
        WHERE new.entity=entity.id AND new.up='false';
END;

CREATE TRIGGER if not exists UpdateVotesOnDelete
BEFORE DELETE ON VOTE
BEGIN
    UPDATE entity
        SET votes = votes -1
        WHERE old.entity=entity.id AND old.up='true';
    UPDATE entity 
        SET votes = votes +1
        WHERE old.entity=entity.id AND old.up='false';
END;
    

INSERT INTO user VALUES(NULL, 'pedro', '$2y$12$QVyJUELIIIdjAh0PmdsLm.2HiJ5zMEvKu9Ipd7lhb1qkNFRdReFAu', 'pedro@pedro.costa', 'no lo sey, chiquita', 1543162027 );
INSERT INTO user VALUES(NULL, 'miguel','$2y$12$EXk9tujl4nlaDFAkDdleE.0WUTZHAPLZ/gOk/tJRtaSn9ZnvR9S2W', 'miguel@miguel.com', 'yo soy guapo',1543277351);
INSERT INTO user VALUES(NULL, 'joao','$2y$12$hLyMtG8eaqZVH2JQnW7feeCHffLsiS9C6ZGoD7YDt0nM3RKqymuP6', 'joao@joao', 'muy rico yoyo',1543506410);


/* POSTS */

INSERT INTO entity VALUES(NULL,'Isto é o reddit?????','Está igualzinho',3,0,1543878773,0,NULL);
INSERT INTO entity VALUES(NULL,'Qual é o melhor dia para casar?','Muitas pessoas dizem ser o 31 de agosto, mas porquê?',2,0,1543878573,0,NULL);
INSERT INTO entity VALUES(NULL,'Vou de viagem.','Para onde?',1,0,1543878173,0,NULL);
INSERT INTO entity VALUES(NULL,'Já ninguém me responde no yahoo, este site é bom?','Yahoo é uma porcaria...',1,0,1543158350,2,NULL);
INSERT INTO entity VALUES(NULL,'Acho que o meu pai me anda a roubar dinheiro, ajudem.','Ultimamente anda-me a desaparecer dinheiro da mesinha.',2,0,1543162827,1,NULL);
INSERT INTO entity VALUES(NULL,"TIL Ravoux's slavemaker ant is a species where the queen can fake her own death to encourage ants from a rival 
                                colony to drag her body back to the nest. When there, she kills the nest's queen and bathes in her pheromones, 
                                becoming the new queen. Her soldiers overrun the colony and take control.",'Kill the Queen, become the Queen',3,0,1543573496,0,NULL);


/* COMMENTS */
INSERT INTO entity VALUES(NULL,'O Mate é fixe, também gosto',NULL,1,0,1543274764,1,4);
INSERT INTO entity VALUES(NULL,'Gosto bastante deste site!',NULL,3,0,1543506451,0,4);
INSERT INTO entity VALUES(NULL,'Concordo',NULL,1,0,1543162627,0,5);

/* INSERT INTO VOTE VALUES(1,1,'true');
INSERT INTO VOTE VALUES(2,1,'false'); */


