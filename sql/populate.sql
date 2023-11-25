INSERT INTO country (name, city_id) VALUES 
    ('Portugal', NULL),
    ('United States', NULL),
    ('India', NULL),
    ('Brazil', NULL),
    ('Japan', NULL),
    ('Egypt', NULL),
    ('South Korea', NULL),
    ('United Kingdom', NULL),
    ('Germany', NULL),
    ('France', NULL),
    ('Italy', NULL),
    ('Spain', NULL),
    ('China', NULL),
    ('Russia', NULL),
    ('Australia', NULL),
    ('Canada', NULL),
    ('Mexico', NULL),
    ('Netherlands', NULL),
    ('Switzerland', NULL),
    ('Sweden', NULL),
    ('Norway', NULL),
    ('Denmark', NULL),
    ('Finland', NULL),
    ('Belgium', NULL),
    ('Austria', NULL),
    ('Greece', NULL),
    ('Turkey', NULL),
    ('South Africa', NULL),
    ('Porto', 1),
    ('Lisbon', 1),
    ('Leça da Palmeira', 1),
    ('New York City', 2),
    ('Mumbai', 3),
    ('Rio de Janeiro', 4),
    ('Tokyo', 5),
    ('Cairo', 6),
    ('Seoul', 7),
    ('London', 8),
    ('Berlin', 9),
    ('Paris', 10),
    ('Rome', 11),
    ('Madrid', 12),
    ('Beijing', 13),
    ('Moscow', 14),
    ('Sydney', 15),
    ('Toronto', 16),
    ('Mexico City', 17),
    ('Amsterdam', 18),
    ('Zurich', 19),
    ('Stockholm', 20),
    ('Oslo', 21),
    ('Copenhagen', 22),
    ('Helsinki', 23),
    ('Brussels', 24),
    ('Vienna', 25),
    ('Athens', 26),
    ('Istanbul', 27),
    ('Cape Town', 28);

    


