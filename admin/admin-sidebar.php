<?php

// session_start();

include '../database/connection.php';

$loggedInEmail = $_SESSION['email'];

$query = "SELECT is_admin, fullname, photo FROM employees WHERE email = '$loggedInEmail'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$isAdmin = $user['is_admin'] == 1; 

// $isAdmin = ($loggedInEmail == 'admin@gmail.com');  // Adjust the admin email here

if ($isAdmin) {
    $adminPhoto = "../assets/admin-kristian.jpg"; 
    $employeeName = "Admin Kristian"; 
} else {
    
    $query = "SELECT fullname, photo FROM employees WHERE email = '$loggedInEmail'";
    $result = mysqli_query($conn, $query);
    $employee = mysqli_fetch_assoc($result);

    $employeeName = $employee['fullname'];
    $employeePhoto = $employee['photo'] ? "../uploads/" . $employee['photo'] : "../assets/home.jpg";
}
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
        background-color: aliceblue;
    }

    
</style>

<body>
    <button class="btn btn-primary m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">
        Open Dashboard
    </button>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title ms-5">Admin Dashboard</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="profile">
            <img src="<?= $isAdmin ? $adminPhoto : $employeePhoto ?>"  alt="profile">
            <span class="mt-2"><?= $employeeName ?></span>
        </div>
        <div class="offcanvas-body text-center">
            
            <ul class="list-group list-group-flush mt-1">
                <?php if ($isAdmin) : ?>
                    <li class="list-group-item"><a href="edit_profile.php" class="a text-decoration-none">Edit Profile</a></li>
                <?php endif; ?>
                <li class="list-group-item"><a href="dashboard.php" class="a text-decoration-none">Employee List</a></li>
                <li class="list-group-item"><a href="assign_task.php" class="a text-decoration-none">Assign Task</a></li>
                <li class="list-group-item"><a href="manage_leaves.php" class="a text-decoration-none">Manage Leaves</a></li>
                <li class="list-group-item"><a href="manage_holidays.php" class="a text-decoration-none">Manage Holidays</a></li>
                <li class="list-group-item"><a href="logout.php" class="a text-decoration-none text-danger">Logout</a></li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
