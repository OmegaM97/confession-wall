CREATE DATABASE IF NOT EXISTS confession_wall;

USE confession_wall;

CREATE TABLE IF NOT EXISTS confessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    confession_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (confession_id)
    REFERENCES confessions(id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS reactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    confession_id INT NOT NULL,
    reaction ENUM('like', 'dislike') NOT NULL,
    FOREIGN KEY (confession_id)
    REFERENCES confessions(id)
    ON DELETE CASCADE
);
