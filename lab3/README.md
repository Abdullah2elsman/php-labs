# Lab 3: User Management System with MySQL Database

A complete PHP-based user management system using PDO and MySQL database.

## Features

- ✅ User registration with form validation
- ✅ User listing with enhanced UI
- ✅ View detailed user information
- ✅ Delete users with confirmation
- ✅ Secure password hashing
- ✅ PDO prepared statements for security
- ✅ Error handling and user feedback

## Setup Instructions

### 1. Database Setup
Run the database setup script first:
```
http://localhost/lab3/setup_database.php
```

This will create:
- Database: `user_management`
- Table: `users` with all required fields

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
├── registeration.php       # User registration form
├── save.php                # Process registration data
├── list.php                # Display all users
├── view.php                # View user details
├── delete.php              # Delete user functionality
└── README.md               # This file
```

## Security Features

- **Password Hashing**: Uses PHP's `password_hash()` function
- **SQL Injection Protection**: PDO prepared statements
- **XSS Protection**: `htmlspecialchars()` for output
- **Input Validation**: Both client-side and server-side validation

## Database Schema

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    country VARCHAR(50) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    skills TEXT,
    department VARCHAR(50) NOT NULL,
    username VARCHAR(100),
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```