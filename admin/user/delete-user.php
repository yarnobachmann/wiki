<?php
session_start();
include '../../partials/databaseConnection.php';
include '../../partials/auth.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM `users` WHERE id = $id";

    $stmt = $conn->query($sql);
    if ($stmt) {
        header("Location: ../../admin/user/users");
    }
    else {
        echo "Data not processed!";
    }
}
?>