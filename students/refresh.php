<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_app";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start transaction
$conn->begin_transaction();

try {
    // Get all student IDs in ascending order
    $sql = "SELECT id FROM students ORDER BY id ASC";
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("Invalid query: " . $conn->error);
    }

    $new_id = 1;
    while ($row = $result->fetch_assoc()) {
        $old_id = $row['id'];
        $update_sql = "UPDATE students SET id = $new_id WHERE id = $old_id";
        if (!$conn->query($update_sql)) {
            throw new Exception("Failed to update ID: " . $conn->error);
        }
        $new_id++;
    }

    // Reset the auto-increment value to the highest current ID + 1
    $reset_auto_increment_sql = "ALTER TABLE students AUTO_INCREMENT = $new_id";
    if (!$conn->query($reset_auto_increment_sql)) {
        throw new Exception("Failed to reset AUTO_INCREMENT: " . $conn->error);
    }


    // Commit transaction
    $conn->commit();

    // Redirect back to the index page
    header("Location: /crud_app/index.php");
    exit;
} 
    catch (Exception $e) {
    // Rollback transaction if any error occurs
    $conn->rollback();
    die("Error: " . $e->getMessage());
}

?>
