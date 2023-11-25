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
DROP TABLE IF EXISTS group_invitation CASCADE;
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
DROP FUNCTION IF EXISTS verify_group_invite CASCADE;
DROP FUNCTION IF EXISTS follow_request_notification CASCADE;
DROP FUNCTION IF EXISTS follow_accept_notification CASCADE;
DROP FUNCTION IF EXISTS group_invite_notification CASCADE;
DROP FUNCTION IF EXISTS group_join_notification CASCADE;
DROP FUNCTION IF EXISTS group_leave_notification CASCADE;
DROP FUNCTION IF EXISTS group_ban_notification CASCADE;
DROP FUNCTION IF EXISTS group_owner_notification CASCADE;
DROP FUNCTION IF EXISTS new_message_notification CASCADE;
DROP FUNCTION IF EXISTS new_comment_notification CASCADE;
DROP FUNCTION IF EXISTS like_comment_notification CASCADE;
DROP FUNCTION IF EXISTS mention_comment_notification CASCADE;
DROP FUNCTION IF EXISTS like_post_notification CASCADE;
DROP FUNCTION IF EXISTS mention_description_notification CASCADE;
DROP FUNCTION IF EXISTS group_creation_notification CASCADE;
DROP FUNCTION IF EXISTS common_help_notification CASCADE;
DROP FUNCTION IF EXISTS appeal_notification CASCADE;
DROP FUNCTION IF EXISTS report_notification CASCADE;


-- Types

CREATE TYPE comment_notification_types AS ENUM('mention_comment', 'liked_comment', 'new_comment');
CREATE TYPE post_notification_types AS ENUM('new_like', 'mention_description');
CREATE TYPE group_notification_types AS ENUM('group_invite', 'group_join', 'group_leave', 'group_ban', 'group_owner');
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
    ban_date DATE NOT NULL CHECK (ban_date <= now())
);

CREATE TABLE unban_request (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL CHECK (date <= now()),
    accept_appeal BOOLEAN DEFAULT NULL,
    banned_user_id INT REFERENCES banned(user_id) NOT NULL
);

