create schema if not exists lbaw2346;

SET DateStyle TO European;

-- Drop existing tables and types if they exist

DROP TABLE IF EXISTS report_notification CASCADE;
DROP TABLE IF EXISTS common_help_notification CASCADE;
DROP TABLE IF EXISTS appeal_notification CASCADE;
DROP TABLE IF EXISTS group_creation_notification CASCADE;
DROP TABLE IF EXISTS follow_notification CASCADE;
DROP TABLE IF EXISTS new_message_notification CASCADE;
DROP TABLE IF EXISTS comment_notification CASCADE;
DROP TABLE IF EXISTS post_notification CASCADE;
DROP TABLE IF EXISTS group_notification CASCADE;
DROP TABLE IF EXISTS banned_member CASCADE;
DROP TABLE IF EXISTS members CASCADE;
DROP TABLE IF EXISTS owner CASCADE;
DROP TABLE IF EXISTS groups CASCADE;
DROP TABLE IF EXISTS like_comment CASCADE;
DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS message CASCADE;
DROP TABLE IF EXISTS post_tag CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS post CASCADE;
DROP TABLE IF EXISTS like_post CASCADE;
DROP TABLE IF EXISTS blocks CASCADE;
DROP TABLE IF EXISTS follows CASCADE;
DROP TABLE IF EXISTS requests CASCADE;
DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS faq CASCADE;
DROP TABLE IF EXISTS common_help CASCADE;
DROP TABLE IF EXISTS unban_request CASCADE;
DROP TABLE IF EXISTS banned CASCADE;
DROP TABLE IF EXISTS admin CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS country CASCADE;

DROP TYPE IF EXISTS comment_notification_types;
DROP TYPE IF EXISTS post_notification_types;
DROP TYPE IF EXISTS group_notification_types;
DROP TYPE IF EXISTS follow_notification_types;

DROP FUNCTION IF EXISTS users_search_update CASCADE;
DROP FUNCTION IF EXISTS post_search_update CASCADE;
DROP FUNCTION IF EXISTS groups_search_update CASCADE;
DROP FUNCTION IF EXISTS tag_search_update CASCADE;
DROP FUNCTION IF EXISTS verify_group_post CASCADE;
DROP FUNCTION IF EXISTS group_owner CASCADE;
DROP FUNCTION IF EXISTS verify_priv_follow_request CASCADE;
DROP FUNCTION IF EXISTS follow_request_notification CASCADE;
DROP FUNCTION IF EXISTS follow_accept_notification CASCADE;
DROP FUNCTION IF EXISTS group_join_notification CASCADE;
/*DROP FUNCTION IF EXISTS group_leave_notification CASCADE;*/
DROP FUNCTION IF EXISTS group_ban_notification CASCADE;
DROP FUNCTION IF EXISTS group_owner_notification CASCADE;
DROP FUNCTION IF EXISTS new_message_notification CASCADE;
DROP FUNCTION IF EXISTS new_comment_notification CASCADE;
DROP FUNCTION IF EXISTS like_comment_notification CASCADE;
DROP FUNCTION IF EXISTS mention_comment_notification CASCADE;
DROP FUNCTION IF EXISTS like_post_notification CASCADE;
DROP FUNCTION IF EXISTS mention_description_notification CASCADE;
DROP FUNCTION IF EXISTS common_help_notification CASCADE;
DROP FUNCTION IF EXISTS appeal_notification CASCADE;
DROP FUNCTION IF EXISTS report_notification CASCADE;


-- Types

CREATE TYPE comment_notification_types AS ENUM('mention_comment', 'liked_comment', 'new_comment');
CREATE TYPE post_notification_types AS ENUM('new_like', 'mention_description');
CREATE TYPE group_notification_types AS ENUM('group_join', 'group_leave', 'group_ban', 'group_owner');
CREATE TYPE follow_notification_types AS ENUM('follow_request', 'follow_accept');

-- Create tables

CREATE TABLE country (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    city_id INT REFERENCES country(id) ON DELETE CASCADE
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) UNIQUE,
    name VARCHAR(255),
    country_id INT REFERENCES country(id) NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    profile_photo TEXT,
    profile_private BOOLEAN DEFAULT false,
    is_deleted BOOLEAN DEFAULT false
);

CREATE TABLE admin (
    user_id INT PRIMARY KEY REFERENCES users(id)
);

