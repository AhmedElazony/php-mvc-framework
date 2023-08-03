CREATE TABLE user(
	id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(55) NOT NULL,
    email VARCHAR(55) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE note(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(25) NOT NULL,
    body VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES user(id)
		ON DELETE CASCADE
);

CREATE TABLE comments(
    id INT PRIMARY KEY AUTO_INCREMENT,
    body VARCHAR(255) NOT NULL,
    note_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY(note_id) REFERENCES note(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE
);