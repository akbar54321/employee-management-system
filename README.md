# Employee Management System

A web-based Employee Management System developed using PHP, MySQL, HTML5, CSS3, Bootstrap 5.3.3, and JavaScript.

## Project Description

The Employee Management System is a practical web application designed to manage employee records. It demonstrates the implementation of CRUD operations, server-side form validation, database connectivity, and version control using Git and GitHub.

## Features

- Add new employee records
- View employee records
- Edit and update employee information
- Delete employee records
- Automatically generated employee IDs
- Form and date validation
- Email and phone number validation
- Duplicate email checking
- Prepared statements for database operations
- Bootstrap-based responsive user interface
- Success and error messages

## Technologies Used

- PHP
- MySQL
- HTML5 and CSS3
- Bootstrap 5.3.3
- JavaScript
- XAMPP
- Visual Studio Code
- Git and GitHub

## Database Information

- **Database name:** `employee_management`
- **Table name:** `employees`

The database must be created locally in MySQL before running the application.

## Project Structure

```text
Employee-Management-System/
│
├── config/
│   └── database.example.php
│
├── employees/
│   ├── add.php
│   ├── edit.php
│   ├── delete.php
│   └── list.php
│
├── index.php
├── .gitignore
└── README.md
```

*Note: This structure is an example. Adjust it to match the actual files in your repository.*

## Installation and Setup

### 1. Install XAMPP

Install XAMPP and start Apache and MySQL from the XAMPP Control Panel.

### 2. Copy the project

Place the project folder inside the XAMPP `htdocs` directory.

### 3. Create the database

Open phpMyAdmin and create a database named `employee_management`.

### 4. Create the employees table

Create the `employees` table with the columns required by the application. The column names and data types must match the SQL queries in the project.

### 5. Configure the database connection

Create a local `config/database.php` file using `config/database.example.php` as a template.

Update the database host, database name, username, and password for your local environment.

**Security:** Do not commit real database credentials to GitHub. The local `config/database.php` file should remain excluded by `.gitignore`.

### 6. Run the application

Open the following URL in your browser, adjusting the folder name if necessary:

`http://localhost/Employee-Management-System/`

## CRUD Operations

- **Create:** Add employee records.
- **Read:** Display employee records.
- **Update:** Edit existing employee information.
- **Delete:** Remove employee records.

## Security

The project uses prepared statements for database operations where implemented. Server-side input validation is used to help ensure that submitted employee information meets the application's requirements.

Further security improvements can include reviewing every database query, output escaping, and protection against cross-site request forgery (CSRF).

## Future Improvements

- Import employee records from CSV or Excel files
- Employee search and filtering
- Pagination
- User authentication and access control
- Improved dashboard and reporting
- Deployment to a web server

## Author

**Akbar Ali**

## Project Status

**Phase 1 – Employee Management System**

Development in progress.