CREATE TABLE banned (
    user_id INT PRIMARY KEY REFERENCES users(id),
    ban_date TIMESTAMP NOT NULL CHECK (ban_date <= now())
);

CREATE TABLE unban_request (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date TIMESTAMP NOT NULL CHECK (date <= now()),
    accept_appeal BOOLEAN DEFAULT NULL,
    banned_user_id INT REFERENCES users(id)
);

CREATE TABLE common_help (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date TIMESTAMP NOT NULL CHECK (date <= now()),
    answer TEXT,
    became_faq BOOLEAN DEFAULT FALSE,
    user_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE faq (
    id SERIAL PRIMARY KEY,
    answer TEXT NOT NULL,
    question VARCHAR(255) UNIQUE NOT NULL,
    last_edited TIMESTAMP NOT NULL CHECK (last_edited <= now()),
    author_id INT REFERENCES admin(user_id)
);

CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    reporter_id INT REFERENCES users(id) NOT NULL,
    infractor_id INT REFERENCES users(id) NOT NULL,
    date TIMESTAMP NOT NULL CHECK (date <= now()),
    ban_infractor BOOLEAN DEFAULT NULL
);

CREATE TABLE requests (
    user1_id INT REFERENCES users(id) NOT NULL,
    user2_id INT REFERENCES users(id) NOT NULL CHECK (user1_id <> user2_id),
    PRIMARY KEY (user1_id, user2_id)
);

CREATE TABLE follows (
    user1_id INT REFERENCES users(id) NOT NULL,
    user2_id INT REFERENCES users(id) NOT NULL CHECK (user1_id <> user2_id),
    PRIMARY KEY (user1_id, user2_id)
);

CREATE TABLE blocks (
    user1_id INT REFERENCES users(id) NOT NULL,
    user2_id INT REFERENCES users(id) NOT NULL CHECK (user1_id <> user2_id),
    PRIMARY KEY (user1_id, user2_id)
);

CREATE TABLE groups (
    id SERIAL PRIMARY KEY,
    country_id INT REFERENCES country(id) ON DELETE CASCADE,
    description TEXT NOT NULL,
    banner_pic TEXT,
    approved BOOLEAN DEFAULT NULL,
    subgroup_id INT REFERENCES groups(id) ON DELETE CASCADE
);

CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP NOT NULL CHECK (date <= now()),
    text TEXT,
    media TEXT,
    author_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    edited BOOLEAN DEFAULT false
);

CREATE TABLE like_post (
    user_id INT REFERENCES users(id) NOT NULL,
    post_id INT REFERENCES post(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, post_id)
);

CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    hashtag VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE post_tag (
    post_id INT REFERENCES post(id) ON DELETE CASCADE,
    tag_id INT REFERENCES tag(id) NOT NULL,
    PRIMARY KEY (post_id, tag_id)
);

