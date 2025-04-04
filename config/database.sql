CREATE DATABASE IF NOT EXISTS game_jam;
USE game_jam;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'jammer' CHECK (role IN ('organizer', 'jammer')),
    profile_pic VARCHAR(255) DEFAULT 'default.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CREATE TABLE jams (
--         id INT PRIMARY KEY AUTO_INCREMENT,
--         title VARCHAR(255) NOT NULL,
--         description TEXT,
--         start_date DATETIME NOT NULL,
--         end_date DATETIME NOT NULL,
--         type ENUM('online', 'physical') DEFAULT 'online',
--         thumbnail VARCHAR(255),
--         organizator_id INT,
--         FOREIGN KEY (organizator_id) REFERENCES users(id)
-- );
--
-- CREATE TABLE applications (
--         id INT PRIMARY KEY AUTO_INCREMENT,
--         jam_id INT,
--         user_id INT,
--         status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
--         applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--         FOREIGN KEY (jam_id) REFERENCES jams(id),
--         FOREIGN KEY (user_id) REFERENCES users(id)
-- );