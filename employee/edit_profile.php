<?php
session_start();
include '../database/connection.php';
include 'employee-sidebar.php';

// to store error and success msg
$error = '';
$success = '';

// Check if employee is logged in
// if (!isset($_SESSION['employee_id'])) {
//     header('Location: login.php');
//     exit();
// }

$employee_id = $_SESSION['company_id'];

// Fetch current profile data from the database
$query = "SELECT * FROM employees WHERE employee_id = '$employee_id'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 1) {
    $employee = mysqli_fetch_assoc($result);
} else {
    $error = "Employee not found.";
}

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photoName = time(). '_'. $_FILES['photo']['name'];
        $photoPath = "../uploads/". $photoName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            $photo = $photoName;
        } else {
            $photo = null;
        }
    } else {
        $photo = NULL;
    }

    // Update the employee data in the database
    $update_query = "UPDATE employees SET 
                        fullname = '$fullname', 
                        email = '$email', 
                        phoneNo = '$phoneNo', 
                        age = '$age', 
                        dob = '$dob', 
                        gender = '$gender', 
                        address = '$address', 
                        department = '$department', 
                        employee_type = '$employee_type', 
                        basic_salary = '$basic_salary', 
                        photo = '$photo' 
                    WHERE employee_id = '$employee_id'";

    if (mysqli_query($conn, $update_query)) {
        $success = "Profile updated successfully.";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
    body{
        /* background: url('../assets/home.jpg') no-repeat center center fixed;
        background-size: cover; */
        background:#d8bd76;
       
    }

    .registration-form{
        background:rgb(255, 255, 255);
        padding: 30px;
        /* border-radius: 10px; */
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
</style>

<body>

    <div class="container mt-0 content vh-100 d-flex align-items-center justify-content-center">
    
        <div class="registration-form shadow">
            

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

                        <!-- <div class="col-md-6 mb-3">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input type="text" id="employee_id" name="employee_id" value="<?= $employee['fullname'] ?>" required class="form-control">
                        </div> -->

                        <div class="col-md-6 mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" id="fullname" name="fullname" value="<?= $employee['fullname'] ?>" required class="form-control">
                        </div>
                    

                        <div class="col-md-6  mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="<?= $employee['email'] ?>" required class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phoneNo" class="form-control" value="<?= $employee['phoneNo'] ?>" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" id="age" name="age" class="form-control" value="<?= $employee['age'] ?>">
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" id="dob" name="dob" required class="form-control" value="<?= $employee['dob'] ?>">
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" required class="form-control" >
                                <option value="Male" <?php if ($employee['gender'] == "Male") echo "selected"; ?>>Male</option>
                                <option value="Female" <?php if ($employee['gender'] == "Female") echo "selected"; ?>>Female</option>
                                <option value="Other" <?php if ($employee['gender'] == "Other") echo "selected"; ?>>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="employee_type" class="form-label">Employee Type</label>
                            <select name="employee_type" id="employee_type" required class="form-control" >
                                <option value="Full-time" <?php if ($employee['employee_type'] == "Full-time") echo "selected"; ?> >Full-time</option>
                                <option value="Part-time" <?php if ($employee['employee_type'] == "Part-time") echo "selected"; ?>>Part-time</option>
                                <option value="Contract" <?php if ($employee['employee_type'] == "Contract") echo "selected"; ?>>Contract</option>
                            </select>
                        </div>

                        <div class="col-md-12 form-group mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control"><?= htmlspecialchars($employee['address']) ?></textarea>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" id="department" name="department" required class="form-control" value="<?= $employee['department'] ?>">
                        </div>

                        

                        <div class="col-md-6 form-group mb-3">
                            <label for="basic_salary" class="form-label">Basic Salary</label>
                            <input type="number" step="0.01" id="basic_salary" name="basic_salary" class="form-control" value="<?= $employee['basic_salary'] ?>">
                        </div>

                        <div class="col-md-10 form-group mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" id="photo" name="photo" accept="image/*" class="form-control" >
                            <?php if (!empty($employee['photo'])): ?>
                                <div class="mt-2">
                                    <img src="uploads/<?= htmlspecialchars($employee['photo']) ?>" alt="Employee Photo" width="100">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="text-center">
                            <button class="btn-2 p-2 mt-3 btn btn-primary w-50" type="submit" name="submit">Update Profile</button>
                        </div>
                        
                    <!-- </div> -->

                </div>
            </form>
        </div>
    </div>

</body>

</html>
