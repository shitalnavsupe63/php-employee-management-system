<?php 
include '../database/connection.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    mysqli_query($conn, "DELETE FROM holidays WHERE id=$id");
}

header("Location: manage_holidays.php");

?>