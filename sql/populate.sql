INSERT INTO users (username, name, country, email, password, profile_photo, profile_private)
VALUES
    ('francisco.campos03', 'Francisco Campos', 'Portugal', 'francisco.campos@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'https://picsum.photos/1000', false),
    ('antonio.romao03', 'António Romão', 'Portugal', 'antonio.romao@gmail.com', '$2y$10$EpgSBve6Nc.Q.PepTjNp8uJUEyZQjnVfmIlLDHR9LGDZC8/VHWPl.', 'https://picsum.photos/1000', false),
    ('henrique.pinheiro03', 'Henrique Pinheiro', 'Portugal', 'henrique.pinheiro@gmail.com', '$2y$10$/zHdv.sEpPASgf6nXgObI.c.dleL0jqzAEVANmzB.GjFvjvPQ5kYO', 'https://picsum.photos/1000', true),
    ('jane-doe2346', 'Jane Doe', 'United States', 'jane.doe@gmail.com', '$2y$10$8dw4v6YscmyD6MG4Jf92BeOpi299ULr/Z57FCjhH6GrCWwhPb8Y7a', 'https://picsum.photos/1000', true),
    ('hackerman', 'Hackerman', 'India', 'hacker.man@hack.hk', '$2y$10$xRQgfBx4DIkNk.Y6R4qOPuACJ8MTOm7I1VTPkF9K5Rh85tMRa7x0.', 'https://picsum.photos/1000', false);

INSERT INTO admin (user_id)
VALUES
    (1),
    (2),
    (3);

INSERT INTO banned (user_id)
VALUES
    (5);

INSERT INTO unban_request (title, description, banned_user_id)
VALUES
    ('Please unban me', 'I promise I will not do it again', 5);

INSERT INTO common_help (title, description, user_id)
VALUES
    ('I need help', 'I want to create another account', 3);


INSERT INTO faq (answer, question, last_edited, author_id)
VALUES
    ('You can create another account by clicking on the "Create Account" button on the top right corner of the page.', 'How can I create another account?', '2021-05-01 12:00:00', 1),
    ('You can change your password by clicking on the "Change Password" button on the top right corner of the page.', 'How can I change my password?', '2021-05-01 12:00:00', 2);

INSERT INTO report (description, evaluater_id, reporter_id, infractor_id)
VALUES
    ('This user is spamming', 1, 4, 3),
    ('This user is spamming', 1, 3, 4);

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
	
INSERT INTO groups (name, description, banner_pic)
VALUES
    ('Portugal', 'Description', 'https://picsum.photos/1000'),
    ('United States', 'Description', 'https://picsum.photos/1000'),
    ('India', 'Description', 'https://picsum.photos/1000'),
    ('Brazil', 'Description', 'https://picsum.photos/1000'),
    ('Leça da Palmeira', 'Description', 'https://picsum.photos/1000'),
    ('NYC', 'Description', 'https://picsum.photos/1000'),
    ('Mumbai', 'Description', 'https://picsum.photos/1000'),
    ('Rio de Janeiro', 'Description', 'https://picsum.photos/1000'),
    ('Lisboa', 'Description', 'https://picsum.photos/1000');

INSERT INTO subgroup (subgroup_id, group_id)
VALUES
    (5, 1),
    (9, 1),
    (6, 2),
    (7, 3),
    (8, 4);

INSERT INTO owner (user_id, group_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4);

INSERT INTO members (user_id, group_id)
VALUES
    (1, 2),
    (2, 3),
    (2, 1),
    (3, 1),
    (3, 4),
    (4, 5),
    (4, 1);

INSERT INTO group_invitation (user_id, group_id)
VALUES
    (1, 5),
    (1, 6);

INSERT INTO group_creation (user_id, group_id)
VALUES
    (3, 7),
    (4, 8);


INSERT INTO post (date, text, media, author_id, group_id)
VALUES
    ('2021-05-01 12:00:00', 'This is a post', 'https://picsum.photos/1000', 1, 1),
    ('2021-05-01 12:00:00', 'This is a post', 'https://picsum.photos/1000', 1, 2),
    ('2021-05-01 12:00:00', 'This is a post', 'https://picsum.photos/1000', 1, 1),
    ('2021-05-01 12:00:00', 'This is a post', 'https://picsum.photos/1000', 1, 2),
    ('2021-05-01 12:00:00', 'This is a post', 'https://picsum.photos/1000', 2, 3),
    ('2021-05-01 12:00:00', 'This is a post', 'https://picsum.photos/1000', 2, 2),
    ('2021-05-01 12:00:00', 'This is a post', 'https://picsum.photos/1000', 3, 3),
    ('2021-05-01 12:00:00', 'This is a post', 'https://picsum.photos/1000', 3, 3),
    ('2021-05-01 12:00:00', 'This is a post', 'https://picsum.photos/1000', 4, 4);

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
    ('2021-05-01 12:00:00', 'Hello', 1, 2),
    ('2021-05-01 13:00:00', 'Hello', 1, 3),
    ('2021-05-01 14:00:00', 'Hello', 1, 4),
    ('2021-05-01 15:00:00', 'Hello', 2, 1),
    ('2021-05-01 16:00:00', 'Hello', 2, 3),
    ('2021-05-01 17:00:00', 'Hello', 2, 4),
    ('2021-05-01 18:00:00', 'Hello', 3, 1),
    ('2021-05-01 19:00:00', 'Hello', 3, 2),
    ('2021-05-01 20:00:00', 'Hello', 3, 4),
    ('2021-05-01 21:00:00', 'Hello', 4, 1),
    ('2021-05-01 22:00:00', 'Hello', 4, 2),
    ('2021-05-01 23:00:00', 'Hello', 4, 3);

INSERT INTO comments (text, date, post_id, author_id)
VALUES
    ('This is a comment', '2021-05-01 12:00:00', 1, 1),
    ('This is a comment', '2021-05-01 12:00:00', 1, 2),
    ('This is a comment', '2021-05-01 12:00:00', 1, 3),
    ('This is a comment', '2021-05-01 12:00:00', 1, 4),
    ('This is a comment', '2021-05-01 12:00:00', 2, 1),
    ('This is a comment', '2021-05-01 12:00:00', 2, 2),
    ('This is a comment', '2021-05-01 12:00:00', 2, 3),
    ('This is a comment', '2021-05-01 12:00:00', 3, 1),
    ('This is a comment', '2021-05-01 12:00:00', 3, 2),
    ('This is a comment', '2021-05-01 12:00:00', 4, 1);

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
