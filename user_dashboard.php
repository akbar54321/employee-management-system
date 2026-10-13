<?php
session_start();

// Prevent browser caching of the protected dashboard
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Allow only logged-in non-admin users
if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_role']) ||
    $_SESSION['user_role'] !== 'user'
) {
    header('Location: login.php');
    exit;
}


$userName = $_SESSION['user_name'] ?? 'User';

include("config/database.php");

// Get the employee record linked to the logged-in account
$userId = (int) $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT
        employees.name,
        employees.email,
        employees.phone,
        employees.department,
        employees.salary,
        employees.joining_date
    FROM users
    LEFT JOIN employees
        ON users.employee_id = employees.id
    WHERE users.id = ?
      AND users.role = 'user'
    LIMIT 1
");

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$employee = $result->fetch_assoc();

$stmt->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Employee Management System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">
                Employee Management System
            </span>

            <a href="logout.php" class="btn btn-light btn-sm">
                Logout
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2>Welcome, <?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>!</h2>

                <p class="text-muted mt-3">
                    You have successfully logged in to the Employee Management System.
                </p>

                <hr>


                <h5 class="mb-3">My Employee Profile</h5>

                <?php if ($employee && $employee['name'] !== null): ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Employee Name</th>
                                    <td><?= htmlspecialchars($employee['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= htmlspecialchars($employee['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td><?= htmlspecialchars($employee['phone'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td><?= htmlspecialchars($employee['department'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                                <tr>
                                    <th>Salary</th>
                                    <td><?= htmlspecialchars((string) $employee['salary'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                                <tr>
                                    <th>Joining Date</th>
                                    <td><?= htmlspecialchars($employee['joining_date'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>

                    <div class="alert alert-warning">
                        Your employee profile has not been linked yet.
                        Please contact the administrator.
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>

</body>

</html>