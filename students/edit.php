<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_app";

//Creating connection
$conn = new mysqli($servername, $username, $password, $database);

$id = "";
$name = "";
$email = "";
$age = "";

$errorMessage = '';
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["id"])) {
        header("location: /crud_app/index.php");
        exit;
    }

    $id = $_GET["id"];

    //read the row of the selected student from db table
    $sql = "SELECT * FROM students WHERE id = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /crud_app/index.php");
        exit;
    }
    $name = $row['name'];
    $email = $row['email'];
    $age = $row['age'];
} else {
    //POST method: Update the data of the client
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    do {
        if (empty($id) || empty($name) || empty($email) || empty($age)) {
            $errorMessage = "Please fill all the fields";
            break;
        }
        $sql = "UPDATE students SET name = '$name', email = '$email', age = '$age' WHERE id = $id";

        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }
        $successMessage = "Student updated successfully";

        header("location: /crud_app/index.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="container my-5">
    <h2> Edit student</h2>
    <?php
    if (!empty($errorMessage)) {
        echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'> </button>
            </div>
            ";
    }
    ?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="name" value="<?php echo $name ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="email" value="<?php echo $email ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Age</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="age" value="<?php echo $age ?>">
            </div>
        </div>

        <?php
        if (!empty($successMessage)) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>$successMessage</strong> 
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'> </button>
            </div>
            ";
        }
        ?>
        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

            <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/crud_app/index.php">Cancel </a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
