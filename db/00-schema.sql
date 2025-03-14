-- User table
CREATE TABLE IF NOT EXISTS User (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    passwordHash VARCHAR(255) NOT NULL,
    isActiveted BOOLEAN NOT NULL DEFAULT FALSE,
    activationHash VARCHAR(255) NOT NULL
);

-- Image
CREATE TABLE IF NOT EXISTS Image (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userId INT NOT NULL,
    imagePath VARCHAR(255) NOT NULL,
    createdAt DATETIME NOT NULL,
    FOREIGN KEY (userId) REFERENCES User(id) ON DELETE CASCADE
);

-- Like
CREATE TABLE IF NOT EXISTS `Like` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    imageId INT NOT NULL,
    userId INT NOT NULL,
    FOREIGN KEY (imageId) REFERENCES Image(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES User(id) ON DELETE CASCADE
);

-- Comment
CREATE TABLE IF NOT EXISTS Comment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    imageId INT NOT NULL,
    userId INT NOT NULL,
    content TEXT NOT NULL,
    createdAt DATETIME NOT NULL,
    FOREIGN KEY (imageId) REFERENCES Image(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES User(id) ON DELETE CASCADE
);

-- Sticker
CREATE TABLE IF NOT EXISTS Sticker (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imagePath VARCHAR(255) NOT NULL
);

-- Like
CREATE TABLE IF NOT EXISTS `Like` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    imageId INT NOT NULL,
    userId INT NOT NULL,
    FOREIGN KEY (imageId) REFERENCES Image(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES User(id) ON DELETE CASCADE,
    UNIQUE (imageId, userId)  -- Ensure a user can like an image only once
);
