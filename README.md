# User Management System

A simple PHP + MySQL CRUD application for managing user records.

## Features

- View all users in a table
- Add new users (with duplicate email check)
- Edit existing user details
- Delete users with a confirmation modal

## Requirements

- PHP 7.4+
- MySQL 5.7+ / MariaDB
- A local server (XAMPP, WAMP, Laragon, etc.)

## Setup

1. **Clone the repo** into your server's web root (e.g. `htdocs` for XAMPP).

2. **Create the database** — open phpMyAdmin or MySQL CLI and run:

```sql
CREATE DATABASE user_managment;

USE user_managment;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL
);
```

3. **Configure the connection** in `db.php` if your MySQL credentials differ from the defaults:

```php
$conn = new mysqli("localhost", "root", "", "user_managment");
```

4. **Open** `http://localhost/crudapplication/index.php` in your browser.
## File Structure

```
CRUDAPPLICATION/
├── db.php        # Database connection
├── index.php     # User list + delete modal
├── create.php    # Add new user
├── edit.php      # Edit existing user
├── delete.php    # Delete user
└── style.css     # Custom styles (optional)
```

## Security

- All database queries use **prepared statements** to prevent SQL injection.
- All user output is escaped with `htmlspecialchars()` to prevent XSS.
- IDs passed via URL are validated and cast to integers before use.

## Notes

- Database name `user_managment` matches the original schema (typo intentional for compatibility).
