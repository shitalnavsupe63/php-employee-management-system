<?php
session_start();
include '../database/connection.php';
include '../sidebar-admin.php';

// to store error and success msg
$error = '';
$success = '';

// Check if employee is logged in
// if (!isset($_SESSION['employee_id'])) {
//     header('Location: login.php');
//     exit();
// }

// $employee_id = $_SESSION['company_id'];

// Fetch current profile data from the database
$query = "SELECT * FROM employees WHERE is_admin = '1'";
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
                    WHERE is_admin = '1'";

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
    /* Add styles as per your design */
</style>

<body>

    <div class="container mt-0">
        <div class="registration-form">
            <h6 class="heading display-6 mb-3 text-center">Edit Profile</h6>

            <!-- Display error or success messages -->
            <?php if ($error) : ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <?php if ($success) : ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">

                    <div class="col-12">
                        <!-- Full Name -->
                        <div class="form-group mb-3">
                            <label for="fullname">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" value="<?= $employee['fullname'] ?>" required class="form-control">
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?= $employee['email'] ?>" required class="form-control">
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group mb-3">
                            <label for="phoneNo">Phone Number:</label>
                            <input type="number" id="phoneNo" name="phoneNo" value="<?= $employee['phoneNo'] ?>" class="form-control">
                        </div>

                        <!-- Age -->
                        <div class="form-group mb-3">
                            <label for="age">Age:</label>
                            <input type="number" id="age" name="age" value="<?= $employee['age'] ?>" class="form-control">
                        </div>

                        <!-- Date of Birth -->
                        <div class="form-group mb-3">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" id="dob" name="dob" value="<?= $employee['dob'] ?>" required class="form-control">
                        </div>

                        <!-- Gender -->
                        <div class="form-group mb-3">
                            <label for="gender">Gender:</label>
                            <select name="gender" id="gender" required class="form-control">
                                <option value="Male" <?= $employee['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= $employee['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= $employee['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <!-- Address -->
                        <div class="form-group mb-3">
                            <label for="address">Address:</label>
                            <textarea name="address" id="address" class="form-control"><?= $employee['address'] ?></textarea>
                        </div>

                        <!-- Department -->
                        <div class="form-group mb-3">
                            <label for="department">Department:</label>
                            <input type="text" id="department" name="department" value="<?= $employee['department'] ?>" required class="form-control">
                        </div>

                        <!-- Employee Type -->
                        <div class="form-group mb-3">
                            <label for="employee_type">Employee Type:</label>
                            <select name="employee_type" id="employee_type" required class="form-control">
                                <option value="Full-time" <?= $employee['employee_type'] == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                                <option value="Part-time" <?= $employee['employee_type'] == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                                <option value="Contract" <?= $employee['employee_type'] == 'Contract' ? 'selected' : '' ?>>Contract</option>
                            </select>
                        </div>

                        <!-- Basic Salary -->
                        <div class="form-group mb-3">
                            <label for="basic_salary">Basic Salary:</label>
                            <input type="number" step="0.01" id="basic_salary" name="basic_salary" value="<?= $employee['basic_salary'] ?>" class="form-control">
                        </div>

                        <!-- Photo -->
                        <div class="form-group mb-3">
                            <label for="photo">Photo:</label>
                            <input type="file" id="photo" name="photo" accept="image/*" class="form-control">
                        </div>

                        <button class="btn btn-primary p-2 mt-3 btn w-100" type="submit" name="submit">Update Profile</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</body>
</html>
