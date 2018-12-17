


INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (1, 'pedro', '$2y$12$QVyJUELIIIdjAh0PmdsLm.2HiJ5zMEvKu9Ipd7lhb1qkNFRdReFAu', 'pedro@hotmail.com', 'no lo sey, chiquita', 1543162027);
INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (2, 'miguel', '$2y$12$EXk9tujl4nlaDFAkDdleE.0WUTZHAPLZ/gOk/tJRtaSn9ZnvR9S2W', 'miguel@hotmail.com', 'yo soy guapo', 1543277351);
INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (3, 'joao', '$2y$12$hLyMtG8eaqZVH2JQnW7feeCHffLsiS9C6ZGoD7YDt0nM3RKqymuP6', 'joao@hotmail.com', 'muy rico yoyo', 1543506410);
INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (4, 'maria', '$2y$12$Iw7TS8/y9UGEkaDlFaAyY.TRWyNRUy1VGZ0sHS7QP/ehHabi8gOIW', 'maria@hotmail.com', 'Ola, eu sou a Maria!', 1544831117);
INSERT INTO user (id, username, password, mail, description, creationDate) VALUES (5, 'beatriz', '$2y$12$AL2UKKqq9MhPztpJF612EuYzfubF/QtoZbv0qFoqUfqqjb1NKjS1G', 'beatriz@hotmail.com', 'Então, tudo bem?', 1544831225);
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

INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (1, 'Isto é o reddit?????', 'Está igualzinho', 3, 250, 1500024982, 12, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (2, 'Qual é o melhor dia para casar?', 'Muitas pessoas dizem ser o 31 de julho, mas porquê?', 4, 157, 1530178573, 5, 2, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (3, 'Vou de viagem.', 'Para onde?', 5, -24, 1543324982, 0, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (4, 'Já ninguém me responde no yahoo, este site é bom?', 'Yahoo é uma porcaria...', 1, 13, 1543924982, 10, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (5, 'Acho que o meu pai me anda a roubar dinheiro, ajudem.', 'Ultimamente anda-me a desaparecer dinheiro da mesinha.', 2, 0, 1544224982, 1, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (6, 'TIL Ravoux''s slavemaker ant is a species where the queen can fake her own death to encourage ants from a rival 
                                colony to drag her body back to the nest. When there, she kills the nest''s queen and bathes in her pheromones, 
                                becoming the new queen. Her soldiers overrun the colony and take control.', 'Kill the Queen, become the Queen', 3, -230 , 1544924982, 23, 3, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (7, 'O Mate é fixe, também gosto', NULL, 1, 57, 1543274764, 2, 2, 4);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (8, 'Gosto bastante deste site!', NULL, 3, 12, 1543506451, 0, 1, 4);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (9, 'Olá Boa Noite!', NULL, 4, 0, 1543506451, 0, 1, 4);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (10, 'Podes reformular a tua questão?', NULL, 5, 89, 1543506451, 3, 1, 4);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (11, 'Concordo', NULL, 2, 0, 1543162627,-76, 2, 5);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (12, 'Esqueceste-te de trocar de contas?', NULL, 3, 32, 1544204766, 1, 1, 7);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (13, 'A responder ao próprio post....', NULL, 4, 56, 1544204906, 0, 1, 7);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (14, 'Não, tens problemas é ó morcão?', NULL, 1, 78, 1544206766, 1, 1, 12);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (15, 'duvido', NULL, 1, -65, 1543506451, 0, 1, 10);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (16, 'Para bom entendedor...', NULL, 5, -34, 1543506451, 0, 1, 10);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (17, 'Para quê?', NULL, 3, -43, 1543506451, 0, 1, 10);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (18, 'Thot', 'You are a thot', 6, 97, 1544964146, 12, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (19, 'My best move', 'Why not?', 6, 1, 1544964181, 6, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (20, 'Wholesome guy', '', 6, 8, 1544964249, 9, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (21, 'Christmas', 'My cats are wierd', 6, 12, 1544964301, 8, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (22, 'Qa tester', '', 6, 123, 1544964349, 0, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (23, 'Best way is to complicate', '', 6, 43, 1544964404, 10, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (24, 'It needs to work', 'Please', 6, 27, 1544964449, 7, 4, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (25, 'Confidential image', '', 6, 90, 1544964531, 6, 2, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (26, 'Everytime', 'You have doubts', 3, -34, 1544964599, 3, 4, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (27, 'Steveson', 'That teath', 3, 214, 1544964641, 2, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (28, 'Its science , I think', 'Take the knife', 3, 32, 1544964751, 1, 5, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (29, 'I++', '', 3, 23, 1544964797, 1, 3, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (30, 'Portugal in a nutshell', '', 1, 0, 1544964916, 43, 2, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (31, 'Amazed', '', 1, -35, 1544964989, 2, 1, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (32, 'We all fill it', 'Admit it', 1, 65, 1544965039, 2, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (33, 'Uno', '', 1, 124, 1544965095, 23, 6, NULL);
INSERT INTO entity (id, title, content, author, votes, creationDate, numComments, channel, parentEntity) VALUES (34, 'Dogi', '', 1, -435, 1544965164, 3, 6, NULL);


INSERT INTO images (id, title) VALUES (1, 'my face');
INSERT INTO images (id, title) VALUES (2, 'i''m me');
INSERT INTO images (id, title) VALUES (3, 'hey it''s me');
INSERT INTO images (id, title) VALUES (4, 'Oy oy oy!');
INSERT INTO images (id, title) VALUES (6, 'Hallo');

INSERT INTO vote (entity, user, up) VALUES (1, 1, 'true');
INSERT INTO vote (entity, user, up) VALUES (1, 2, 'true');
INSERT INTO vote (entity, user, up) VALUES (1, 3, 'true');
INSERT INTO vote (entity, user, up) VALUES (1, 4, 'true');
INSERT INTO vote (entity, user, up) VALUES (1, 5, 'true');
INSERT INTO vote (entity, user, up) VALUES (1, 6, 'true');
INSERT INTO vote (entity, user, up) VALUES (2, 3, 'true');
INSERT INTO vote (entity, user, up) VALUES (2, 4, 'true');
INSERT INTO vote (entity, user, up) VALUES (2, 5, 'true');
INSERT INTO vote (entity, user, up) VALUES (2, 1, 'true');

INSERT INTO vote (entity, user, up) VALUES (3, 1, 'false');
INSERT INTO vote (entity, user, up) VALUES (3, 2, 'false');
INSERT INTO vote (entity, user, up) VALUES (3, 3, 'false');
INSERT INTO vote (entity, user, up) VALUES (3, 4, 'false');
INSERT INTO vote (entity, user, up) VALUES (3, 5, 'false');
INSERT INTO vote (entity, user, up) VALUES (3, 6, 'false');

INSERT INTO vote (entity, user, up) VALUES (10, 1, 'true');
INSERT INTO vote (entity, user, up) VALUES (10, 2, 'false');
INSERT INTO vote (entity, user, up) VALUES (10, 3, 'true');
INSERT INTO vote (entity, user, up) VALUES (10, 4, 'false');
INSERT INTO vote (entity, user, up) VALUES (10, 5, 'true');
INSERT INTO vote (entity, user, up) VALUES (10, 6, 'false');

INSERT INTO vote (entity, user, up) VALUES (11, 2, 'false');
INSERT INTO vote (entity, user, up) VALUES (12, 3, 'true');
INSERT INTO vote (entity, user, up) VALUES (13, 4, 'false');
INSERT INTO vote (entity, user, up) VALUES (14, 5, 'true');
INSERT INTO vote (entity, user, up) VALUES (15, 6, 'false');
INSERT INTO vote (entity, user, up) VALUES (16, 2, 'true');
INSERT INTO vote (entity, user, up) VALUES (17, 3, 'false');
INSERT INTO vote (entity, user, up) VALUES (18, 4, 'true');



INSERT INTO vote (entity, user, up) VALUES (19, 1, 'true');
INSERT INTO vote (entity, user, up) VALUES (20, 2, 'false');
INSERT INTO vote (entity, user, up) VALUES (22, 3, 'true');
INSERT INTO vote (entity, user, up) VALUES (23, 4, 'false');
INSERT INTO vote (entity, user, up) VALUES (27, 5, 'true');
INSERT INTO vote (entity, user, up) VALUES (30, 6, 'false');
INSERT INTO vote (entity, user, up) VALUES (31, 2, 'true');
INSERT INTO vote (entity, user, up) VALUES (32, 3, 'false');
INSERT INTO vote (entity, user, up) VALUES (33, 4, 'true');
