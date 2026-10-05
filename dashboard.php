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

                </ul>

            </div>

        </div>

    </nav>


    <!-- Dashboard Content -->

    <div class="container mt-5">

        <h1 class="mb-4">
            Dashboard
        </h1>

        <p class="lead">
            Welcome to the Employee Management System.
        </p>


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
                            0
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
                            0
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
                            0
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

            <a href="#" class="btn btn-primary">
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