CREATE TABLE common_help (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL CHECK (date <= now()),
    user_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE faq (
    id SERIAL PRIMARY KEY,
    answer TEXT NOT NULL,
    question VARCHAR(255) UNIQUE NOT NULL,
    last_edited DATE NOT NULL CHECK (last_edited <= now()),
    author_id INT REFERENCES admin(user_id)
);

CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    description TEXT NOT NULL,
    evaluater_id INT REFERENCES admin(user_id) NOT NULL,
    reporter_id INT REFERENCES users(id) NOT NULL,
    infractor_id INT REFERENCES users(id) NOT NULL,
    date DATE NOT NULL CHECK (date <= now()),
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
    date DATE NOT NULL CHECK (date <= now()),
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
    time DATE NOT NULL CHECK (time <= now()),
    content TEXT NOT NULL,
    sender_id INT REFERENCES users(id) NOT NULL,
    receiver_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE comments (
    id SERIAL PRIMARY KEY,
    text TEXT NOT NULL,
    date DATE NOT NULL CHECK (date <= now()),
    post_id INT REFERENCES post(id) ON DELETE CASCADE,
    author_id INT REFERENCES users(id) NOT NULL
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

CREATE TABLE group_invitation (
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    PRIMARY KEY (user_id, group_id)
);

CREATE TABLE report_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES admin(user_id) NOT NULL,
    report_id INT REFERENCES report(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE common_help_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES admin(user_id) NOT NULL,
    common_help_id INT REFERENCES common_help(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE appeal_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES admin(user_id) NOT NULL,
    unban_request_id INT REFERENCES unban_request(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE group_creation_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES admin(user_id) NOT NULL,
    group_id INT REFERENCES groups(id) ON DELETE CASCADE,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE follow_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
    notification_type follow_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE new_message_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
    message_id INT REFERENCES message(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE comment_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
    comment_id INT REFERENCES comments(id) ON DELETE CASCADE,
    notification_type comment_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE post_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
    post_id INT REFERENCES post(id) ON DELETE CASCADE,
    notification_type post_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE group_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    notified_id INT REFERENCES users(id) NOT NULL,
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

-- TRIGGER09
-- Users cannot be invited to join a group they are already a part of (BR13)

CREATE FUNCTION verify_group_invite() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS 
        (SELECT * FROM members WHERE NEW.user_id = user_id AND NEW.group_id = group_id) THEN
            RAISE EXCEPTION 'Users cannot be invited to join a group they are already a part of';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_group_invite
    BEFORE INSERT ON group_invitation
    FOR EACH ROW
    EXECUTE PROCEDURE verify_group_invite();

------------------------------------- NEW TRIGGERS -------------------------------------

-- TRIGGER NOTIFICATION 1
CREATE FUNCTION follow_request_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO follow_notification (time, notified_id, notification_type)
    VALUES (CURRENT_DATE, NEW.user2_id, 'follow_request');
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
    INSERT INTO follow_notification (time, notified_id, notification_type)
    VALUES (CURRENT_DATE, NEW.user1_id, 'follow_accept');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER follow_accept_notification
AFTER INSERT ON follows
FOR EACH ROW
EXECUTE FUNCTION follow_accept_notification();

-- TRIGGER NOTIFICATION 3
CREATE FUNCTION group_invite_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO group_notification (time, notified_id, group_id, notification_type)
    VALUES (CURRENT_DATE, NEW.user_id, NEW.group_id, 'group_invite');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_invite_notification
AFTER INSERT ON group_invitation
FOR EACH ROW
EXECUTE FUNCTION group_invite_notification();

-- TRIGGER NOTIFICATION 4
CREATE FUNCTION group_join_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO group_notification (time, notified_id, group_id, notification_type)
    VALUES (CURRENT_DATE, NEW.user_id, NEW.group_id, 'group_join');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_join_notification
AFTER INSERT ON members
FOR EACH ROW
EXECUTE FUNCTION group_join_notification();

-- TRIGGER NOTIFICATION 5 (Should we notify the user who left or the owner?)
CREATE FUNCTION group_leave_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO group_notification (time, notified_id, group_id, notification_type)
    VALUES (CURRENT_DATE, NEW.user_id, NEW.group_id, 'group_leave');
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_leave_notification
AFTER DELETE ON members
FOR EACH ROW
EXECUTE FUNCTION group_leave_notification();

-- TRIGGER NOTIFICATION 6
CREATE FUNCTION group_ban_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO group_notification (time, notified_id, group_id, notification_type)
    VALUES (CURRENT_DATE, NEW.user_id, NEW.group_id, 'group_ban');
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
    VALUES (CURRENT_DATE, NEW.user_id, NEW.group_id, 'group_owner');
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
    INSERT INTO new_message_notification (time, notified_id, message_id)
    VALUES (CURRENT_DATE, NEW.receiver_id, NEW.id);
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
BEGIN
    INSERT INTO comment_notification (time, notified_id, comment_id, notification_type)
    VALUES (CURRENT_DATE, NEW.author_id, NEW.id, 'new_comment');
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
BEGIN
    INSERT INTO comment_notification (time, notified_id, comment_id, notification_type)
    VALUES (CURRENT_DATE, NEW.user_id, NEW.comment_id, 'liked_comment');
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
    username_pattern TEXT := '@[a-zA-Z0-9_]+';
BEGIN
    FOR mentioned_user_id IN SELECT id FROM users WHERE regexp_matches(NEW.text, username_pattern) IS NOT NULL
    LOOP
        INSERT INTO comment_notification (time, notified_id, comment_id, notification_type)
        VALUES (CURRENT_DATE, mentioned_user_id, NEW.id, 'mention_comment');
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
BEGIN
    INSERT INTO post_notification (time, notified_id, post_id, notification_type)
    VALUES (CURRENT_DATE, NEW.user_id, NEW.post_id, 'new_like');
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
    username_pattern TEXT := '@[a-zA-Z0-9_]+';
BEGIN
    FOR mentioned_user_id IN SELECT id FROM users WHERE regexp_matches(NEW.text, username_pattern) IS NOT NULL
    LOOP
        INSERT INTO post_notification (time, notified_id, post_id, notification_type)
        VALUES (CURRENT_DATE, mentioned_user_id, NEW.id, 'mention_description');
    END LOOP;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER mention_description_notification
AFTER INSERT ON post
FOR EACH ROW
EXECUTE FUNCTION mention_description_notification();

-- TRIGGER NOTIFICATION 14
CREATE FUNCTION group_creation_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO group_creation_notification (time, notified_id, group_id)
    VALUES (CURRENT_DATE, (SELECT user_id FROM admin ORDER BY random() LIMIT 1), NEW.id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_creation_notification
AFTER INSERT ON groups
FOR EACH ROW
EXECUTE FUNCTION group_creation_notification();

-- TRIGGER NOTIFICATION 15
CREATE FUNCTION common_help_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO common_help_notification (time, notified_id, common_help_id)
    VALUES (CURRENT_DATE, (SELECT user_id FROM admin ORDER BY random() LIMIT 1), NEW.id);
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
BEGIN
    INSERT INTO appeal_notification (time, notified_id, unban_request_id)
    VALUES (CURRENT_DATE, (SELECT user_id FROM admin ORDER BY random() LIMIT 1), NEW.id);
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
BEGIN
    INSERT INTO report_notification (time, notified_id, report_id)
    VALUES (CURRENT_DATE, (SELECT user_id FROM admin ORDER BY random() LIMIT 1), NEW.id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER report_notification
AFTER INSERT ON report
FOR EACH ROW
EXECUTE FUNCTION report_notification();
