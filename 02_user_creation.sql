CREATE DATABASE IF NOT EXISTS vehicles_db;
CREATE USER IF NOT EXISTS 'user'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON vehicles_db.* TO 'user'@'localhost';
FLUSH PRIVILEGES;