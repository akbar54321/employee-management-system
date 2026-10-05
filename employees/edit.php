<?php

include("../config/database.php");

$id = $_GET['id'];

// Update employee when the form is submitted
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $joining_date = $_POST['joining_date'];

    // Prepare UPDATE statement
    $stmt = $conn->prepare("UPDATE employees SET
        name = ?,
        email = ?,
        phone = ?,
        department = ?,
        salary = ?,
        joining_date = ?
        WHERE id = ?");

    // Bind values
    $stmt->bind_param(
        "ssssdsi",
        $name,
        $email,
        $phone,
        $department,
        $salary,
        $joining_date,
        $id
    );

    // Execute UPDATE
    if ($stmt->execute()) {

        header("Location: list.php?success=updated");
        exit();

    } else {

        echo "Error updating employee: " . $stmt->error;
    }

    $stmt->close();
}


// Get employee information
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");

$stmt->bind_param("i", $id);

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

    <title>Edit Employee</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body>

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-dark text-white">

                <h3 class="mb-0">Edit Employee</h3>

            </div>

            <div class="card-body">

                <form method="POST">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Employee Name
                            </label>

                            <input type="text"
                                name="name"
                                class="form-control"
                                value="<?php echo $employee['name']; ?>"
                                required>

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email"
                                name="email"
                                class="form-control"
                                value="<?php echo $employee['email']; ?>"
                                required>

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Phone
                            </label>

                            <input type="text"
                                name="phone"
                                class="form-control"
                                value="<?php echo $employee['phone']; ?>"
                                required>

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Department
                            </label>

                            <input type="text"
                                name="department"
                                class="form-control"
                                value="<?php echo $employee['department']; ?>"
                                required>

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Salary
                            </label>

                            <input type="number"
                                name="salary"
                                class="form-control"
                                value="<?php echo $employee['salary']; ?>"
                                step="0.01"
                                required>

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Joining Date
                            </label>

                            <input type="date"
                                name="joining_date"
                                class="form-control"
                                value="<?php echo $employee['joining_date']; ?>"
                                required>

                        </div>

                    </div>


                    <button type="submit"
                        name="update"
                        class="btn btn-success">

                        Update Employee

                    </button>


                    <a href="list.php"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>