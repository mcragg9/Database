-- Provides data for init tables

-- Creates and uses tracker databse
CREATE DATABASE IF NOT EXISTS tracker;
USE tracker;

-- Removes old versions of tables
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS type;
DROP TABLE IF EXISTS impact;
DROP TABLE IF EXISTS location;


-- Users tables, stores people and relevant info
CREATE TABLE users (
	user_id INT PRIMARY KEY,
    LastName VARCHAR(50) NOT NULL,
    FirstName VARCHAR(50) NOT NULL,
    Rights ENUM('Admin','Input'),
    Status ENUM('Active','Innactive'),
    DateAdded DATE,
    hashed_password VARCHAR(64),
    salt VARCHAR(32)
    );
    
CREATE TABLE type (
	type_id INT PRIMARY KEY,
    TypeName ENUM('Damage','Concern','Noted')
    );
    
CREATE TABLE impact (
	impact_id INT PRIMARY KEY,
    Impact ENUM('Severe','Significant','Problem','Recoverable')
    );
    
CREATE TABLE location (
	location_id INT PRIMARY KEY,
    LocationDescription VARCHAR(50) NOT NULL
    );

CREATE TABLE reports (
	reports_id INT PRIMARY KEY,
    