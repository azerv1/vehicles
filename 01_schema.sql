-- Create database
CREATE DATABASE IF NOT EXISTS vehicles_db;
USE vehicles_db;

-- Users table
CREATE TABLE IF NOT EXISTS vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model_name VARCHAR(100) NOT NULL,
    type_id INT NOT NULL,
    vehicle_type VARCHAR(100),
    doors INT CHECK (doors>0),
    price INT CHECK (price>=0),
    transmission ENUM("manual","automatic"),
    fuel ENUM("diesel","petrol","hybrid","electric"),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional sample data
INSERT INTO vehicles (model_name,type_id,vehicle_type,doors,price,transmission,fuel)
VALUES
('Nissan Model', 1, 'van', 4, 1000, 'manual', 'diesel'),
('Toyota...', 2, 'sedan', 4, 1800, 'automatic', 'petrol'),
('Volkswagen 2', 2, 'car', 5, 2000, 'manual', 'diesel'),
('Mercedes Sprinter', 1, 'van', 4, 3500, 'manual', 'diesel'),
('BMW car', 3, 'SUV', 5, 5000, 'automatic', 'petrol'),
('Tesla Model 3', 2, 'sedan', 4, 6000, 'automatic', 'electric'),
('Ford Transit', 1, 'van', 3, 2700, 'manual', 'diesel');