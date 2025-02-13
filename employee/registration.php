<?php
session_start();

include '../database/connection.php';
include '../sidebar-employee.php';

// include '../header.php';
// include '../sidebar.php';

// to store error and success msg
$error = '';
$success = '';

// check if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    // sanitization of user input4
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phoneNo = mysqli_real_escape_string($conn, $_POST['phoneNo']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $employee_type = mysqli_real_escape_string($conn, $_POST['employee_type']);
    $basic_salary = mysqli_real_escape_string($conn, $_POST['basic_salary']);


    // photo handle
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
        $photoName = time(). '_'. $_FILES['photo']['name'];
        $photoPath = "../uploads/". $photoName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)){
            $photo = $photoName;
        }else{
            $photo = null;
        }

        
    }else{

        $photo = NULL;
    }

    // check if required fields are filled
    if (empty($employee_id)){
        $error = "Employee ID is required";
    }
    if (empty($fullname)){
        $error = "Full name is required";
    }
    if (empty($email)){
        $error = "Email is required";
    }
    if (empty($phoneNo)){
        $error = "Phone Number is required";
    }
    if (empty($dob)){
        $error = "Date of Birth is required";
    }
    if (empty($address)){
        $error = "Address is required";
    }
    if (empty($department)){
        $error = "Department is required";

    }else{
        
        // check if email is already exists
        $check_email_query = "SELECT * FROM employees WHERE email='$email' ";
        $check_email_result = mysqli_query($conn, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0){
            $error = "Email already registered!";

        }else{

            $insert_query = "INSERT INTO employees (employee_id, fullname, email, phoneNo, age, dob, gender, address, department, employee_type, basic_salary, photo)
                            VALUES ('$employee_id', '$fullname', '$email', '$phoneNo', '$age', '$dob', '$gender', '$address', '$department', '$employee_type', '$basic_salary', '$photo') ";

            
            if (mysqli_query($conn, $insert_query)){
                $success = "Employee registered successfully";
                header("Location: ../employee/login.php");
                exit();
            }else{
                $error = 'Error : '.mysqli_error($conn);
            }
        }

    }



}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<style>
    body{
        background: url('../assets/register-form.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    .registration-form{
        background:rgb(204, 214, 227);
        padding: 30px;
        border-radius: 10px;
        max-width: 800px;
        margin: auto;
        box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
    }

    .form-label {
        /* font-weight: bold; */
        font-size: large;
       
    }

    .mb-3 {
        margin-bottom: 1.5rem;
    }

    .form-control {
        max-width: 100%;
        padding: 10px;
    }


    /* .form-group input,
    .form-group select,
    .form-group textarea {
        width: 65%;
    } */

    .btn-2{
        /* background: linear-gradient(to right,rgb(196, 104, 207),rgb(53, 168, 203)); */
        font-size: 19px;
        
    }

    .content {
            position: absolute;
            /* top: 56px; Below Navbar */
            /* left: 50px; Right of Sidebar */
            width: calc(100% - 250px);
            height: calc(100vh - 56px);
            background: url('assets/register-form.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
            position: relative;
            z-index: 1;
        }



</style>

<body>
<h6 class="heading display-6 mb-3 mt-0 text-center">New Employee Registration</h6>
    <div class="container mt-0 content vh-100 d-flex align-items-center justify-content-center">
    
        <div class="registration-form ">
            

            <!-- displaying error msg -->
            <?php if ($error) : ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <?php if ($success) :?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="row ">

                    <!-- <div class="col-12"> -->

                        <div class="col-md-6 mb-3">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input type="text" id="employee_id" name="employee_id" required class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" id="fullname" name="fullname" required class="form-control">
                        </div>
                    

                        <div class="col-md-6  mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" required class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phoneNo" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" id="age" name="age" class="form-control">
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" id="dob" name="dob" required class="form-control">
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" required class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="employee_type" class="form-label">Employee Type</label>
                            <select name="employee_type" id="employee_type" required class="form-control">
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Contract</option>
                            </select>
                        </div>

                        <div class="col-md-12 form-group mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control"></textarea>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" id="department" name="department" required class="form-control">
                        </div>

                        

                        <div class="col-md-6 form-group mb-3">
                            <label for="basic_salary" class="form-label">Basic Salary</label>
                            <input type="number" step="0.01" id="basic_salary" name="basic_salary" class="form-control">
                        </div>

                        <div class="col-md-10 form-group mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" id="photo" name="photo" accept="image/*" class="form-control">
                        </div>

                        <div class="text-center">
                            <button class="btn-2 p-2 mt-3 btn btn-primary w-50" type="submit" name="submit">Register</button>
                        </div>
                        
                    <!-- </div> -->

                </div>
            </form>
        </div>
    </div>

</body>




</html>
