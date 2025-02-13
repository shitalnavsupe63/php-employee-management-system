<?php
session_start();

include '../database/connection.php';
include 'employee-sidebar.php';

$employee_id = $_SESSION['user_id'];

$error = '';
$success = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    if (empty($start_date) || empty($end_date) || empty($reason)) {

        $error = 'All Fields are required!';
    }else{

        $query = "INSERT INTO leaves (employee_id, start_date, end_date, reason) VALUES 
                   ('$employee_id', '$start_date', '$end_date', '$reason')";

        if (mysqli_query($conn, $query)) {

            $success = "Leave request submitted successfully";
        }else{

            $error = "Error submitting leave request";
        }
    }
}



// leaves status read
$leave_query = "SELECT * FROM leaves WHERE employee_id = $employee_id";
$leave_result = mysqli_query($conn, $leave_query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>leave_requests</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<style>
    body{
        background:rgb(204, 214, 227);
    }
    
    .form-container{
        background:rgb(204, 207, 207);
        padding: 20px;
        border-radius: 10px;
    
    }

    .form-label{
        font-size: 18px;
    }

    .table-container{
      
        padding: 20px;
        border-radius: 10px;
    }

    .btn{
        border-radius: 20px;
    }

    .leave{
        font-size: 18px;
       
        background:rgb(112, 146, 182);
    }

    .header{
        background:rgb(112, 146, 182);
        color: white;
        padding: 15px;
        /* border-radius: 10px; */
        text-align: center;
        margin-bottom: 20px;

    }

</style>

<body>
    <div class="container">
        <h4 class="mt-5 header">Leave Request</h4>

        <!-- display error and success msg -->
        <?php if ($error) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success) :?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
            



        <!-- leave request form -->

        <div class="form-container  shadow">
            <form action="leave_request.php" method="post">

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date : </label>
                    <input type="date" name="start_date" id="start_date" class="form-control w-25 mb-3 " required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date : </label>
                    <input type="date" name="end_date" id="end_date" class="form-control w-25" required>
                </div>
                
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason : </label>
                    <textarea class="form-control w-50" name="reason" id="reason" rows="3"  required></textarea>
                </div>

                <button class="btn p-2 leave" type="submit" name="submit">Submit Leave Request</button>

            </form>

        </div>
        
    </div>


    <!-- leaves status -->

<div class="container">
<h4 class="header  mt-5">Leave status</h4>

<div class="table-container text-center  mt-4">

        


<table class="table table-striped table-bordered">
    <thead class="table-info">
        <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        if (mysqli_num_rows($leave_result) > 0){
            while ($row = mysqli_fetch_assoc($leave_result)){
                echo "<tr>
                          <td>{$row['start_date']}</td>
                          <td>{$row['end_date']}</td>
                          <td>{$row['reason']}</td>

                          <td><span class='badge bg-" . ($row['status'] == 'Approved' ? 'success' : 
                                                      ($row['status'] == 'Rejected' ? 'danger' : 'warning')) . " '>
                                                      {$row['status']}</span></td>

                </tr>";
            } 
        }else{
            echo "<tr><td colspan='5' >No leave requests found.</td></tr>";
        }
        ?>

    </tbody>

</table>

</div>

</div>


    












</body>
</html>