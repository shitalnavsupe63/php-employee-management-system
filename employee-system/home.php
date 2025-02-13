<?php
session_start();
include 'database/connection.php';

// include("header.php");

include("sidebar.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homepage</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<style>
   body, html {
            height: 100%;
            /* overflow: hidden; */
   }

        /* Main Content Section */
        .content {
            position: absolute;
            /* top: 56px; Below Navbar */
            /* left: 250px; Right of Sidebar */
            /* width: calc(100% - 250px);
            height: calc(100vh - 56px); */
            width: 100%;
            height: 100%;
            background: url('assets/home.jpg') no-repeat center center;
            background-size: cover;
            padding: 20px;
            /* position: relative; */
            z-index: 1;
        }

        /* Overlay for Readability */
        /* .content::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3); /* Dark transparent overlay */
            /* z-index: 2; */
        /* }  

        /* Content Text */
        .content .text {
            position: relative;
            /* color: white;
            background-color: gray; */
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            z-index: 3;
            margin-top: 10%;
        }

 

</style>

<body>
<div class="content">
        <div class="text">
            <!-- <h1>Welcome to the Dashboard</h1> -->
            <!-- <p>Manage employees and tasks efficiently.</p> -->
        </div>
    </div>
</body>
</html>