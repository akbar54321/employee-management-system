<?php
include("../config/database.php");

$errors = [];

if (isset($_POST['save'])) {

    // Get form values
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $department = trim($_POST['department']);
    $salary = trim($_POST['salary']);
    $joining_date = trim($_POST['joining_date']);


    // -----------------------------
    // INPUT VALIDATION
    // -----------------------------

    // Validate Employee Name
    if (empty($name)) {

        $errors[] = "Employee name is required.";
    } elseif (strlen($name) < 3) {

        $errors[] = "Employee name must be at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $name)) {

        $errors[] = "Employee name can contain only letters, spaces, hyphens, and apostrophes.";
    }


    // Validate Email
    if (empty($email)) {

        $errors[] = "Email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors[] = "Please enter a valid email address.";
    }


    // Check whether email already exists
    if (empty($errors)) {

        $check_stmt = $conn->prepare(
            "SELECT id FROM employees WHERE email = ?"
        );

        $check_stmt->bind_param("s", $email);

        $check_stmt->execute();

        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {

            $errors[] = "This email address is already registered.";
        }

        $check_stmt->close();
    }


    // Validate Phone
    if (empty($phone)) {

        $errors[] = "Phone number is required.";
    } elseif (!preg_match("/^[0-9]+$/", $phone)) {

        $errors[] = "Phone number must contain only numbers.";
    } elseif (strlen($phone) < 7 || strlen($phone) > 10) {

        $errors[] = "Phone number must be between 7 and 10 digits.";
    }


    // Validate Department
    if (empty($department)) {

        $errors[] = "Department is required.";
    } elseif (!preg_match("/^[a-zA-Z\s&'-]+$/", $department)) {

        $errors[] = "Department can contain only letters, spaces, &, hyphens, and apostrophes.";
    }

    // Validate Salary
    if (empty($salary)) {

        $errors[] = "Salary is required.";
    } elseif (!is_numeric($salary)) {

        $errors[] = "Salary must be a number.";
    } elseif ($salary <= 0) {

        $errors[] = "Salary must be greater than 0.";
    } elseif (preg_match('/\.(\d{3,})$/', $salary)) {

        $errors[] = "Salary can have a maximum of 2 decimal places.";
    }

    // Validate Joining Date
    if (empty($joining_date)) {

        $errors[] = "Joining date is required.";
    } elseif ($joining_date > date('Y-m-d')) {

        $errors[] = "Joining date cannot be a future date.";
    }


    // -----------------------------
    // INSERT ONLY IF THERE ARE
    // NO VALIDATION ERRORS
    // -----------------------------

    if (empty($errors)) {

        // Prepare SQL statement
        $stmt = $conn->prepare(
            "INSERT INTO employees
            (name, email, phone, department, salary, joining_date)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        // Bind values
        $stmt->bind_param(
            "ssssds",
            $name,
            $email,
            $phone,
            $department,
            $salary,
            $joining_date
        );


        // Execute query
        if ($stmt->execute()) {

            // Redirect after successful insertion
            header("Location: list.php?success=added");
            exit;
        } else {

            // Database error
            $errors[] = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Employee</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body>

    <div class="container mt-5">

        <div class="card shadow">

            <!-- Card Header -->
            <div class="card-header bg-dark text-white">

                <h3 class="mb-0">
                    Add New Employee
                </h3>

            </div>


            <div class="card-body">

                <!-- Display Validation Errors -->
                <?php if (!empty($errors)): ?>

                    <div class="alert alert-danger">

                        <strong>
                            Please correct the following errors:
                        </strong>

                        <ul class="mb-0 mt-2">

                            <?php foreach ($errors as $error): ?>

                                <li>
                                    <?php echo htmlspecialchars($error); ?>
                                </li>

                            <?php endforeach; ?>

                        </ul>

                    </div>

                <?php endif; ?>


                <!-- Employee Form -->
                <form method="POST">

                    <div class="row">

                        <!-- Employee Name -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Employee Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Enter employee name"
                                value="<?php echo htmlspecialchars($name ?? ''); ?>"
                                required>

                        </div>


                        <!-- Email -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter email address"
                                value="<?php echo htmlspecialchars($email ?? ''); ?>"
                                required>

                        </div>


                        <!-- Phone -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Phone
                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                placeholder="Enter phone number"
                                value="<?php echo htmlspecialchars($phone ?? ''); ?>"
                                required>

                        </div>


                        <!-- Department -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Department
                            </label>

                            <input
                                type="text"
                                name="department"
                                class="form-control"
                                placeholder="Enter department"
                                value="<?php echo htmlspecialchars($department ?? ''); ?>"
                                required>

                        </div>


                        <!-- Salary -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Salary
                            </label>

                            <<input
                                type="number"
                                name="salary"
                                class="form-control"
                                placeholder="Enter salary"
                                step="0.01"
                                min="0.01"
                                value="<?php echo htmlspecialchars($salary ?? ''); ?>"
                                required>

                        </div>


                        <!-- Joining Date -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Joining Date
                            </label>

                            <input
                                type="date"
                                name="joining_date"
                                class="form-control"
                                value="<?php echo htmlspecialchars($joining_date ?? ''); ?>"
                                max="<?php echo date('Y-m-d'); ?>"
                                required>

                        </div>

                    </div>


                    <!-- Buttons -->
                    <button
                        type="submit"
                        name="save"
                        class="btn btn-dark">

                        Save Employee

                    </button>


                    <a
                        href="../index.php"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>