CREATE TABLE message (
    id SERIAL PRIMARY KEY,
    time TIMESTAMP NOT NULL CHECK (time <= now()),
    content TEXT NOT NULL,
    sender_id INT REFERENCES users(id) NOT NULL,
    receiver_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE comments (
    id SERIAL PRIMARY KEY,
    text TEXT NOT NULL,
    date TIMESTAMP NOT NULL CHECK (date <= now()),
    post_id INT REFERENCES post(id) ON DELETE CASCADE,
    author_id INT REFERENCES users(id) NOT NULL,
    edited BOOLEAN DEFAULT false
);

CREATE TABLE like_comment (
    user_id INT REFERENCES users(id) NOT NULL,
    comment_id INT REFERENCES comments(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, comment_id)
);

CREATE TABLE owner (
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    PRIMARY KEY (user_id, group_id)
);

CREATE TABLE members (
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    PRIMARY KEY (user_id, group_id)
);

CREATE TABLE banned_member (
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    PRIMARY KEY (user_id, group_id)
);

CREATE TABLE report_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES admin(user_id) ON DELETE CASCADE,
    sender_id INT REFERENCES users(id),
    report_id INT REFERENCES report(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE common_help_notification (
    id SERIAL PRIMARY KEY,
    time TIMESTAMP NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES admin(user_id) ON DELETE CASCADE,
    sender_id INT REFERENCES users(id),
    common_help_id INT REFERENCES common_help(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE appeal_notification (
    id SERIAL PRIMARY KEY,
    time TIMESTAMP NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES admin(user_id) ON DELETE CASCADE,
    sender_id INT REFERENCES users(id),
    unban_request_id INT REFERENCES unban_request(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE group_creation_notification (
    id SERIAL PRIMARY KEY,
    time TIMESTAMP NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES admin(user_id) ON DELETE CASCADE,
    sender_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) ON DELETE CASCADE,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE follow_notification (
    id SERIAL PRIMARY KEY,
    time TIMESTAMP NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
    sender_id INT REFERENCES users(id) NOT NULL,
    notification_type follow_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE new_message_notification (
    id SERIAL PRIMARY KEY,
    time TIMESTAMP NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
    sender_id INT REFERENCES users(id) NOT NULL,
    message_id INT REFERENCES message(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE comment_notification (
    id SERIAL PRIMARY KEY,
    time TIMESTAMP NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
    sender_id INT REFERENCES users(id) NOT NULL,
    comment_id INT REFERENCES comments(id) ON DELETE CASCADE,
    notification_type comment_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE post_notification (
    id SERIAL PRIMARY KEY,
    time TIMESTAMP NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
    sender_id INT REFERENCES users(id) NOT NULL,
    post_id INT REFERENCES post(id) ON DELETE CASCADE,
    notification_type post_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE group_notification (
    id SERIAL PRIMARY KEY,
    time TIMESTAMP NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
    sender_id INT REFERENCES users(id),
    group_id INT REFERENCES groups(id) ON DELETE CASCADE,
    notification_type group_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

-- Performance Indexes

CREATE INDEX post_author_id ON post USING hash (author_id);

CREATE INDEX post_group_id ON post USING hash (group_id);

CREATE INDEX post_notified_id ON post_notification USING hash (notified_id);

-- FTS Indexes

-- Add column to users to store computed ts_vectors.
ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;
-- Create a function to automatically update ts_vectors.
CREATE FUNCTION users_search_update() RETURNS TRIGGER AS $$
BEGIN
IF TG_OP = 'INSERT' THEN
NEW.tsvectors = (
setweight(to_tsvector('portuguese', NEW.username), 'A') ||
setweight(to_tsvector('portuguese', NEW.name), 'B')
);
END IF;
IF TG_OP = 'UPDATE' THEN
IF (NEW.username <> OLD.username OR NEW.name <> OLD.name) THEN
NEW.tsvectors = (
setweight(to_tsvector('portuguese', NEW.username), 'A') ||
setweight(to_tsvector('portuguese', NEW.name), 'B')
);
END IF;
END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;
-- Create a trigger before insert or update on users
CREATE TRIGGER users_search_update
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
EXECUTE PROCEDURE users_search_update();
-- Create a GIN index for ts_vectors.
CREATE INDEX search_users ON users USING GIN (tsvectors);

-- Add column to post to store computed ts_vectors.
ALTER TABLE post
ADD COLUMN tsvectors TSVECTOR;
-- Create a function to automatically update ts_vectors.
CREATE FUNCTION post_search_update() RETURNS TRIGGER AS $$
BEGIN
IF TG_OP = 'INSERT' THEN
NEW.tsvectors = to_tsvector('portuguese', NEW.text);
END IF;
IF TG_OP = 'UPDATE' THEN
IF (NEW.text <> OLD.text) THEN
NEW.tsvectors = to_tsvector('portuguese', NEW.text);
END IF;
END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;
-- Create a trigger before insert or update on post
CREATE TRIGGER post_search_update
BEFORE INSERT OR UPDATE ON post
FOR EACH ROW
EXECUTE PROCEDURE post_search_update();
-- Create a GIN index for ts_vectors.
CREATE INDEX search_post ON post USING GIN (tsvectors);

-- Add column to post to store computed ts_vectors.
ALTER TABLE groups
ADD COLUMN tsvectors TSVECTOR;
-- Create a function to automatically update ts_vectors.
CREATE FUNCTION groups_search_update() RETURNS TRIGGER AS $$
BEGIN
IF TG_OP = 'INSERT' THEN
NEW.tsvectors = to_tsvector('portuguese', (SELECT name FROM country WHERE NEW.country_id = country.id));
END IF;
IF TG_OP = 'UPDATE' THEN
IF ((SELECT name FROM country WHERE NEW.country_id = country.id) <> (SELECT name FROM country WHERE OLD.country_id = country.id)) THEN
NEW.tsvectors = to_tsvector('portuguese', (SELECT name FROM country WHERE NEW.country_id = country.id));
END IF;
END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;
-- Create a trigger before insert or update on groups
CREATE TRIGGER groups_search_update
BEFORE INSERT OR UPDATE ON groups
FOR EACH ROW
EXECUTE PROCEDURE groups_search_update();
-- Create a GIN index for ts_vectors.
CREATE INDEX search_groups ON groups USING GIN (tsvectors);

-- Add column to post to store computed ts_vectors.
ALTER TABLE tag
ADD COLUMN tsvectors TSVECTOR;
-- Create a function to automatically update ts_vectors.
CREATE FUNCTION tag_search_update() RETURNS TRIGGER AS $$
BEGIN
IF TG_OP = 'INSERT' THEN
NEW.tsvectors = to_tsvector('portuguese', NEW.hashtag);
END IF;
IF TG_OP = 'UPDATE' THEN
IF (NEW.hashtag <> OLD.hashtag) THEN
NEW.tsvectors = to_tsvector('portuguese', NEW.hashtag);
END IF;
END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;
-- Create a trigger before insert or update on tag
CREATE TRIGGER tag_search_update
BEFORE INSERT OR UPDATE ON tag
FOR EACH ROW
EXECUTE PROCEDURE tag_search_update();
-- Create a GIN index for ts_vectors.
CREATE INDEX search_tag ON tag USING GIN (tsvectors);

-- Triggers


-- TRIGGER03
-- Users may only post to groups they are members of (BR07)

CREATE FUNCTION verify_group_post() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS (SELECT * FROM members WHERE NEW.author_id = user_id AND NEW.group_id = group_id) 
        AND NEW.group_id IS NOT NULL THEN
            RAISE EXCEPTION 'Users may only post to groups they are members of';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_group_post
    BEFORE INSERT OR UPDATE ON post
    FOR EACH ROW
    EXECUTE PROCEDURE verify_group_post();

-- TRIGGER05
-- The owner of a group is automatically a member of that group (BR09)

CREATE FUNCTION group_owner() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO members (user_id, group_id) VALUES (NEW.user_id, NEW.group_id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_owner
    AFTER INSERT ON owner
    FOR EACH ROW
    EXECUTE PROCEDURE group_owner();


-- TRIGGER08
-- Follow requests can only be sent to private profiles (BR12)

CREATE FUNCTION verify_priv_follow_request() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS 
        (SELECT * FROM users WHERE NEW.user2_id = id AND profile_private = false) THEN
            RAISE EXCEPTION 'Follow requests can only be sent to private profiles';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_priv_follow_request
    BEFORE INSERT OR UPDATE ON requests
    FOR EACH ROW
    EXECUTE PROCEDURE verify_priv_follow_request();

------------------------------------- NEW TRIGGERS -------------------------------------

-- TRIGGER NOTIFICATION 1
CREATE FUNCTION follow_request_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO follow_notification (time, notified_id, sender_id, notification_type)
    VALUES (CURRENT_TIMESTAMP, NEW.user2_id, NEW.user1_id, 'follow_request');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER follow_request_notification
AFTER INSERT ON requests
FOR EACH ROW
EXECUTE FUNCTION follow_request_notification();

-- TRIGGER NOTIFICATION 2
CREATE FUNCTION follow_accept_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO follow_notification (time, notified_id, sender_id, notification_type)
    VALUES (CURRENT_TIMESTAMP, NEW.user1_id, NEW.user2_id, 'follow_accept');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER follow_accept_notification
AFTER INSERT ON follows
FOR EACH ROW
EXECUTE FUNCTION follow_accept_notification();

-- TRIGGER NOTIFICATION 4
CREATE FUNCTION group_join_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    owner_id INT;
BEGIN
    FOR owner_id IN SELECT user_id FROM owner WHERE owner.group_id = NEW.group_id
    LOOP
        INSERT INTO group_notification (time, notified_id, sender_id, group_id, notification_type)
        VALUES (CURRENT_TIMESTAMP, owner_id, NEW.user_id, NEW.group_id, 'group_join');
    END LOOP;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_join_notification
AFTER INSERT ON members
FOR EACH ROW
EXECUTE FUNCTION group_join_notification();

/* !!!!!!!!!!!!!!!!!!!!!!TRANSACTION!!!!!!!!!!!!!!!!!!!!!!!!!!!
-- TRIGGER NOTIFICATION 5 (Should we notify the user who left or the owner?)
CREATE FUNCTION group_leave_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO group_notification (time, notified_id, group_id, notification_type)
    VALUES (CURRENT_TIMESTAMP, OLD.user_id, OLD.group_id, 'group_leave');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_leave_notification
BEFORE DELETE ON members
FOR EACH ROW
EXECUTE FUNCTION group_leave_notification();
*/

-- TRIGGER NOTIFICATION 6
CREATE FUNCTION group_ban_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO group_notification (time, notified_id, group_id, notification_type)
    VALUES (CURRENT_TIMESTAMP, NEW.user_id, NEW.group_id, 'group_ban');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_ban_notification
AFTER INSERT ON banned_member
FOR EACH ROW
EXECUTE FUNCTION group_ban_notification();

-- TRIGGER NOTIFICATION 7
CREATE FUNCTION group_owner_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO group_notification (time, notified_id, group_id, notification_type)
    VALUES (CURRENT_TIMESTAMP, NEW.user_id, NEW.group_id, 'group_owner');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_owner_notification
AFTER INSERT ON owner
FOR EACH ROW
EXECUTE FUNCTION group_owner_notification();

-- TRIGGER NOTIFICATION 8
CREATE FUNCTION new_message_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO new_message_notification (time, notified_id, sender_id, message_id)
    VALUES (CURRENT_TIMESTAMP, NEW.receiver_id, NEW.sender_id, NEW.id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER new_message_notification
AFTER INSERT ON message
FOR EACH ROW
EXECUTE FUNCTION new_message_notification();

-- TRIGGER NOTIFICATION 9
CREATE FUNCTION new_comment_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    post_author INT;
BEGIN
    SELECT post.author_id INTO post_author FROM post, comments WHERE comments.post_id = post.id AND comments.id = NEW.id;
    INSERT INTO comment_notification (time, notified_id, sender_id, comment_id, notification_type)
    VALUES (CURRENT_TIMESTAMP, post_author, NEW.author_id, NEW.id, 'new_comment');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER new_comment_notification
AFTER INSERT ON comments
FOR EACH ROW
EXECUTE FUNCTION new_comment_notification();

-- TRIGGER NOTIFICATION 10
CREATE FUNCTION like_comment_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    comment_author INT;
BEGIN
    SELECT comments.author_id INTO comment_author FROM comments WHERE comments.id = NEW.comment_id;
    INSERT INTO comment_notification (time, notified_id, sender_id, comment_id, notification_type)
    VALUES (CURRENT_TIMESTAMP, comment_author, NEW.user_id, NEW.comment_id, 'liked_comment');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER like_comment_notification
AFTER INSERT ON like_comment
FOR EACH ROW
EXECUTE FUNCTION like_comment_notification();

-- TRIGGER NOTIFICATION 11
CREATE FUNCTION mention_comment_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    mentioned_user_id INT;
BEGIN
    FOR mentioned_user_id IN SELECT id FROM users WHERE POSITION(username IN NEW.text)>0 AND POSITION(username IN ('@' || username)) = 2
    LOOP
        INSERT INTO comment_notification (time, notified_id, sender_id, comment_id, notification_type)
        VALUES (CURRENT_TIMESTAMP, mentioned_user_id, NEW.author_id, NEW.id, 'mention_comment');
    END LOOP;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER mention_comment_notification
AFTER INSERT ON comments
FOR EACH ROW
EXECUTE FUNCTION mention_comment_notification();

-- TRIGGER NOTIFICATION 12
CREATE FUNCTION like_post_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    post_author INT;
BEGIN
    SELECT post.author_id INTO post_author FROM post WHERE post.id = NEW.post_id;
    INSERT INTO post_notification (time, notified_id, sender_id, post_id, notification_type)
    VALUES (CURRENT_TIMESTAMP, post_author, NEW.user_id, NEW.post_id, 'new_like');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER like_post_notification
AFTER INSERT ON like_post
FOR EACH ROW
EXECUTE FUNCTION like_post_notification();

-- TRIGGER NOTIFICATION 13
CREATE FUNCTION mention_description_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    mentioned_user_id INT;
    post_author INT;
BEGIN
    SELECT post.author_id INTO post_author FROM post WHERE post.id = NEW.id;
    FOR mentioned_user_id IN SELECT id FROM users WHERE POSITION(username IN NEW.text)>0 AND POSITION(username IN ('@' || username)) = 2
    LOOP
        INSERT INTO post_notification (time, notified_id, sender_id, post_id, notification_type)
        VALUES (CURRENT_TIMESTAMP, post_author, mentioned_user_id, NEW.id, 'mention_description');
    END LOOP;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER mention_description_notification
AFTER INSERT ON post
FOR EACH ROW
EXECUTE FUNCTION mention_description_notification();


-- TRIGGER NOTIFICATION 15
CREATE FUNCTION common_help_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    admin_id INT;
BEGIN
    FOR admin_id IN SELECT user_id FROM admin
    LOOP
        INSERT INTO common_help_notification (time, notified_id, sender_id, common_help_id)
        VALUES (CURRENT_TIMESTAMP, admin_id, NEW.user_id, NEW.id);
    END LOOP;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER common_help_notification
AFTER INSERT ON common_help
FOR EACH ROW
EXECUTE FUNCTION common_help_notification();

-- TRIGGER NOTIFICATION 16
CREATE FUNCTION appeal_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    admin_id INT;
BEGIN
    FOR admin_id IN SELECT user_id FROM admin
    LOOP
        INSERT INTO appeal_notification (time, notified_id, sender_id, unban_request_id)
        VALUES (CURRENT_TIMESTAMP, admin_id, NEW.banned_user_id, NEW.id);
    END LOOP;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER appeal_notification
AFTER INSERT ON unban_request
FOR EACH ROW
EXECUTE FUNCTION appeal_notification();

-- TRIGGER NOTIFICATION 17
CREATE FUNCTION report_notification() RETURNS TRIGGER AS
$BODY$
DECLARE
    admin_id INT;
BEGIN
    FOR admin_id IN SELECT user_id FROM admin
    LOOP
        INSERT INTO report_notification (time, notified_id, sender_id, report_id)
        VALUES (CURRENT_TIMESTAMP, admin_id, NEW.reporter_id, NEW.id);
    END LOOP;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER report_notification
AFTER INSERT ON report
FOR EACH ROW
EXECUTE FUNCTION report_notification();







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
    ('francisco.campos03', 'Francisco Campos', 1, 'francisco.campos@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'images/pfp/pfp-1.jpg', false),
    ('antonio.romao03', 'António Romão', 1, 'antonio.romao@gmail.com', '$2y$10$EpgSBve6Nc.Q.PepTjNp8uJUEyZQjnVfmIlLDHR9LGDZC8/VHWPl.', 'images/pfp/pfp-2.jpg', false),
    ('henrique.pinheiro03', 'Henrique Pinheiro', 1, 'henrique.pinheiro@gmail.com', '$2y$10$/zHdv.sEpPASgf6nXgObI.c.dleL0jqzAEVANmzB.GjFvjvPQ5kYO', 'images/pfp/pfp-3.jpg', true),
    ('jane-doe2346', 'Jane Doe', 2, 'jane.doe@gmail.com', '$2y$10$8dw4v6YscmyD6MG4Jf92BeOpi299ULr/Z57FCjhH6GrCWwhPb8Y7a', 'images/pfp/pfp-4.jpg', true),
    ('hackerman', 'Hackerman', 3, 'hacker.man@hack.hk', '$2y$10$xRQgfBx4DIkNk.Y6R4qOPuACJ8MTOm7I1VTPkF9K5Rh85tMRa7x0.', 'images/pfp/pfp-5.jpg', false),
    ('josefina', 'Josefina dos Santos', 4, 'josefina@gmail.com', '$2y$10$53jvyZTBMRAkoN/KdkA1s.n.QZ.zTXK6406l5ZmGUSslsEH07WkuS', 'images/pfp/pfp-6.jpg', false),
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

INSERT INTO banned (user_id, ban_date)
VALUES
    (5, CURRENT_TIMESTAMP),
    (11, CURRENT_TIMESTAMP);

INSERT INTO unban_request (title, description, date, banned_user_id)
VALUES
    ('Please unban me', 'I only tried to hack you because of FSI I swear', CURRENT_TIMESTAMP, 5),
    ('Be careful...', 'I will try again to wipe out your website', CURRENT_TIMESTAMP, 11);

INSERT INTO common_help (title, description, date, user_id)
VALUES
    ('Account creation', 'I want to create another account', CURRENT_TIMESTAMP, 3),
    ('Password change', 'I want to change my password', CURRENT_TIMESTAMP, 4),
    ('Account deletion', 'I want to delete my account', CURRENT_TIMESTAMP, 6),
    ('Account recovery', 'I want to recover my account', CURRENT_TIMESTAMP, 7);


INSERT INTO faq (answer, question, last_edited, author_id)
VALUES
    ('You can join has many groups as you like! And dont worry, you wont need a VISA', 'Can I join multiple groups?', '2021-05-01 12:00:00', 1),
    ('You can change your password by clicking on the "Change Password" button on the top right corner of the page.', 'How can I change my password?', '2021-05-01 12:00:00', 2);
    

INSERT INTO report (title, description, reporter_id, infractor_id, date)
VALUES
    ('Ban him now', 'He doesnt stop spamming my posts with mean comments!', 4, 6, CURRENT_TIMESTAMP),
    ('I hate him,', 'He stinks and hes a bad person', 6, 4, CURRENT_TIMESTAMP);

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
	
INSERT INTO groups (country_id, description, banner_pic, approved, subgroup_id)
VALUES
    (1, 'Welcome to the land of pastel de nata! SIUUUU', 'images/group/group-1.jpg', true, null),
    (2, 'Welcome to the land of the fredom (or at leat cowboys)', 'images/group/group-2.jpg', true, null),
    (3, 'This is the holy land of Hinduism. We love cows', 'images/group/group-3.jpg', true, null),
    (4, 'Carnaval, cachaça, and good beaches! What more could you ask for?', 'images/group/group-4.jpg', true, null),
    (5, 'This is the land of the rising sun. We love anime', 'images/group/group-5.jpg', true, null),
    (6, 'This is the land of the pyramids. We love cats', 'images/group/group-6.jpg', true, null),
    (7, 'This is the land of K-pop. We love kimchi', 'https://picsum.photos/1000', true, null),
    (8, 'This is the land of the queen. We love tea', 'https://picsum.photos/1000', true, null),
    (9, 'This is the land of the beer. We love beer', 'https://picsum.photos/1000', true, null),
    (10, 'This is the land of the baguette. We love baguettes', 'https://picsum.photos/1000', true, null),
    (11, 'This is the land of the pizza. We love pizza', 'https://picsum.photos/1000', true, null),
    (12, 'This is the land of the bull. We love bull', 'https://picsum.photos/1000', true, null),
    (13, 'This is the land of the panda. We love panda', 'https://picsum.photos/1000', true, null),
    (14, 'This is the land of the vodka. We love vodka', 'https://picsum.photos/1000', true, null),
    (15, 'This is the land of the kangaroo. We love kangaroo', 'https://picsum.photos/1000', true, null),
    (16, 'This is the land of the maple syrup. We love maple syrup', 'https://picsum.photos/1000', true, null),
    (17, 'This is the land of the taco. We love taco', 'https://picsum.photos/1000', true, null),
    (18, 'This is the land of the tulip. We love tulip', 'https://picsum.photos/1000', true, null),
    (19, 'This is the land of the chocolate. We love chocolate', 'https://picsum.photos/1000', true, null),
    (20, 'This is the land of the meatballs. We love meatballs', 'https://picsum.photos/1000', true, null),
    (21, 'This is the land of the viking. We love viking', 'https://picsum.photos/1000', true, null),
    (22, 'This is the land of the mermaid. We love mermaid', 'https://picsum.photos/1000', true, null),
    (23, 'This is the land of the viking. We love viking', 'https://picsum.photos/1000', true, null),
    (24, 'This is the land of the waffle. We love waffle', 'https://picsum.photos/1000', true, null),
    (25, 'This is the land of the schnitzel. We love schnitzel', 'https://picsum.photos/1000', true, null),
    (26, 'This is the land of the olive. We love olive', 'https://picsum.photos/1000', true, null),
    (27, 'This is the land of the kebab. We love kebab', 'https://picsum.photos/1000', true, null),
    (28, 'This is the land of the lion. We love lion', 'https://picsum.photos/1000', true, null),
    (29, 'Esta é a terra invicta <3. Francesinha, dragão, e bifana é o que vos damos!', 'https://picsum.photos/1000', true, 1),
    (30, 'This is the land of the lion. We love lion', 'https://picsum.photos/1000', true, 1),
    (31, 'Capital Nobre de Portugal, verdadeiramente fantástica!', 'https://picsum.photos/1000', true, 1),
    (32, 'The city never sleeps, and so dont I', 'https://picsum.photos/1000', true, 2),
    (33, 'One of the most ICONIC indian cities!', 'https://picsum.photos/1000', null, 3),
    (34, 'Incredible parties, weather, and ', 'https://picsum.photos/1000', null, 4);


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
    (6, 33),
    (7, 34);

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

INSERT INTO banned_member (user_id, group_id)
VALUES
    (10, 31),
    (11, 32);


INSERT INTO post (date, text, media, author_id, group_id)
VALUES
    ('2023-05-01 09:00:00', 'Lisboa', 'images/post/post-1.jpg', 1, 1),
    ('2019-08-21 12:00:00', 'Gladiators!', 'images/post/post-2.jpg', 1, 2),
    ('2018-04-07 14:00:00', 'Invicta', 'images/post/post-3.jpg', 1, 1),
    ('2012-06-09 07:30:00', 'Cup of tea with @francisco.campos03', 'images/post/post-4.jpg', 1, 2),
    ('2021-05-01 15:00:00', 'Tokyo', 'images/post/post-5.jpg', 2, 3),
    ('2023-08-01 10:00:00', 'Pyramids of Giza with @antonio.romao03', 'images/post/post-6.jpg', 2, 2),
    ('2017-11-24 12:02:50', 'Freedom!!!', 'images/post/post-7.jpg', 3, 3),
    ('2015-03-31 16:12:11', 'hola to @lupin', 'images/post/post-8.jpg', 3, 3),
    ('2020-05-06 12:04:34', 'WOW', 'images/post/post-9.jpg', 4, 4);

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
    (4, 1),
    (5, 1),
    (6, 1),
    (7, 1),
    (8, 1),
    (9, 1),
    (10, 2),
    (11, 2),
    (12, 2),
    (13, 2),
    (14, 2),
    (15, 2),
    (16, 2),
    (4, 3),
    (5, 3),
    (6, 3),
    (7, 3),
    (8, 3),
    (9, 3),
    (10, 3),
    (11, 3),
    (12, 3),
    (13, 3),
    (14, 3),
    (15, 3),
    (16, 3),
    (4, 4),
    (5, 4),
    (6, 4),
    (7, 4),
    (8, 4),
    (9, 4),
    (10, 4),
    (11, 4),
    (12, 4),
    (13, 4),
    (14, 4),
    (15, 4),
    (16, 4),
    (4, 5),
    (5, 5),
    (6, 5),
    (7, 5),
    (8, 5),
    (9, 5),
    (10, 5),
    (11, 5),
    (12, 5),
    (13, 5),
    (14, 5),
    (15, 5),
    (16, 5),
    (4, 6),
    (5, 6),
    (6, 6),
    (7, 6),
    (8, 6),
    (9, 6),
    (10, 6),
    (11, 6),
    (12, 6),
    (13, 6),
    (14, 6),
    (15, 6),
    (16, 6),
    (4, 7),
    (5, 7),
    (6, 7),
    (7, 7),
    (8, 7),
    (9, 7),
    (10, 7),
    (11, 7),
    (12, 7),
    (13, 7),
    (14, 7),
    (15, 7),
    (16, 7),
    (4, 8),
    (5, 8),
    (6, 8),
    (7, 8),
    (8, 8),
    (9, 8),
    (10, 8),
    (11, 8),
    (12, 8),
    (13, 8),
    (14, 8),
    (15, 8),
    (16, 8),
    (4, 9),
    (5, 9),
    (6, 9),
    (7, 9),
    (8, 9),
    (9, 9),
    (10, 9),
    (11, 9),
    (12, 9),
    (13, 9),
    (14, 9),
    (15, 9),
    (16, 9);

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
    ('2023-12-20 12:00:00', 'Hello! Welcome to the app!', 1, 2),
    ('2023-12-20 13:00:00', 'Hello! Welcome to the app!', 1, 3),
    ('2023-12-20 14:00:00', 'Hello! Welcome to the app!', 1, 4),
    ('2023-12-20 15:00:00', 'Hi! Thankss', 2, 1),
    ('2023-12-20 16:00:00', 'Heyhey, glad to be here :)', 2, 3),
    ('2023-12-20 17:00:00', 'Whatsapp dude?', 2, 4),
    ('2023-12-20 18:00:00', 'txs', 3, 1),
    ('2023-12-20 19:00:00', 'hi.', 3, 2),
    ('2023-12-20 20:00:00', 'wyd', 3, 4),
    ('2023-12-20 21:00:00', 'Thanks fellow traveller!', 4, 1),
    ('2023-12-20 22:00:00', 'Im incredible bro, and you?', 4, 2),
    ('2023-12-20 23:00:00', 'pull up', 4, 3);

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
