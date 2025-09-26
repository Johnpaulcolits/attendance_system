database syntax

database
CREATE DATABASE database;

for users
CREATE TABLE users (
    id varchar(255) PRIMARY KEY,
    idnumber VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    fname VARCHAR(50) NOT NULL,
    mname CHAR(1),
    lname VARCHAR(50) NOT NULL,
    year VARCHAR(50) NOT NULL,
    course VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    googleid VARCHAR(100) DEFAULT NULL,
    role VARCHAR(20) DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


