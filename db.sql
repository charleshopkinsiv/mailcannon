CREATE DATABASE mc;

USE mc;

CREATE TABLE message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(63) NOT NULL DEFAULT '',
    body TEXT NOT NULL DEFAULT '',
    template VARCHAR(63) NOT NULL DEFAULT ''
);

CREATE TABLE address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(63) NOT NULL DEFAULT '',
    domain VARCHAR(63) NOT NULL DEFAULT '',
    name VARCHAR(63) NOT NULL DEFAULT ''
);

CREATE TABLE address_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(63) NOT NULL DEFAULT ''
);

CREATE TABLE address_list_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    address_list_id INT NOT NULL DEFAULT 0,
    address_id INT NOT NULL DEFAULT 0,
    FOREIGN KEY (address_list_id) REFERENCES address_list(id),
    FOREIGN KEY (address_id) REFERENCES address(id)
);

CREATE TABLE send_log (

);
