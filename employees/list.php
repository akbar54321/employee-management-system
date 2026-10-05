<?php

include("../config/database.php");

$sql = "SELECT * FROM employees ORDER BY id ASC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body>

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-dark text-white">

                <h3 class="mb-0">Employee Management</h3>

            </div>



            <div class="card-body">
                <?php

                if (isset($_GET['success']) && $_GET['success'] == 'added') {

                ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <strong>Success!</strong>
                        Employee added successfully.

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                        </button>
                   </div>
                <?php } ?>
                <?php
                if (isset($_GET['success']) && $_GET['success'] == 'updated') {
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong>
                        Employee record updated successfully.

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                        </button>

                    </div>
                <?php } ?>

                <?php

                if (isset($_GET['success']) && $_GET['success'] == 'deleted') {

                ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <strong>Success!</strong>
                        Employee record deleted successfully.

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                        </button>

                    </div>

                <?php } ?>


                <div class="d-flex justify-content-between mb-3">

                    <h4>Employee List</h4>

                    <a href="add.php" class="btn btn-primary">
                        + Add Employee
                    </a>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Salary</th>
                                <th>Joining Date</th>
                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {

                            ?>

                                    <tr>

                                        <td><?php echo $row['id']; ?></td>

                                        <td><?php echo $row['name']; ?></td>

                                        <td><?php echo $row['email']; ?></td>

                                        <td><?php echo $row['phone']; ?></td>

                                        <td><?php echo $row['department']; ?></td>

                                        <td><?php echo $row['salary']; ?></td>

                                        <td><?php echo $row['joining_date']; ?></td>

                                        <td><a href="edit.php?id=<?php echo $row['id']; ?>"
                                                class="btn btn-warning btn-sm"> Edit </a>

                                            <button type="button"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-id="<?php echo $row['id']; ?>">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                <?php

                                }
                            } else {

                                ?>

                                <tr>

                                    <td colspan="7" class="text-center">
                                        No employees found.
                                    </td>

                                </tr>

                            <?php

                            }

                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1"
        aria-labelledby="deleteModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header bg-danger text-white">

                    <h5 class="modal-title" id="deleteModalLabel">
                        Confirm Delete
                    </h5>

                    <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>

                <div class="modal-body">

                    Are you sure you want to delete this employee?

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <a href="#"
                        id="confirmDeleteButton"
                        class="btn btn-danger">
                        Delete Employee
                    </a>

                </div>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const deleteModal = document.getElementById('deleteModal');

        deleteModal.addEventListener('show.bs.modal', function(event) {

            const button = event.relatedTarget;

            const employeeId = button.getAttribute('data-id');

            const deleteButton = document.getElementById('confirmDeleteButton');

            deleteButton.href = 'delete.php?id=' + employeeId;

        });
    </script>
</body>

</html>