INSERT INTO users (username, name, country_id, email, password, profile_photo, profile_private)
VALUES
    ('francisco.campos03', 'Francisco Campos', 1, 'francisco.campos@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'https://picsum.photos/1000', false),
    ('antonio.romao03', 'António Romão', 1, 'antonio.romao@gmail.com', '$2y$10$EpgSBve6Nc.Q.PepTjNp8uJUEyZQjnVfmIlLDHR9LGDZC8/VHWPl.', 'https://picsum.photos/1000', false),
    ('henrique.pinheiro03', 'Henrique Pinheiro', 1, 'henrique.pinheiro@gmail.com', '$2y$10$/zHdv.sEpPASgf6nXgObI.c.dleL0jqzAEVANmzB.GjFvjvPQ5kYO', 'https://picsum.photos/1000', true),
    ('jane-doe2346', 'Jane Doe', 2, 'jane.doe@gmail.com', '$2y$10$8dw4v6YscmyD6MG4Jf92BeOpi299ULr/Z57FCjhH6GrCWwhPb8Y7a', 'https://picsum.photos/1000', true),
    ('hackerman', 'Hackerman', 3, 'hacker.man@hack.hk', '$2y$10$xRQgfBx4DIkNk.Y6R4qOPuACJ8MTOm7I1VTPkF9K5Rh85tMRa7x0.', 'https://picsum.photos/1000', false),
    ('josefina', 'Josefina dos Santos', 4, 'josefina@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'https://picsum.photos/1000', false),
    ('haruki.murakami', 'Haruki Murakami', 5, 'haruki@gmail.jp', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'https://picsum.photos/1000', false),
    ('mohamed.ali', 'Mohamed Ali', 6, 'mohamed.ali@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'https://picsum.photos/1000', false),
    ('joo.won', 'Joo Won', 7, 'joo.won@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'https://picsum.photos/1000', false),
    ('james.bond', 'James Bond', 8, 'james.bond@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'https://picsum.photos/1000', false),
    ('eren.yeager', 'Eren Yeager', 9, 'eren.yeager@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'https://picsum.photos/1000', false),
    ('lupin', 'Lupin', 10, 'lupin@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'https://picsum.photos/1000', false),
    ('giorno.giovanna', 'Giorno Giovanna', 11, 'giorno.giovanna@gmail.com', '$2y$10$EpgSBve6Nc.Q.PepTjNp8uJUEyZQjnVfmIlLDHR9LGDZC8/VHWPl.', 'https://picsum.photos/1000', true),
    ('gabriel.garcia', 'Gabriel Garcia', 12, 'gabriel.garcia@gmail.com', '$2y$10$/zHdv.sEpPASgf6nXgObI.c.dleL0jqzAEVANmzB.GjFvjvPQ5kYO', 'https://picsum.photos/1000', false),
    ('jacky.chan', 'Jacky Chan', 13, 'jacky.chan@gmail.com', '$2y$10$8dw4v6YscmyD6MG4Jf92BeOpi299ULr/Z57FCjhH6GrCWwhPb8Y7a', 'https://picsum.photos/1000', true),
    ('anastasia.steele', 'Anastasia Steele', 14, 'anastasia.steele@gmail.com', '$2y$10$xRQgfBx4DIkNk.Y6R4qOPuACJ8MTOm7I1VTPkF9K5Rh85tMRa7x0.', 'https://picsum.photos/1000', false);
    

INSERT INTO admin (user_id)
VALUES
    (1),
    (2),
    (3);

INSERT INTO banned (user_id)
VALUES
    (5),
    (11);

INSERT INTO unban_request (title, description, date, banned_user_id)
VALUES
    ('Please unban me', 'I only tried to hack you because of FSI I swear', CURRENT_DATE, 5),
    ('Be careful...', "I will try again to wipe out your website", CURRENT_DATE, 11);

INSERT INTO common_help (title, description, date, user_id)
VALUES
    ('Account creation', 'I want to create another account', CURRENT_DATE, 3),
    ('Password change', 'I want to change my password', CURRENT_DATE, 4),
    ('Account deletion', 'I want to delete my account', CURRENT_DATE, 6),
    ('Account recovery', 'I want to recover my account', CURRENT_DATE, 7);


INSERT INTO faq (answer, question, last_edited, author_id)
VALUES
    ("You can join has many groups as you like! And dont worry, you won't need a VISA", 'Can I join multiple groups?', '2021-05-01 12:00:00', 1),
    ('You can change your password by clicking on the "Change Password" button on the top right corner of the page.', 'How can I change my password?', '2021-05-01 12:00:00', 2),
    

INSERT INTO report (description, evaluater_id, reporter_id, infractor_id, date)
VALUES
    ('He doesnt stop spamming my posts with mean comments!', 1, 4, 6, CURRENT_DATE),
    ('He stinks and hes a bad person', 1, 6, 4, CURRENT_DATE);

INSERT INTO requests (user1_id, user2_id)
VALUES
    (1, 4),
    (1, 3),
    (2, 3),
    (2, 4),
    (3, 4);

INSERT INTO follows (user1_id, user2_id)
VALUES
    (2, 1),
    (3, 1),
    (3, 2),
    (4, 1),
    (4, 2),
    (4, 3);

INSERT INTO blocks (user1_id, user2_id)
VALUES
    (1, 5),
    (2, 5),
    (3, 5),
    (4, 5);
	
INSERT INTO groups (country_id, description, banner_pic, subgroup_id)
VALUES
    (1, 'Welcome to the land of pastel de nata! SIUUUU', 'https://picsum.photos/1000', null),
    (2, 'Welcome to the land of the fredom (or at leat cowboys)', 'https://picsum.photos/1000', null),
    (3, 'This is the holy land of Hinduism. We love cows', 'https://picsum.photos/1000', null),
    (4, 'Carnaval, cachaça, and good beaches! What more could you ask for?', 'https://picsum.photos/1000', null),
    (5, 'This is the land of the rising sun. We love anime', 'https://picsum.photos/1000', null),
    (6, 'This is the land of the pyramids. We love cats', 'https://picsum.photos/1000', null),
    (7, 'This is the land of K-pop. We love kimchi', 'https://picsum.photos/1000', null),
    (8, 'This is the land of the queen. We love tea', 'https://picsum.photos/1000', null),
    (9, 'This is the land of the beer. We love beer', 'https://picsum.photos/1000', null),
    (10, 'This is the land of the baguette. We love baguettes', 'https://picsum.photos/1000', null),
    (11, 'This is the land of the pizza. We love pizza', 'https://picsum.photos/1000', null),
    (12, 'This is the land of the bull. We love bull', 'https://picsum.photos/1000', null),
    (13, 'This is the land of the panda. We love panda', 'https://picsum.photos/1000', null),
    (14, 'This is the land of the vodka. We love vodka', 'https://picsum.photos/1000', null),
    (15, 'This is the land of the kangaroo. We love kangaroo', 'https://picsum.photos/1000', null),
    (16, 'This is the land of the maple syrup. We love maple syrup', 'https://picsum.photos/1000', null),
    (17, 'This is the land of the taco. We love taco', 'https://picsum.photos/1000', null),
    (18, 'This is the land of the tulip. We love tulip', 'https://picsum.photos/1000', null),
    (19, 'This is the land of the chocolate. We love chocolate', 'https://picsum.photos/1000', null),
    (20, 'This is the land of the meatballs. We love meatballs', 'https://picsum.photos/1000', null),
    (21, 'This is the land of the viking. We love viking', 'https://picsum.photos/1000', null),
    (22, 'This is the land of the mermaid. We love mermaid', 'https://picsum.photos/1000', null),
    (23, 'This is the land of the viking. We love viking', 'https://picsum.photos/1000', null),
    (24, 'This is the land of the waffle. We love waffle', 'https://picsum.photos/1000', null),
    (25, 'This is the land of the schnitzel. We love schnitzel', 'https://picsum.photos/1000', null),
    (26, 'This is the land of the olive. We love olive', 'https://picsum.photos/1000', null),
    (27, 'This is the land of the kebab. We love kebab', 'https://picsum.photos/1000', null),
    (28, 'This is the land of the lion. We love lion', 'https://picsum.photos/1000', null),
    (29, 'Esta é a terra invicta <3. Francesinha, dragão, e bifana é o que vos damos!', 'https://picsum.photos/1000', 1),
    (30, 'This is the land of the lion. We love lion', 'https://picsum.photos/1000', 1),
    (31, 'Capital Nobre de Portugal, verdadeiramente fantástica!', 'https://picsum.photos/1000', 1),
    (32, "The city never sleeps, and so don't I", 'https://picsum.photos/1000', 2),
    (33, 'One of the most ICONIC indian cities!', 'https://picsum.photos/1000', 3),
    (34, 'Incredible parties, weather, and ', 'https://picsum.photos/1000', 4);


INSERT INTO owner (user_id, group_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (6, 5),
    (7, 6),
    (8, 7),
    (9, 8),
    (10, 9),
    (12, 10),
    (13, 11),
    (14, 12),
    (15, 13),
    (16, 14),
    (1, 15),
    (2, 16),
    (3, 17),
    (4, 18),
    (6, 19),
    (7, 20),
    (8, 21),
    (9, 22),
    (10, 23),
    (12, 24),
    (13, 25),
    (14, 26),
    (15, 27),
    (16, 28),
    (1, 29),
    (2, 30),
    (3, 31),
    (4, 32),

INSERT INTO members (user_id, group_id)
VALUES
    (1, 2),
    (2, 3),
    (2, 1),
    (3, 1),
    (3, 4),
    (4, 5),
    (4, 1),
    (6, 7),
    (7, 10),
    (8, 11),
    (9, 12),
    (10, 13),
    (12, 14),
    (13, 15),
    (14, 16),
    (15, 17),
    (16, 18),
    (1, 19),
    (2, 20),
    (3, 21),
    (4, 22),
    (6, 23),
    (7, 24),
    (8, 25),
    (9, 26),
    (10, 27),
    (12, 28),
    (13, 29),
    (14, 30),
    (15, 31),
    (16, 32);

INSERT INTO group_invitation (user_id, group_id)
VALUES
    (1, 5),
    (1, 6),
    (5, 20),
    (7, 12),
    (9, 14),
    (11, 16),
    (13, 18),
    (15, 20),
    (17, 22),
    (19, 24),
    (21, 26),
    (23, 28),
    (25, 30),
    (27, 32);

INSERT INTO banned_member (user_id, group_id)
VALUES
    (10, 31),
    (11, 32);


INSERT INTO post (date, text, media, author_id, group_id)
VALUES
    ('2023-05-01 09:00:00', 'Pyramids of Giza with @antonio.romao03', 'images/post-1.jpg', 1, 1),
    ('2019-08-21 12:00:00', 'Invicta', 'images/post-2.jpg', 1, 2),
    ('2018-04-07 14:00:00', 'Gladiators!', 'images/post-3.jpg', 1, 1),
    ('2012-06-09 07:30:00', 'Cup of tea with @francisco.campos03', 'images/post-4.jpg', 1, 2),
    ('2021-05-01 15:00:00', 'Tokyo', 'images/post-5.jpg', 2, 3),
    ('2023-08-01 10:00:00', 'Lisboa', 'images/post-6.jpg', 2, 2),
    ('2017-11-24 12:02:50', 'Freedom!!!', 'images/post-7.jpg', 3, 3),
    ('2015-03-31 16:12:11', 'hola to @lupin', 'images/post-8.jpg', 3, 3),
    ('2020-05-06 12:04:34', 'WOW', 'images/post-9.jpg', 4, 4);

INSERT INTO like_post (user_id, post_id)
VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (1, 4),
    (2, 1),
    (2, 2),
    (2, 3),
    (3, 1),
    (3, 2),
    (4, 1);

INSERT INTO tag (hashtag)
VALUES
    ('in-love'),
    ('amazed'),
    ('best-journey-ever'),
    ('best-day-ever'),
    ('dont-go');

INSERT INTO post_tag (post_id, tag_id)
VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (2, 1),
    (2, 2),
    (2, 3),
    (3, 1),
    (3, 2),
    (3, 3),
    (4, 1),
    (4, 2),
    (4, 3),
    (5, 1),
    (5, 2);

INSERT INTO message (time, content, sender_id, receiver_id)
VALUES
    ('2021-05-01 12:00:00', 'Hello! Welcome to the app!', 1, 2),
    ('2021-05-01 13:00:00', 'Hello! Welcome to the app!', 1, 3),
    ('2021-05-01 14:00:00', 'Hello! Welcome to the app!', 1, 4),
    ('2021-05-01 15:00:00', 'Hi! Thankss', 2, 1),
    ('2021-05-01 16:00:00', 'Heyhey, glad to be here :)', 2, 3),
    ('2021-05-01 17:00:00', 'Whatsapp dude?', 2, 4),
    ('2021-05-01 18:00:00', 'txs', 3, 1),
    ('2021-05-01 19:00:00', 'hi.', 3, 2),
    ('2021-05-01 20:00:00', 'wyd', 3, 4),
    ('2021-05-01 21:00:00', 'Thanks fellow traveller!', 4, 1),
    ('2021-05-01 22:00:00', 'Im incredible bro, and you?', 4, 2),
    ('2021-05-01 23:00:00', 'pull up', 4, 3);

INSERT INTO comments (text, date, post_id, author_id)
VALUES
    ('@josefina check this outt', '2021-05-01 12:00:00', 1, 1),
    ('@jacky.chan, you surely like this!', '2021-05-01 12:00:00', 1, 2),
    ('Beautiful scene!', '2021-05-01 12:00:00', 1, 3),
    ('When there last year, really liked it!', '2021-05-01 12:00:00', 1, 4),
    ('Please be careful with pickpockets!', '2021-05-01 12:00:00', 2, 1),
    ('If you loved it, you should really visit Porto!', '2021-05-01 12:00:00', 2, 2),
    ('My god @james.bond', '2021-05-01 12:00:00', 2, 3),
    ('@joo.won pleaseee come with me', '2021-05-01 12:00:00', 3, 1),
    ('Amazing!', '2021-05-01 12:00:00', 3, 2),
    ('Cool...', '2021-05-01 12:00:00', 4, 1);

INSERT INTO like_comment (user_id, comment_id)
VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (1, 4),
    (2, 1),
    (2, 2),
    (2, 3),
    (3, 1),
    (3, 2),
    (4, 1);
