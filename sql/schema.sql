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
DROP TABLE IF EXISTS group_creation CASCADE;
DROP TABLE IF EXISTS members CASCADE;
DROP TABLE IF EXISTS owner CASCADE;
DROP TABLE IF EXISTS subgroup CASCADE;
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

DROP TYPE IF EXISTS comment_notification_types;
DROP TYPE IF EXISTS post_notification_types;
DROP TYPE IF EXISTS group_notification_types;
DROP TYPE IF EXISTS follow_notification_types;

DROP FUNCTION IF EXISTS users_search_update CASCADE;
DROP FUNCTION IF EXISTS post_search_update CASCADE;
DROP FUNCTION IF EXISTS groups_search_update CASCADE;
DROP FUNCTION IF EXISTS tag_search_update CASCADE;
DROP FUNCTION IF EXISTS verify_post_likes CASCADE;
DROP FUNCTION IF EXISTS verify_comment_likes CASCADE;
DROP FUNCTION IF EXISTS verify_group_post CASCADE;
DROP FUNCTION IF EXISTS verify_self_follow CASCADE;
DROP FUNCTION IF EXISTS group_owner CASCADE;
DROP FUNCTION IF EXISTS verify_follow_request CASCADE;
DROP FUNCTION IF EXISTS verify_self_follow_request CASCADE;
DROP FUNCTION IF EXISTS verify_priv_follow_request CASCADE;
DROP FUNCTION IF EXISTS verify_group_invite CASCADE;
DROP FUNCTION IF EXISTS delete_group CASCADE;
DROP FUNCTION IF EXISTS delete_post CASCADE;
DROP FUNCTION IF EXISTS delete_comment CASCADE;

-- Types

CREATE TYPE comment_notification_types AS ENUM('mention_comment', 'liked_comment', 'new_comment', 'reply_comment');
CREATE TYPE post_notification_types AS ENUM('new_like', 'mention_description');
CREATE TYPE group_notification_types AS ENUM('group_invite', 'group_join', 'group_leave', 'group_ban', 'group_owner');
CREATE TYPE follow_notification_types AS ENUM('follow_request', 'follow_accept');

-- Create tables

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) UNIQUE,
    name VARCHAR(255),
    country VARCHAR(255),
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
    user_id INT PRIMARY KEY REFERENCES users(id)
);

CREATE TABLE unban_request (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    banned_user_id INT REFERENCES banned(user_id) NOT NULL
);

CREATE TABLE common_help (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
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
    infractor_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE requests (
    user1_id INT REFERENCES users(id) NOT NULL,
    user2_id INT REFERENCES users(id) NOT NULL,
    PRIMARY KEY (user1_id, user2_id)
);

CREATE TABLE follows (
    user1_id INT REFERENCES users(id) NOT NULL,
    user2_id INT REFERENCES users(id) NOT NULL,
    PRIMARY KEY (user1_id, user2_id)
);

CREATE TABLE blocks (
    user1_id INT REFERENCES users(id) NOT NULL,
    user2_id INT REFERENCES users(id) NOT NULL,
    PRIMARY KEY (user1_id, user2_id)
);

CREATE TABLE groups (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    banner_pic TEXT
);

CREATE TABLE subgroup (
    subgroup_id INT REFERENCES groups(id) PRIMARY KEY,
    group_id INT REFERENCES groups(id) NOT NULL
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
    post_id INT REFERENCES post(id) NOT NULL,
    PRIMARY KEY (user_id, post_id)
);

CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    hashtag VARCHAR(255) NOT NULL
);

