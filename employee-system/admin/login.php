<?php
session_start();

include '../database/connection.php';
include '../sidebar-admin.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);

    $query = "SELECT * FROM employees WHERE email = '$email' AND employee_id = '$employee_id' ";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1){

        $row = mysqli_fetch_assoc($result);

        if ($row['is_admin'] == 1){

            $_SESSION['user_id'] = $row['employee_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['admin'];

            header('Location: ../admin/dashboard.php');
            exit();

        }else{

            $error = "You do not have admin access"; 
        }
    }elseif (empty($email) || empty($employee_id)){

        $error = "Enter email and admin ID!";
        
    }else{
        $error = "Wrong Email or ID";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin-login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<style>
    body{
        background : url('../assets/admin-login.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    /* .login{
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    } */

    .login-card{
        background:rgb(204, 214, 227);
        padding: 30px;
        border-radius: 10px;
        width: 100%;
        max-width: 600px;
        text-align: center;
    }

    .input{
        font-size: 18px;
        border-radius: 10px;
        width: 50%;

    }
</style>



<body>

    <div class="container login d-flex justify-content-center align-items-center mt-5">

        <div class="login-card  mt-0">

        <h6 class="display-6 mb-4">Admin Login</h6>

            <?php if ($error): ?>
               <div class="alert alert-danger"><?= $error ?> </div>
            <?php endif; ?>


        <form action="" method="post">

            <input class="input p-2" type="email" name="email" id="email" placeholder="Enter your email">
            <br><br>

            <input class="input p-2" type="text" name="employee_id" id="employee_id" placeholder="Enter your Admin ID">
            <br><br>

            <button class="btn w-50 btn-warning p-2 mb-3" type="submit" name="submit">Login</button>

        </form>

    </div>

</div>

</body>
</html>