CREATE DATABASE datagym;
use datagym;
CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
CREATE TABLE exercises (
    id int NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT,
    id_user int(255) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE actions (
    id int NOT NULL AUTO_INCREMENT,
    repetitions int(255),
    weight int(255),
    rest int(255),
    description TEXT,
    id_exercise int(255) NOT NULL,
    id_user int(255) NOT NULL,
    date DATE,
    PRIMARY KEY(id),
    FOREIGN KEY (id_exercise) REFERENCES exercises(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);