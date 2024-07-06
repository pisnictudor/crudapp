<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "crud_app";

    $conn = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM students WHERE id=$id";
    $conn->query($sql);

    header("location:/crud_app/index.php");
    exit;
}
?>