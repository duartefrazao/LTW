PRAGMA foreign_keys=ON;
.mode columns
.headers on

-- Table: user
DROP TABLE IF EXISTS user;
CREATE TABLE user(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR UNIQUE NOT NULL, 
    password VARCHAR NOT NULL,
    mail VARCHAR NOT NULL,
    description VARCHAR,
    creationDate INTEGER NOT NULL
);

-- Table: channel
DROP TABLE IF EXISTS channel;
CREATE TABLE channel(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR NOT NULL,
    description VARCHAR NOT NULL
);


-- Table: channelImages
DROP TABLE IF EXISTS channelImages;
CREATE TABLE channelImages(
    id INTEGER PRIMARY KEY,
    title VARCHAR NOT NULL
);

-- Table: entity
DROP TABLE IF EXISTS entity;
CREATE TABLE entity(
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

-- Table: images
DROP TABLE IF EXISTS images;
CREATE TABLE images(
    id INTEGER PRIMARY KEY,
    title VARCHAR NOT NULL
);


-- Table: vote
DROP TABLE IF EXISTS vote;
CREATE TABLE vote(
    entity INTEGER REFERENCES entity (id) NOT NULL,
    user INTEGER REFERENCES user (id) NOT NULL,
    up BOOLEAN NOT NULL,
    PRIMARY KEY (entity,user)
);


-- Table: admin
DROP TABLE IF EXISTS admin; 
CREATE TABLE admin(
    channel INTEGER REFERENCES channel (id) NOT NULL,
    user INTEGER REFERENCES user (id) NOT NULL,
    PRIMARY KEY (channel,user)
);

-- Table: subscription
DROP TABLE IF EXISTS subscription;
CREATE TABLE subscription(
    channel INTEGER REFERENCES channel (id) NOT NULL,
    user INTEGER REFERENCES user (id) NOT NULL,
    PRIMARY KEY (channel,user)
);


-- Trigger: UpdateVotesOnDelete
DROP TRIGGER IF EXISTS UpdateVotesOnDelete;
CREATE TRIGGER UpdateVotesOnDelete
BEFORE DELETE ON VOTE
BEGIN
    UPDATE entity
        SET votes = votes -1
        WHERE old.entity=entity.id AND old.up='true';
    UPDATE entity 
        SET votes = votes +1
        WHERE old.entity=entity.id AND old.up='false';
END;

-- Trigger: UpdateVotesOnInsert
DROP TRIGGER IF EXISTS UpdateVotesOnInsert;
CREATE TRIGGER UpdateVotesOnInsert
BEFORE INSERT ON VOTE
BEGIN
    UPDATE entity
        SET votes = votes +1
        WHERE new.entity=entity.id AND new.up='true';
    UPDATE entity
        SET votes = votes -1
        WHERE new.entity=entity.id AND new.up='false';
END;




INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (1, 'pedro', '$2y$12$QVyJUELIIIdjAh0PmdsLm.2HiJ5zMEvKu9Ipd7lhb1qkNFRdReFAu', 'pedro@hotmail.com', 'no lo sey, chiquita', 1543162027);
INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (2, 'miguel', '$2y$12$EXk9tujl4nlaDFAkDdleE.0WUTZHAPLZ/gOk/tJRtaSn9ZnvR9S2W', 'miguel@hotmail.com', 'yo soy guapo', 1543277351);
INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (3, 'joao', '$2y$12$hLyMtG8eaqZVH2JQnW7feeCHffLsiS9C6ZGoD7YDt0nM3RKqymuP6', 'joao@hotmail.com', 'muy rico yoyo', 1543506410);
INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (4, 'maria', '$2y$12$Iw7TS8/y9UGEkaDlFaAyY.TRWyNRUy1VGZ0sHS7QP/ehHabi8gOIW', 'maria@hotmail.com', 'Ola, eu sou a Maria!', 1544831117);
INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (5, 'beatriz', '$2y$12$AL2UKKqq9MhPztpJF612EuYzfubF/QtoZbv0qFoqUfqqjb1NKjS1G', 'beatriz@hotmail.com', 'Ent�o, tudo bem?', 1544831225);
INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (6, 'Nk2016', '$2y$12$vD9Wjh4/x10jGXKdSR65cOVe9xsrdIejGFXopMNs7pNA8NEy.hizS', 'Nk@gmail.com', 'No til', 1544964027);

INSERT INTO channel (id, title, description) VALUES (1, 'all', 'All the content you want');
INSERT INTO channel (id, title, description) VALUES (2, 'fun', 'Your daily dose of funny things!');
INSERT INTO channel (id, title, description) VALUES (3, 'student life', 'We all been there!');
INSERT INTO channel (id, title, description) VALUES (4, 'ltw', 'Let Trump Work');
INSERT INTO channel (id, title, description) VALUES (5, 'science', 'Interesting science information');
INSERT INTO channel (id, title, description) VALUES (6, 'Memes', 'All the memes');

INSERT INTO channelImages (id, title) VALUES (2, 'fun');
INSERT INTO channelImages (id, title) VALUES (3, 'life');
INSERT INTO channelImages (id, title) VALUES (4, 'trump');
INSERT INTO channelImages (id, title) VALUES (5, 'science');
INSERT INTO channelImages (id, title) VALUES (6, 'Memes');

INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (1, 'Isto � o reddit?????', 'Est� igualzinho', 3, 1, 1500024982, 0, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (2, 'Qual � o melhor dia para casar?', 'Muitas pessoas dizem ser o 31 de julho, mas porqu�?', 4, -1, 1530178573, 0, 2, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (3, 'Vou de viagem.', 'Para onde?', 5, 0, 1543324982, 0, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (4, 'J� ningu�m me responde no yahoo, este site � bom?', 'Yahoo � uma porcaria...', 1, 0, 1543924982, 10, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (5, 'Acho que o meu pai me anda a roubar dinheiro, ajudem.', 'Ultimamente anda-me a desaparecer dinheiro da mesinha.', 2, 0, 1544224982, 1, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (6, 'TIL Ravoux''s slavemaker ant is a species where the queen can fake her own death to encourage ants from a rival 
                                colony to drag her body back to the nest. When there, she kills the nest''s queen and bathes in her pheromones, 
                                becoming the new queen. Her soldiers overrun the colony and take control.', 'Kill the Queen, become the Queen', 3, 0, 1544924982, 0, 3, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (7, 'O Mate � fixe, tamb�m gosto', NULL, 1, 0, 1543274764, 2, 1, 4);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (8, 'Gosto bastante deste site!', NULL, 3, 0, 1543506451, 0, 1, 4);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (9, 'Ol� Boa Noite!', NULL, 4, 0, 1543506451, 0, 1, 4);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (10, 'Podes reformular a tua quest�o?', NULL, 5, 0, 1543506451, 3, 1, 4);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (11, 'Concordo', NULL, 2, 0, 1543162627, 0, 2, 5);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (12, 'Esqueceste-te de trocar de contas?', NULL, 3, 0, 1544204766, 1, 1, 7);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (13, 'A responder ao pr�prio post....', NULL, 4, 0, 1544204906, 0, 1, 7);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (14, 'N�o, tens problemas � � morc�o?', NULL, 1, 0, 1544206766, 0, 1, 12);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (15, 'duvido', NULL, 1, 0, 1543506451, 0, 1, 10);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (16, 'Para bom entendedor...', NULL, 5, 0, 1543506451, 0, 1, 10);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (17, 'Para qu�?', NULL, 3, 0, 1543506451, 0, 1, 10);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (18, 'Thot', 'You are a thot', 6, 0, 1544964146, 0, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (19, 'My best move', 'Why not?', 6, 0, 1544964181, 0, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (20, 'Wholesome guy', '', 6, 0, 1544964249, 0, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (21, 'Christmas', 'My cats are wierd', 6, 0, 1544964301, 0, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (22, 'Qa tester', '', 6, 0, 1544964349, 0, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (23, 'Best way is to complicate', '', 6, 0, 1544964404, 0, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (24, 'It needs to work', 'Please', 6, 0, 1544964449, 0, 4, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (25, 'Confidential image', '', 6, 0, 1544964531, 0, 2, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (26, 'Everytime', 'You have doubts', 3, 0, 1544964599, 0, 4, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (27, 'Steveson', 'That teath', 3, 0, 1544964641, 0, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (28, 'Its science , I think', 'Take the knife', 3, 0, 1544964751, 0, 5, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (29, 'I++', '', 3, 0, 1544964797, 0, 3, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (30, 'Portugal in a nutshell', '', 1, 0, 1544964916, 0, 2, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (31, 'Amazed', '', 1, 0, 1544964989, 0, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (32, 'We all fill it', 'Admit it', 1, 0, 1544965039, 0, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (33, 'Uno', '', 1, 0, 1544965095, 0, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (34, 'Dogi', '', 1, 0, 1544965164, 0, 6, NULL);


INSERT INTO images (id, title) VALUES (1, 'my face');
INSERT INTO images (id, title) VALUES (2, 'i''m me');
INSERT INTO images (id, title) VALUES (3, 'hey it''s me');
INSERT INTO images (id, title) VALUES (4, 'Oy oy oy!');
INSERT INTO images (id, title) VALUES (6, '');
INSERT INTO images (id, title) VALUES (18, 'Thot');
INSERT INTO images (id, title) VALUES (19, '');
INSERT INTO images (id, title) VALUES (20, '');
INSERT INTO images (id, title) VALUES (21, '');
INSERT INTO images (id, title) VALUES (22, '');
INSERT INTO images (id, title) VALUES (23, '');
INSERT INTO images (id, title) VALUES (24, '');
INSERT INTO images (id, title) VALUES (25, '');
INSERT INTO images (id, title) VALUES (26, '');
INSERT INTO images (id, title) VALUES (27, 'Steve');
INSERT INTO images (id, title) VALUES (28, 'Knife');
INSERT INTO images (id, title) VALUES (29, '');
INSERT INTO images (id, title) VALUES (30, '');
INSERT INTO images (id, title) VALUES (31, '');
INSERT INTO images (id, title) VALUES (33, '');
INSERT INTO images (id, title) VALUES (34, '');
INSERT INTO images (id, title) VALUES (35, '');

INSERT INTO vote (entity, user, up) VALUES (1, 1, 'true');
INSERT INTO vote (entity, user, up) VALUES (2, 1, 'false');