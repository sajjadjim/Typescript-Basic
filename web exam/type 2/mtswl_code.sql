-- Create a database (you can rename if you want)
CREATE DATABASE IF NOT EXISTS simple_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE simple_app;

-- Create a table
CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  sid VARCHAR(50) NOT NULL
);
