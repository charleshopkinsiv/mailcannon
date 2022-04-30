USE mc;

CREATE TABLE message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(63) NOT NULL DEFAULT '',
    body TEXT NOT NULL,
    template VARCHAR(63) NOT NULL DEFAULT ''
);

CREATE TABLE address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(63) NOT NULL DEFAULT '',
    domain VARCHAR(63) NOT NULL DEFAULT '',
    name VARCHAR(63) NOT NULL DEFAULT ''
);

CREATE TABLE address_lists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(63) NOT NULL DEFAULT ''
);

CREATE TABLE address_list_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    address_list INT NOT NULL DEFAULT 0,
    address INT NOT NULL DEFAULT 0,
    FOREIGN KEY (address_list) REFERENCES address_list(id),
    FOREIGN KEY (address) REFERENCES address(id)
);

CREATE TABLE send_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    datetime_sent DATETIME NOT NULL DEFAULT NOW(),
    address INT NOT NULL DEFAULT 0,
    message INT NOT NULL DEFAULT 0,
    FOREIGN KEY (address) REFERENCES address(id),
    FOREIGN KEY (message) REFERENCES message(id)
);
