<?php
include("header.php");  // Navbar
include("sidebar.php"); // Sidebar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Global Reset */
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        /* Navbar Styling */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 56px; /* Default Bootstrap navbar height */
            background-color: #212529;
            color: white;
            z-index: 1000;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px; /* Below Navbar */
            left: 0;
            width: 250px;
            height: calc(100vh - 56px); /* Full height minus navbar */
            background-color: #343a40;
            color: white;
            z-index: 1000;
            padding-top: 20px;
        }

        /* Main Content Section */
        .content {
            position: absolute;
            top: 56px; /* Below Navbar */
            left: 250px; /* Right of Sidebar */
            width: calc(100% - 250px);
            height: calc(100vh - 56px);
            background: url('assets/backgroundhome.jpg') no-repeat center center;
            background-size: cover;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* Overlay for Readability */
        .content::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3); /* Dark transparent overlay */
            z-index: 2;
        }

        /* Content Text */
        .content .text {
            position: relative;
            color: white;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            z-index: 3;
            margin-top: 10%;
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="content">
        <div class="text">
            <h1>Welcome to the Dashboard</h1>
            <p>Manage employees and tasks efficiently.</p>
        </div>
    </div>

</body>
</html>
