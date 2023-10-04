-- Creates IS330 project tables

-- Creates and uses tracker databse
DROP DATABASE IF EXISTS tracker;
CREATE DATABASE IF NOT EXISTS tracker;
USE tracker;

-- Removes old versions of tables

-- DROP TABLE IF EXISTS users;
-- DROP TABLE IF EXISTS classification;
-- DROP TABLE IF EXISTS impact;
-- DROP TABLE IF EXISTS location;
-- DROP TABLE IF EXISTS reports;



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
    
CREATE TABLE classification (
	classification_id INT PRIMARY KEY,
    ClassificationName ENUM('Damage','Concern','Noted')
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
    IncidentDate DATE,
    CreatedDate DATE,
    classification_id INT,
    FOREIGN KEY (classification_id) REFERENCES classification(classification_id),
    impact_id INT,
    FOREIGN KEY (impact_id) REFERENCES impact(impact_id),
    location_id INT,
    FOREIGN KEY (location_id) REFERENCES location(location_id),
    Description VARCHAR(150),
    user_id INT,
	FOREIGN KEY (user_id) REFERENCES users(user_id)
    )