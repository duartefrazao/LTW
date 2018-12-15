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
    channel INTEGER NOT NULL REFERENCES channel,
    parentEntity INTEGER REFERENCES entity (id)
);

drop table if exists channel;

create table channel(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL,
    description VARCHAR NOT NULL
);

drop table if exists channelImages;

create table channelImages(
    id INTEGER PRIMARY KEY,
    title VARCHAR NOT NULL
);

drop table if exists vote;

create table vote(
    entity INTEGER REFERENCES entity (id) NOT NULL,
    user INTEGER REFERENCES user (id) NOT NULL,
    up BOOLEAN NOT NULL,
    PRIMARY KEY (entity,user)
);


drop table if exists images;

create table images(
    id INTEGER PRIMARY KEY,
    title VARCHAR NOT NULL
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
    

INSERT INTO user VALUES(NULL, 'pedro', '$2y$12$QVyJUELIIIdjAh0PmdsLm.2HiJ5zMEvKu9Ipd7lhb1qkNFRdReFAu', 'pedro@hotmail.com', 'no lo sey, chiquita', 1543162027 );
INSERT INTO user VALUES(NULL, 'miguel','$2y$12$EXk9tujl4nlaDFAkDdleE.0WUTZHAPLZ/gOk/tJRtaSn9ZnvR9S2W', 'miguel@hotmail.com', 'yo soy guapo',1543277351);
INSERT INTO user VALUES(NULL, 'joao','$2y$12$hLyMtG8eaqZVH2JQnW7feeCHffLsiS9C6ZGoD7YDt0nM3RKqymuP6', 'joao@hotmail.com', 'muy rico yoyo',1543506410);
INSERT INTO user VALUES(NULL, 'maria', '$2y$12$Iw7TS8/y9UGEkaDlFaAyY.TRWyNRUy1VGZ0sHS7QP/ehHabi8gOIW', 'maria@hotmail.com', 'Ola, eu sou a Maria!', 1544831117);
INSERT INTO user VALUES(NULL, 'beatriz', '$2y$12$AL2UKKqq9MhPztpJF612EuYzfubF/QtoZbv0qFoqUfqqjb1NKjS1G', 'beatriz@hotmail.com', 'Então, tudo bem?', 1544831225);


/* CHANNELS */

INSERT INTO channel VALUES(NULL, "all",          "All the content you want");
INSERT INTO channel VALUES(NULL, "fun",          "Your daily dose of funny things!");
INSERT INTO channel VALUES(NULL, "student life", "We all been there!");
INSERT INTO channel VALUES(NULL, "ltw",          "Let Trump Work");
INSERT INTO channel VALUES(NULL, "science",      "Interesting science information");


/* POSTS */

INSERT INTO entity VALUES(NULL,'Isto é o reddit?????','Está igualzinho',3,0,1543878773,0,1,NULL);
INSERT INTO entity VALUES(NULL,'Qual é o melhor dia para casar?','Muitas pessoas dizem ser o 31 de julho, mas porquê?',4,0,1543878573,0,2,NULL);
INSERT INTO entity VALUES(NULL,'Vou de viagem.','Para onde?',5,0,1543878173,0,1,NULL);
INSERT INTO entity VALUES(NULL,'Já ninguém me responde no yahoo, este site é bom?','Yahoo é uma porcaria...',1,0,1543158350,2,1,NULL);
INSERT INTO entity VALUES(NULL,'Acho que o meu pai me anda a roubar dinheiro, ajudem.','Ultimamente anda-me a desaparecer dinheiro da mesinha.',2,0,1543162827,1,1,NULL);
INSERT INTO entity VALUES(NULL,"TIL Ravoux's slavemaker ant is a species where the queen can fake her own death to encourage ants from a rival 
                                colony to drag her body back to the nest. When there, she kills the nest's queen and bathes in her pheromones, 
                                becoming the new queen. Her soldiers overrun the colony and take control.",'Kill the Queen, become the Queen',3,0,1543573496,0,3,NULL);



/* COMMENTS */
INSERT INTO entity VALUES(NULL,'O Mate é fixe, também gosto',NULL,1,0,1543274764,2,1,4);
INSERT INTO entity VALUES(NULL,'Gosto bastante deste site!',NULL,3,0,1543506451,0,1,4);
INSERT INTO entity VALUES(NULL,'Olá Boa Noite!',NULL,4,0,1543506451,0,1,4);
/* INSERT INTO entity VALUES(NULL,"What the fuck did you just fucking say about me, you little bitch? 
                                I'll have you know I graduated top of my class in the Navy Seals, 
                                and I've been involved in numerous secret raids on Al-Quaeda, and I
                                have over 300 confirmed kills. I am trained in gorilla warfare and 
                                I'm the top sniper in the entire US armed forces. You are nothing 
                                to me but just another target. I will wipe you the fuck out with 
                                precision the likes of which has never been seen before on this Earth,
                                mark my fucking words. You think you can get away with saying that 
                                shit to me over the Internet? Think again, fucker. As we speak I am 
                                contacting my secret network of spies across the USA and your IP is 
                                being traced right now so you better prepare for the storm, maggot. 
                                The storm that wipes out the pathetic little thing you call your life.
                                You're fucking dead, kid. I can be anywhere, anytime, and I can kill 
                                you in over seven hundred ways, and that's just with my bare hands.
                                Not only am I extensively trained in unarmed combat, but I have 
                                access to the entire arsenal of the United States Marine Corps and 
                                I will use it to its full extent to wipe your miserable ass off the 
                                face of the continent, you little shit. If only you could have known
                                what unholy retribution your little 'clever' comment was about to bring
                                down upon you, maybe you would have held your fucking tongue. But you 
                                couldn't, you didn't, and now you're paying the price, you goddamn 
                                idiot. I will shit fury all over you and you will drown in it. 
                                You're fucking dead, kiddo.",NULL,2,0,1543509751,0,4); */
INSERT INTO entity VALUES(NULL,'Podes reformular a tua questão?',NULL,5,0,1543506451,3,1,4);
INSERT INTO entity VALUES(NULL,'Concordo',NULL,2,0,1543162627,0,2,5);


/* NESTED COMMENTS */
INSERT INTO entity VALUES(NULL,'Esqueceste-te de trocar de contas?',NULL,3,0,1544204766,1,1,7);
INSERT INTO entity VALUES(NULL,'A responder ao próprio post....',NULL,4,0,1544204906,0,1,7);
INSERT INTO entity VALUES(NULL,'Não, tens problemas é ó morcão?',NULL,1,0,1544206766,0,1,12);
INSERT INTO entity VALUES(NULL,'duvido',NULL,1,0,1543506451,0,1,10);
INSERT INTO entity VALUES(NULL,'Para bom entendedor...',NULL,5,0,1543506451,0,1,10);
INSERT INTO entity VALUES(NULL,'Para quê?',NULL,3,0,1543506451,0,1,10);

INSERT INTO VOTE VALUES(1,1,'true');
INSERT INTO VOTE VALUES(2,1,'false');

INSERT INTO IMAGES VALUES(1,'my face');
INSERT INTO IMAGES VALUES(2, "i'm me");
INSERT INTO IMAGES VALUES(3, "hey it's me");
INSERT INTO IMAGES VALUES(4, "Oy oy oy!");


INSERT INTO channelImages VALUES(2,'fun');
INSERT INTO channelImages VALUES(3, "life");
INSERT INTO channelImages VALUES(4, "trump");
INSERT INTO channelImages VALUES(5, "science");
 
 


