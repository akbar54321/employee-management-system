# Employee Management System

A simple web-based Employee Management System developed using PHP, MySQL, HTML, CSS, Bootstrap, and JavaScript.

## Project Description

The Employee Management System is a web application developed to manage employee records.

The system allows users to add, view, edit, and delete employee information.

This project was developed as a practical project to learn PHP, MySQL, CRUD operations, form validation, and GitHub.

## Features

- Add new employee records
- View employee records
- Edit employee information
- Delete employee records
- Employee ID using auto-increment
- Form validation
- Phone number validation
- Email validation
- Duplicate email checking
- Date validation
- Prepared statements for database operations
- Bootstrap-based user interface
- Success and error messages

## Technologies Used

- HTML5
- CSS3
- Bootstrap 5.3.3
- JavaScript
- PHP
- MySQL
- XAMPP
- Visual Studio Code
- Git
- GitHub

## Database

**Database Name:** `employee_management`

**Table Name:** `employees`

## Project Structure

```text
Employee-Management-System/
│
├── config/
│   └── database.php
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

## How to Run the Project

1. Install XAMPP.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Copy the project folder into the `htdocs` folder.
4. Create a MySQL database named `employee_management`.
5. Create the required `employees` table.
6. Update the database connection details in `config/database.php`.
7. Open the project in a web browser.

Example:

```text
http://localhost/Employee-Management-System/
```

## CRUD Operations

The system supports the following CRUD operations:

- **Create** – Add employee records
- **Read** – View employee records
- **Update** – Edit employee records
- **Delete** – Remove employee records

## Security

Prepared statements are used for database INSERT and UPDATE operations to help protect against SQL injection.

## Future Improvements

- Import employee records from Excel/CSV
- Improved validation
- Search employees
- Employee filtering
- Pagination
- User login and authentication
- Improved dashboard
- Deployment to a web server

## Author

**Akbar Ali**

## Project Status

**Phase 1 – Employee Management System**

Development in progress.