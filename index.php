<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2> List of Students</h2>
    <a class="btn btn-primary" href="/mycrudapp/create.php" role="button">New student</a>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $host = "localhost";
        $dbname = "mycruddb";
        $username = "postgres";
        $password = "mypassword";

        // Create connection
        $conn = pg_connect("host=$host dbname=$dbname user=$username password=$password");

        if (!$conn) {
            die("Connection failed: " . pg_last_error());
        }

        // Read all from database
        $sql = "SELECT * FROM students";
        $result = pg_query($conn, $sql);
        if (!$result) {
            die("Invalid query: " . pg_last_error());
        }

        // Read the data
        while ($row = pg_fetch_assoc($result)) {
            echo "
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['age']}</td>
                <td>
                    <a class='btn btn-primary btn-sm' href='/mycrudapp/edit.php?id={$row['id']}'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='/mycrudapp/delete.php?id={$row['id']}'>Delete</a>
                </td>
            </tr>
            ";
        }
        pg_close($conn);
        ?>
        </tbody>
        
    </table>
</div>
</body>
</html>

