<?php
session_start();
require_once 'config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $sql = "SELECT id, name, email, password, role
            FROM users
            WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        if ($user['role'] === 'admin') {
            header('Location: admin_dashboard.php');
            exit;
        }

        header('Location: user_dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employee Management System</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        .password-group .form-control {
            border-right: 0;
        }

        .password-toggle {
            background: #fff;
            color: #6c757d;
            border: 1px solid #dee2e6;
            border-left: 0;
            padding: 0 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #0d6efd;
            background: #fff;
        }

        .password-toggle:focus {
            box-shadow: none;
            outline: none;
        }

        .password-toggle:focus-visible {
            outline: 2px solid #0d6efd;
            outline-offset: -3px;
        }

        .password-toggle svg {
            display: block;
        }
    </style>

</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                Employee Management System
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow">
                    <div class="card-body p-4">

                        <h2 class="text-center mb-4">Login</h2>

                        <form action="" method="POST">

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email Address
                                </label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    required>

                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        Password
                                    </label>

                                    <div class="input-group password-group">
                                        <input
                                            type="password"
                                            class="form-control"
                                            id="password"
                                            name="password"
                                            required>

                                        <button
                                            class="btn password-toggle"
                                            type="button"
                                            id="togglePassword"
                                            aria-label="Show password"
                                            title="Show password">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="20" height="20"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>


                            </div>

                            <button type="submit"
                                class="btn btn-primary w-100">
                                Login
                            </button>

                        </form>

                        <div class="text-center mt-3">
                            <a href="index.php">Back to Home</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        const eyeIcon = `
        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/>
        <circle cx="12" cy="12" r="3"/>
    `;

        const eyeOffIcon = `
        <path d="M3 3l18 18"/>
        <path d="M10.6 10.6a2 2 0 002.8 2.8"/>
        <path d="M9.9 5.2A11 11 0 0112 5c6.4 0 10 7 10 7a16 16 0 01-4 4.7"/>
        <path d="M6.2 6.2C3.5 8 2 12 2 12s3.6 7 10 7a10 10 0 003.1-.5"/>
    `;

        togglePassword.addEventListener('click', function() {
            const showPassword = passwordInput.type === 'password';

            passwordInput.type = showPassword ? 'text' : 'password';

            togglePassword.querySelector('svg').innerHTML =
                showPassword ? eyeOffIcon : eyeIcon;

            togglePassword.style.color =
                showPassword ? '#0d6efd' : '#6c757d';

            togglePassword.setAttribute(
                'aria-label',
                showPassword ? 'Hide password' : 'Show password'
            );

            togglePassword.title =
                showPassword ? 'Hide password' : 'Show password';
        });
    </script>

</body>

</body>

</html>