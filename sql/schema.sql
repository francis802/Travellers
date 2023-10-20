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
DROP TABLE IF EXISTS member CASCADE;
DROP TABLE IF EXISTS owner CASCADE;
DROP TABLE IF EXISTS subgroup CASCADE;
DROP TABLE IF EXISTS groups CASCADE;
DROP TABLE IF EXISTS like_comment CASCADE;
DROP TABLE IF EXISTS comment CASCADE
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
    username VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255),
    country VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255),
    profile_photo VARCHAR(255),
    profile_private BOOLEAN DEFAULT false,
    is_deleted BOOLEAN DEFAULT false
);

CREATE TABLE admin (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id)
);

CREATE TABLE banned (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id)
);

CREATE TABLE unban_request (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    banned_user_id INT REFERENCES banned(id)
);

CREATE TABLE common_help (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    user_id INT REFERENCES users(id)
);

CREATE TABLE faq (
    id SERIAL PRIMARY KEY,
    answer VARCHAR(255) NOT NULL,
    question VARCHAR(255) UNIQUE NOT NULL,
    last_edited DATE CHECK (last_edited <= now()),
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
    user1_id INT REFERENCES users(id),
    user2_id INT REFERENCES users(id)
);

CREATE TABLE follows (
    user1_id INT REFERENCES users(id),
    user2_id INT REFERENCES users(id)
);

CREATE TABLE blocks (
    user1_id INT REFERENCES users(id),
    user2_id INT REFERENCES users(id)
);

CREATE TABLE like_post (
    user_id INT REFERENCES users(id),
    post_id INT REFERENCES post(id)
);

CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    date DATE CHECK (date <= now()),
    edited BOOLEAN DEFAULT false,
    text VARCHAR(255) NOT NULL,
    media VARCHAR(255),
    author_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id)
);

CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    hashtag VARCHAR(255) NOT NULL
);

CREATE TABLE post_tag (
    post_id INT REFERENCES post(id),
    tag_id INT REFERENCES tag(id)
);

CREATE TABLE message (
    id SERIAL PRIMARY KEY,
    time DATE CHECK (time <= now()),
    content VARCHAR(255) NOT NULL,
    sender_id INT REFERENCES users(id) NOT NULL,
    receiver_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    text VARCHAR(255) NOT NULL,
    date DATE CHECK (date <= now()),
    post_id INT REFERENCES post(id) NOT NULL,
    author_id INT REFERENCES users(id) NOT NULL
);

CREATE TABLE like_comment (
    user_id INT REFERENCES users(id),
    comment_id INT REFERENCES comment(id)
);

CREATE TABLE groups (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    banner_pic VARCHAR(255)
);

CREATE TABLE subgroup (
    id SERIAL PRIMARY KEY,
    group_id INT REFERENCES groups(id) NOT NULL
);

CREATE TABLE owner (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL
);

CREATE TABLE member (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL
);

CREATE TABLE group_invitation (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL
);

CREATE TABLE report_notification (
    id SERIAL PRIMARY KEY,
    opened BOOLEAN DEFAULT false,
    time DATE CHECK (time <= now()),
    admin_id INT REFERENCES admin(id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    report_id INT REFERENCES report(id) NOT NULL
);

CREATE TABLE common_help_notification (
    id SERIAL PRIMARY KEY,
    opened BOOLEAN DEFAULT false,
    time DATE CHECK (time <= now()),
    admin_id INT REFERENCES admin(id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    common_help_id INT REFERENCES common_help(id) NOT NULL
);

CREATE TABLE appeal_notification (
    id SERIAL PRIMARY KEY,
    opened BOOLEAN DEFAULT false,
    time DATE CHECK (time <= now()),
    admin_id INT REFERENCES admin(id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    unban_request_id INT REFERENCES unban_request(id) NOT NULL
);

CREATE TABLE group_creation_notification (
    id SERIAL PRIMARY KEY,
    opened BOOLEAN DEFAULT false,
    time DATE CHECK (time <= now()),
    admin_id INT REFERENCES admin(id) NOT NULL,
    user_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL
);

CREATE TABLE follow_notification (
    id SERIAL PRIMARY KEY,
    opened BOOLEAN DEFAULT false,
    time DATE CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    notification_type follow_notification_types NOT NULL
);

CREATE TABLE new_message_notification (
    id SERIAL PRIMARY KEY,
    opened BOOLEAN DEFAULT false,
    time DATE CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    message_id INT REFERENCES message(id) NOT NULL
);

CREATE TABLE comment_notification (
    id SERIAL PRIMARY KEY,
    opened BOOLEAN DEFAULT false,
    time DATE CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    comment_id INT REFERENCES comment(id) NOT NULL,
    notification_type comment_notification_types NOT NULL
);

CREATE TABLE post_notification (
    id SERIAL PRIMARY KEY,
    opened BOOLEAN DEFAULT false,
    time DATE CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    post_id INT REFERENCES post(id) NOT NULL,
    notification_type post_notification_types NOT NULL
);

CREATE TABLE group_notification (
    id SERIAL PRIMARY KEY,
    opened BOOLEAN DEFAULT false,
    time DATE CHECK (time <= now()),
    sender_id INT REFERENCES users(id) NOT NULL,
    notified_id INT REFERENCES users(id) NOT NULL,
    group_id INT REFERENCES groups(id) NOT NULL,
    notification_type group_notification_types NOT NULL
);