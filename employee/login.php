<?php

session_start();

include '../database/connection.php';
// include 'employee-sidebar.php';
// include '../header.php';
// include '../sidebar.php';


$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);

    if (empty($email) || empty($employee_id)){

        $error = 'Email and Employee ID are required!';
    }else{

        $query = "SELECT * FROM employees WHERE email='$email' AND employee_id='$employee_id' LIMIT 1";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['company_id'] = $row['employee_id'];

            header('Location: ../employee/dashboard.php');
            exit();

        }else{
            $error = "Wrong Email or Employee ID";
        }
    }
}

include '../sidebar-employee.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>employee-login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>


<style>

    body{
        background: url('../assets/login-form.jpg') no-repeat center center fixed;
        background-size: cover;
    }
     .input{
        font-size: 18px;
        border-radius: 5px;
        width: 60%;
        
    }

    .login-form{
        background:rgb(204, 214, 227);
        padding: 30px;
        border-radius: 10px;
        max-width: 600px;
        margin: auto;
        box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
    }

    .btn2{
        background: linear-gradient(to right,rgb(196, 104, 207),rgb(53, 168, 203));
        font-size: 20px;
        padding: 10px;
        /* padding-left: 20px;
        padding-right: 20px; */
        width: 40%;
       
    }

    .last{
        font-size: larger;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .link{
        text-decoration: none;
        font-size: large;
    }

    

    
</style>



<body>

    <div class="container content text-center" >
        <div class="login-form mt-4">

             <h3 class="display-6">Employee Login</h3>

             <div class="row ">
                <div class="col-12 col-md-12 ">


                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?> </div>
                <?php endif; ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-outline mb-3 ">
                            <input class="input p-2 mt-3" type="email" name="email" id="email" placeholder="Enter your email">
                        </div>

                        <div class="form-outline mb-3">
                            <input class="input p-2 " type="text" name="employee_id" id="employee_id" placeholder="Enter your Employee ID">
                        </div>

                        
                        <button  class="btn btn2 mt-3 mb-1" type="submit" name="submit">Login</button>
                        
                        <P class="mt-1 mb-0 last" >Not yet registered ? <a class="link" href="registration.php">Register</a></P>

                    </form>
                </div>
             </div>


        </div>


    </div>
    

    
</body>
</html>