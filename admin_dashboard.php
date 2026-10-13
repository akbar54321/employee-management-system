<?php
session_start();

// Prevent browser caching of the protected dashboard
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Allow only logged-in administrators
if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_role']) ||
    $_SESSION['user_role'] !== 'admin'
) {
    header('Location: login.php');
    exit;
}
// Connect to the existing database
require_once __DIR__ . '/config/database.php';

// Total employee records
$totalEmployees = 0;
$result = $conn->query("SELECT COUNT(*) AS total FROM employees");
if ($result) {
    $totalEmployees = (int) $result->fetch_assoc()['total'];
}

// Number of distinct departments
$totalDepartments = 0;
$result = $conn->query(
    "SELECT COUNT(DISTINCT department) AS total
     FROM employees
     WHERE department IS NOT NULL AND TRIM(department) <> ''"
);
if ($result) {
    $totalDepartments = (int) $result->fetch_assoc()['total'];
}

// Employees who joined in the current calendar month
$newEmployees = 0;
$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM employees
     WHERE joining_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
       AND joining_date < DATE_FORMAT(
           DATE_ADD(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-01'
       )"
);
if ($result) {
    $newEmployees = (int) $result->fetch_assoc()['total'];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Employee Management System</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <style>
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            color: #ffffff;
            background: transparent;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .logout-btn:hover {
            color: #ffffff;
            background-color: #0a58ca;
        }

        .logout-btn:focus {
            box-shadow: none;
        }

        .logout-btn:focus-visible {
            outline: 2px solid #ffffff;
            outline-offset: 2px;
        }

        .logout-btn:active {
            color: #ffffff;
            background-color: #084298;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

        <div class="container">

            <a class="navbar-brand" href="index.php">
                Employee Management System
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Employees
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            Home
                        </a>
                    </li>

                    <li class="nav-item ms-lg-3 d-flex align-items-center">
                        <a href="logout.php"
                            class="logout-btn">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="me-1">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Logout
                        </a>
                    </li>


                </ul>

            </div>

        </div>

    </nav>
    <!-- Dashboard Content -->
    <div class="container mt-5">
        <h1 class="mb-4">
            Welcome, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
        </h1>
        <p class="lead">
            You are logged in as Administrator.
        </p>
    </div>



    <!-- Dashboard Cards -->

    <div class="row mt-4">

        <!-- Total Employees -->

        <div class="col-md-4 mb-3">

            <div class="card shadow">

                <div class="card-body text-center">

                    <h5 class="card-title">
                        Total Employees
                    </h5>

                    <h2 class="text-primary">
                        <?= $totalEmployees ?>
                    </h2>

                    <p class="card-text">
                        Number of employees
                    </p>

                </div>

            </div>

        </div>


        <!-- Departments -->

        <div class="col-md-4 mb-3">

            <div class="card shadow">

                <div class="card-body text-center">

                    <h5 class="card-title">
                        Departments
                    </h5>

                    <h2 class="text-success">
                       <?= $totalDepartments ?>
                    </h2>

                    <p class="card-text">
                        Number of departments
                    </p>

                </div>

            </div>

        </div>


        <!-- New Employees -->

        <div class="col-md-4 mb-3">

            <div class="card shadow">

                <div class="card-body text-center">

                    <h5 class="card-title">
                        New Employees
                    </h5>

                    <h2 class="text-warning">
                      <?= $newEmployees ?>
                    </h2>

                    <p class="card-text">
                        Recently added employees
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- Employee Management Button -->

    <div class="mt-4">

        <a href="employees/list.php" class="btn btn-primary">
            Manage Employees
        </a>

    </div>

    </div>


    <!-- Bootstrap JavaScript -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>