# User Management System with MySQL

A PHP-based user management system using PDO and MySQL database.

## Features

- User registration with form validation
- User listing with pagination-ready structure
- View user details
- Delete users with confirmation
- Secure password hashing
- PDO prepared statements for security

## Database Setup

1. Make sure MySQL is running on your system
2. Run the database setup script:
   ```
   http://localhost/setup_database.php
   ```
3. This will create:
   - Database: `user_management`
   - Table: `users` with all required fields

## Configuration

Edit `config.php` to match your database settings:
- Host: localhost (default)
- Database: user_management
- Username: root (default)
- Password: (empty by default)

## Files

- `registeration.php` - User registration form
- `save.php` - Process registration data
- `list.php` - Display all users
- `view.php` - View individual user details
- `delete.php` - Delete user functionality
- `config.php` - Database configuration
- `setup_database.php` - Database setup script

## Security Features

- Password hashing using PHP's `password_hash()`
- PDO prepared statements to prevent SQL injection
- Input validation and sanitization
- XSS protection with `htmlspecialchars()`