CREATE TABLE post_tag (
    post_id INT REFERENCES post(id) NOT NULL,
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
    post_id INT REFERENCES post(id) NOT NULL,
    author_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE like_comment (
    user_id INT REFERENCES users(id) NOT NULL,
    comment_id INT REFERENCES comments(id) NOT NULL,
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

CREATE TABLE group_invitation (
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    PRIMARY KEY (user_id, group_id)
);

CREATE TABLE group_creation (
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    PRIMARY KEY (user_id, group_id)
);

CREATE TABLE report_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    admin_id INT REFERENCES admin(user_id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    report_id INT REFERENCES report(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE common_help_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    admin_id INT REFERENCES admin(user_id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    common_help_id INT REFERENCES common_help(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE appeal_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    admin_id INT REFERENCES admin(user_id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    unban_request_id INT REFERENCES unban_request(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE group_creation_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    admin_id INT REFERENCES admin(user_id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE follow_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    notification_type follow_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE new_message_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    message_id INT REFERENCES message(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE comment_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    comment_id INT REFERENCES comments(id) NOT NULL,
    notification_type comment_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE post_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    post_id INT REFERENCES post(id) NOT NULL,
    notification_type post_notification_types NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE group_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
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
NEW.tsvectors = to_tsvector('portuguese', NEW.name);
END IF;
IF TG_OP = 'UPDATE' THEN
IF (NEW.name <> OLD.name) THEN
NEW.tsvectors = to_tsvector('portuguese', NEW.name);
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

-- TRIGGER01
-- Users may only like a post once (BR05)

CREATE FUNCTION verify_post_likes() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM like_post WHERE NEW.user_id = user_id AND NEW.post_id = post_id) THEN
        RAISE EXCEPTION 'Users may only like a post once';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_post_likes
    BEFORE INSERT OR UPDATE ON like_post
    FOR EACH ROW
    EXECUTE PROCEDURE verify_post_likes();

-- TRIGGER02
-- Users may only like a comment once (BR06)

CREATE FUNCTION verify_comment_likes() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM like_comment WHERE NEW.user_id = user_id AND NEW.comment_id = comment_id) THEN
        RAISE EXCEPTION 'Users may only like a comment once';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_comment_likes
    BEFORE INSERT OR UPDATE ON like_comment
    FOR EACH ROW
    EXECUTE PROCEDURE verify_comment_likes();

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

-- TRIGGER04
-- Users cannot follow themselves (BR08)

CREATE FUNCTION verify_self_follow() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.user1_id = NEW.user2_id THEN
        RAISE EXCEPTION 'Users cannot follow themselves';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_self_follow
    BEFORE INSERT OR UPDATE ON follows
    FOR EACH ROW
    EXECUTE PROCEDURE verify_self_follow();

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

-- TRIGGER06
-- Users cannot request to follow someone they are already following (BR10)

CREATE FUNCTION verify_follow_request() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS 
        (SELECT * FROM follows WHERE NEW.user1_id = user1_id AND NEW.user2_id = user2_id) THEN
            RAISE EXCEPTION 'Users cannot request to follow someone they are already following';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_follow_request
    BEFORE INSERT ON requests
    FOR EACH ROW
    EXECUTE PROCEDURE verify_follow_request();

-- TRIGGER07
-- Users cannot request to follow themselves (BR11)

CREATE FUNCTION verify_self_follow_request() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.user1_id = NEW.user2_id THEN
        RAISE EXCEPTION 'Users cannot request to follow themselves';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_self_follow_request
    BEFORE INSERT OR UPDATE ON requests
    FOR EACH ROW
    EXECUTE PROCEDURE verify_self_follow_request();

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

-- TRIGGER10
-- When deleting a group it also deletes its subgroups, posts and notifications (BR15)

CREATE FUNCTION delete_group() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM subgroup WHERE OLD.id = subgroup.group_id;
    DELETE FROM post WHERE OLD.id = post.group_id;
    DELETE FROM group_invitation WHERE OLD.id = group_invitation.group_id;
    DELETE FROM group_notification WHERE OLD.id = group_notification.group_id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_group
    BEFORE DELETE ON groups
    FOR EACH ROW
    EXECUTE PROCEDURE delete_group();

-- TRIGGER11
-- When deleting a post it also deletes its comments, likes and notifications (BR16)

CREATE FUNCTION delete_post() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM comments WHERE OLD.id = comments.post_id;
    DELETE FROM like_post WHERE OLD.id = like_post.post_id;
    DELETE FROM post_notification WHERE OLD.id = post_notification.post_id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_post
    BEFORE DELETE ON post
    FOR EACH ROW
    EXECUTE PROCEDURE delete_post();

-- TRIGGER12
-- When deleting a comment it also deletes its likes and notifications (BR17)

CREATE FUNCTION delete_comment() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM like_comment WHERE OLD.id = like_comment.comment_id;
    DELETE FROM comment_notification WHERE OLD.id = comment_notification.comment_id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_comment
    BEFORE DELETE ON comments
    FOR EACH ROW
    EXECUTE PROCEDURE delete_comment();
