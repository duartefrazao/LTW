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

-- Table: channelImages
DROP TABLE IF EXISTS channelImages;
CREATE TABLE channelImages(
    id INTEGER PRIMARY KEY,
    title VARCHAR NOT NULL
);


-- Table: channelImages
DROP TABLE IF EXISTS postImages;
CREATE TABLE postImages(
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

