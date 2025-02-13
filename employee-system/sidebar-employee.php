<?php

// session_start();

include 'database/connection.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>

    .offcanvas{
        background-color:rgb(142, 182, 222);
    }


    .profile{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 15px;
        background-color:rgb(79, 126, 174);
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .profile img{
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid white;
    }

    .profile span{
        color: white;
        font-size: 18px;
    }

    a{
        color: black;
        font-size: 18px;
        text-decoration: none;
        padding: 10px;
        display: block;
        margin: 10px 0 ;
        border-radius: 5px;
        text-align: center;
    } 

    a:hover{
        background:aliceblue;
    }

    
</style>

<body>
    <button class="btn btn-primary m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">
        Open Dashboard
    </button>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-center">Employee Dashboard</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="profile">
            <img src="../assets/home.jpg"  alt="profile">
            <span class="mt-2">Employee System</span>
        </div>
        <div class="offcanvas-body text-center">
            <!-- <img src="https://via.placeholder.com/100" class="rounded-circle mb-3" alt="Profile Logo">
            <h6>John Doe</h6> -->
            <ul class="list-group list-group-flush mt-1">
                <li class="list-group-item "><a href="registration.php" class="a text-decoration-none">Employee Registration</a></li>
                <li class="list-group-item"><a href="login.php" class="a text-decoration-none">Employee Login</a></li>
                <li class="list-group-item"><a href="..\admin\login.php" class="a text-decoration-none">Admin Login</a></li>
                <!-- <li class="list-group-item"><a href="../employee/logout.php" class="a text-decoration-none text-danger">Logout</a></li> -->
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
