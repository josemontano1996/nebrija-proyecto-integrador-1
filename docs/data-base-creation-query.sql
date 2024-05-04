CREATE DATABASE proyecto_integrador_1;
USE proyecto_integrador_1;

-- Create tables without foreign key constraints

CREATE TABLE users (
  id CHAR(36) PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(60) NOT NULL,
  name VARCHAR(150) NULL,
  role VARCHAR(45) NULL
);

CREATE TABLE addresses (
  id CHAR(36) PRIMARY KEY,
  street VARCHAR(100) NOT NULL,
  postal VARCHAR(10) NOT NULL,
  city VARCHAR(50) NOT NULL
);

CREATE TABLE products (
  id CHAR(36) PRIMARY KEY,
  name VARCHAR(150) NOT NULL UNIQUE,
  description VARCHAR(500) NOT NULL,
  price FLOAT NOT NULL,
  min_servings TINYINT NULL DEFAULT 0,
  type VARCHAR(45) NOT NULL, 
  image_url VARCHAR(255) NOT NULL
); 

CREATE TABLE orders (
  id CHAR(36) PRIMARY KEY,
  user_id CHAR(36) NOT NULL,
  user_name VARCHAR(50) NOT NULL,
  address_id CHAR(36) NOT NULL,
  status VARCHAR(50) NOT NULL,
  products JSON NOT NULL,
  total_price FLOAT NOT NULL,
  delivery_date TIMESTAMP NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE carts (
  user_id CHAR(36) PRIMARY KEY,
  products JSON,
  FOREIGN KEY (user_id) REFERENCES users(id)
); 

CREATE TABLE user_management (
  owner_id CHAR(36),
  user_id CHAR(36),
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  previous_role VARCHAR(50) NULL,
  new_role VARCHAR(50) NULL,
  PRIMARY KEY (owner_id, user_id, date) -- Composite primary key
);

-- Add foreign keys using ALTER TABLE

ALTER TABLE orders
  ADD CONSTRAINT fk_orders_user
  FOREIGN KEY (user_id) REFERENCES users(id),
  ADD CONSTRAINT fk_orders_address
  FOREIGN KEY (address_id) REFERENCES addresses(id);