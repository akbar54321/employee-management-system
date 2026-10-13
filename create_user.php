<?php
session_start();

// Prevent browser caching of the protected page
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

include("config/database.php");

$message = '';
$messageType = '';

// Process the form when the Admin clicks Create Account
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['create_account'])
) {

    $employeeId = filter_input(
        INPUT_POST,
        'employee_id',
        FILTER_VALIDATE_INT
    );

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$employeeId || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please select a valid employee and email address.';
        $messageType = 'danger';
    } elseif (strlen($password) < 12) {
        $message = 'The password must contain at least 12 characters.';
        $messageType = 'danger';
    } else {
        // Confirm that the employee exists and has no linked account
        $check = $conn->prepare(
            "SELECT id, name
             FROM employees
             WHERE id = ?
             AND NOT EXISTS (
                 SELECT 1 FROM users WHERE employee_id = ?
             )"
        );

        $check->bind_param("ii", $employeeId, $employeeId);
        $check->execute();
        $employeeResult = $check->get_result();
        $employeeData = $employeeResult->fetch_assoc();
        $check->close();

        if (!$employeeData) {
            $message = 'Employee not found or already has a user account.';
            $messageType = 'danger';
        } else {
            // Check whether the email is already registered
            $checkEmail = $conn->prepare(
                "SELECT id FROM users WHERE email = ?"
            );

            $checkEmail->bind_param("s", $email);
            $checkEmail->execute();
            $emailResult = $checkEmail->get_result();
            $emailExists = $emailResult->num_rows > 0;
            $checkEmail->close();

            if ($emailExists) {
                $message = 'This login email is already registered.';
                $messageType = 'danger';
            } else {
                $name = $employeeData['name'];
                $passwordHash = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );
                $role = 'user';

                // Create the account using a prepared statement
                $insert = $conn->prepare(
                    "INSERT INTO users
                     (employee_id, name, email, password, role)
                     VALUES (?, ?, ?, ?, ?)"
                );

                $insert->bind_param(
                    "issss",
                    $employeeId,
                    $name,
                    $email,
                    $passwordHash,
                    $role
                );

                if ($insert->execute()) {
                    $message = 'User account created successfully.';
                    $messageType = 'success';
                } else {
                    error_log(
                        'User account creation failed: ' .
                            $insert->error
                    );
                    $message = 'Unable to create the account. Please try again.';
                    $messageType = 'danger';
                }

                $insert->close();
            }
        }
    }
}

// The account-creation form will be added in the next step.

$employees = [];

$stmt = $conn->prepare(
    "SELECT e.id, e.name, e.email
     FROM employees e
     LEFT JOIN users u ON e.id = u.employee_id
     WHERE u.employee_id IS NULL
     ORDER BY e.name ASC"
);

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

$stmt->close();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User Account</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Create Employee Login Account</h4>
            </div>
            <div class="card-body">
                <?php if ($message !== ''): ?>
                    <div class="alert alert-<?= htmlspecialchars(
                                                $messageType,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>" role="alert">
                        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>
                <p class="text-muted">
                    Select an existing employee and create their login account.

                </p>

                <form method="POST" action="">

                    <div class="mb-3">
                        <label for="employee_id" class="form-label">
                            Select Employee
                        </label>

                        <select
                            name="employee_id"
                            id="employee_id"
                            class="form-select"
                            required>

                            <option value="">-- Select Employee --</option>

                            <?php foreach ($employees as $employee): ?>
                                <option value="<?= (int) $employee['id'] ?>">

                                    <?= htmlspecialchars(
                                        strtoupper($employee['name']),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Login Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            placeholder="Enter login email"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Initial Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            minlength="12"
                            autocomplete="new-password"
                            placeholder="At least 12 characters"
                            required>
                    </div>
                    <button
                        type="submit"
                        name="create_account"
                        class="btn btn-primary">
                        Create Account
                    </button>
                    <a
                        href="admin_dashboard.php"
                        class="btn btn-secondary">
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>