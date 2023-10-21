create schema if not exists lbaw2346;

SET DateStyle TO European;

-- Drop existing tables if they exist

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
DROP TABLE IF EXISTS members CASCADE;
DROP TABLE IF EXISTS owner CASCADE;
DROP TABLE IF EXISTS subgroup CASCADE;
DROP TABLE IF EXISTS groups CASCADE;
DROP TABLE IF EXISTS like_comment CASCADE;
DROP TABLE IF EXISTS comments CASCADE
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
    profile_photo VARCHAR(255),
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
    description VARCHAR(255) NOT NULL,
    banned_user_id INT REFERENCES banned(id) NOT NULL
);

CREATE TABLE common_help (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE faq (
    id SERIAL PRIMARY KEY,
    answer VARCHAR(255) NOT NULL,
    question VARCHAR(255) UNIQUE NOT NULL,
    last_edited DATE NOT NULL CHECK (last_edited <= now()),
    author_id INT REFERENCES admin(id)
);

CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    evaluater_id INT REFERENCES admin(id) NOT NULL,
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
    user2_id INT REFERENCES users(id),
    PRIMARY KEY (user1_id, user2_id)
);

CREATE TABLE blocks (
    user1_id INT REFERENCES users(id) NOT NULL,
    user2_id INT REFERENCES users(id) NOT NULL,
    PRIMARY KEY (user1_id, user2_id)
);

CREATE TABLE like_post (
    user_id INT REFERENCES users(id) NOT NULL,
    post_id INT REFERENCES post(id) NOT NULL,
    PRIMARY KEY (user_id, post_id)
);

CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    date DATE NOT NULL CHECK (date <= now()),
    text VARCHAR(255),
    media VARCHAR(255),
    author_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    edited BOOLEAN DEFAULT false
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
    content VARCHAR(255) NOT NULL,
    sender_id INT REFERENCES users(id) NOT NULL,
    receiver_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE comments (
    id SERIAL PRIMARY KEY,
    text VARCHAR(255) NOT NULL,
    date DATE NOT NULL CHECK (date <= now()),
    post_id INT REFERENCES post(id) NOT NULL,
    author_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE like_comment (
    user_id INT REFERENCES users(id) NOT NULL,
    comment_id INT REFERENCES comments(id),
    PRIMARY KEY (user_id, comment_id) NOT NULL
);

CREATE TABLE groups (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    banner_pic VARCHAR(255)
);

CREATE TABLE subgroup (
    subgroup_id INT REFERENCES groups(id) PRIMARY KEY,
    group_id INT REFERENCES groups(id) NOT NULL
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

CREATE TABLE report_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    admin_id INT REFERENCES admin(id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    report_id INT REFERENCES report(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE common_help_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    admin_id INT REFERENCES admin(id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    common_help_id INT REFERENCES common_help(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE appeal_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    admin_id INT REFERENCES admin(id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    unban_request_id INT REFERENCES unban_request(id) NOT NULL,
    opened BOOLEAN DEFAULT false
);

CREATE TABLE group_creation_notification (
    id SERIAL PRIMARY KEY,
    time DATE NOT NULL CHECK (time <= now()),
    admin_id INT REFERENCES admin(id) NOT NULL,
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

-- Indexes

-- Triggers

-- TRIGGER01
-- Users may only like a post once (BR05)

CREATE FUNCTION verify_post_likes() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM like_post WHERE NEW.user_id = user_id AND NEW.post_id = post_id) THEN
        RAISE EXCEPTION "Users may only like a post once";
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
        RAISE EXCEPTION "Users may only like a comment once";
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
            RAISE EXCEPTION "Users may only post to groups they are members of";
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
        RAISE EXCEPTION "Users cannot follow themselves";
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
    INSERT INTO members (user_id, group_id) VALUES (NEW.user_id, NEW.group_id)
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER group_owner
    AFTER INSERT ON owner
    FOR EACH ROW
    EXECUTE PROCEDURE group_owner;

-- TRIGGER06
-- Users cannot request to follow someone they are already following (BR10)

CREATE FUNCTION verify_follow_request() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS 
        (SELECT * FROM follows WHERE NEW.user1_id = user1_id AND NEW.user2_id = user2_id) THEN
            RAISE EXCEPTION "Users cannot request to follow someone they are already following";
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
        RAISE EXCEPTION "Users cannot request to follow themselves";
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
            RAISE EXCEPTION "Follow requests can only be sent to private profiles";
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_follow_request
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
            RAISE EXCEPTION "Users cannot be invited to join a group they are already a part of";
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_group_invite
    BEFORE INSERT ON group_invitation
    FOR EACH ROW
    EXECUTE PROCEDURE verify_group_invite();
