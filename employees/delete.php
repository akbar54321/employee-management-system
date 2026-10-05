<?php

include("../config/database.php");

$id = $_GET['id'];

// Prepare DELETE statement
$stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");

// Bind employee ID
$stmt->bind_param("i", $id);

// Execute DELETE
if ($stmt->execute()) {
    header("Location: list.php?success=deleted");
    exit;

} else {

    echo "Error deleting record: " . $stmt->error;

}

$stmt->close();

?>