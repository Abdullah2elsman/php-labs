# Lab 3: User Management System with Normalized MySQL Database

A complete PHP-based user management system using PDO, MySQL database with proper normalization and many-to-many relationships.

## Features

- ✅ User registration with dynamic skills loading
- ✅ Normalized database structure with separate skills table
- ✅ Many-to-many relationship between users and skills
- ✅ Enhanced user listing with skills display
- ✅ Detailed user view with proper formatting
- ✅ Secure delete with CASCADE constraints
- ✅ Transaction support for data integrity
- ✅ Secure password hashing and SQL injection protection

## Database Structure

### Tables:
1. **users** - Main user information
2. **skills** - Available skills (normalized)
3. **user_skills** - Junction table (many-to-many relationship)

### Relationships:
- One user can have many skills
- One skill can belong to many users
- Foreign key constraints with CASCADE DELETE

## Setup Instructions

### 1. Database Setup
Run the database setup script:
```
http://localhost/lab3/setup_database.php
```

This will create:
- Database: `user_management`
- Tables: `users`, `skills`, `user_skills`
- Default skills: PHP, J2SE, MySQL, PostgreSQL, JavaScript, Python, Java, C++

### 2. Configuration
Edit `config.php` if needed to match your database settings:
- Host: localhost (default)
- Database: user_management
- Username: root (default)
- Password: (empty by default)

### 3. Usage
- **Registration**: `http://localhost/lab3/registeration.php`
- **User List**: `http://localhost/lab3/list.php`

## Files Structure

```
lab3/
├── config.php              # Database configuration
├── setup_database.php      # Database setup script
├── registeration.php       # User registration form (dynamic skills)
├── save.php                # Process registration (with transactions)
├── list.php                # Display users with skills
├── view.php                # Detailed user view
├── delete.php              # Delete user (CASCADE handles skills)
└── README.md               # This file
```

## Database Schema

```sql
-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    country VARCHAR(50) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    department VARCHAR(50) NOT NULL,
    username VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Skills table
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Junction table for many-to-many relationship
CREATE TABLE user_skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    skill_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skills(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_skill (user_id, skill_id)
);
```

## Key Improvements

1. **Normalized Database**: Skills are stored in separate table
2. **Many-to-Many Relationship**: Proper junction table implementation
3. **Dynamic Skills Loading**: Skills are loaded from database in registration form
4. **Transaction Support**: Ensures data integrity during user creation
5. **CASCADE DELETE**: Automatic cleanup of related records
6. **Enhanced UI**: Better styling and user experience
7. **Proper Error Handling**: Comprehensive error messages and validation