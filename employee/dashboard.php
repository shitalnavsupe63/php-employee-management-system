<?php

session_start();

include '../database/connection.php';
include '../employee/employee-sidebar.php';

if (!isset($_SESSION['user_id'])) {
    die("Error: Employee not logged in.");
}

$employee_id = $_SESSION['company_id'];
$db_id = $_SESSION['user_id'];

// echo "<p>Debug: Employee ID = $employee_id</p>";
// echo "<p>Debug: DB ID = $db_id</p>";

//  Handle status update using GET request
if (isset($_GET['action']) && isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $action = $_GET['action'];

    echo "<p>Debug: Task ID = $task_id</p>";

    //  Ensure valid action values
    if ($action == 'in-progress' || $action == 'completed') {
        $new_status = ($action == 'in-progress') ? 'In progress' : 'Completed';

        $update_query = "UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sii", $new_status, $task_id, $db_id);

        if ($stmt->execute()) {
            echo "<script>alert('Task status updated successfully!'); window.location='dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating status.');</script>";
        }
    }
}


$query = "SELECT id, deadline, description, status FROM tasks WHERE assigned_to = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $db_id);
$stmt->execute();
$result = $stmt->get_result();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>employee-dashboard</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>


<style>
    body{
        background:rgb(204, 214, 227);
    }

    .table{
        background: white;
        border-radius: 10px;
        overflow: hidden;
    }

    .btn{
       
        padding:10px 10px;
        border-radius: 10px;
    }


    .header{
        background:rgb(112, 146, 182);
        color: white;
        font-size: 20px;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
    }

    @media (max-width: 768px){
        .table{
            font-size: 14px;
        }

        .btn{
            padding:5px 10px;
            font-size: 12px;
        }
    }

    .welcome-user{
        width: 30%;
        background:rgb(112, 146, 182);
        color: white;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        text-align: left;
    }

</style>

<body>
    <!-- assigned tasks -->
    <div class="container mt-3">

        <div class="start mt-3 d-flex justify-content-between">
            <div class="welcome-user">
                <h5>Welcome, <?php echo $_SESSION['fullname']; ?></h>
                <p class="employee-id mt-2">Employee ID : <?php echo $_SESSION['company_id'];?></p>
            </div>
            <!-- <div class="logout" >
                <a href="../employee/login.php?logout='1'" class="btn logout p-2 btn-danger">Logout</a>
            </div> -->
            
        </div>

       
        <h5 class="header">Assigned Tasks</h5>

        <?php if (mysqli_num_rows($result) > 0): ?>

        <table class="table table-striped table-bordered">
            <thead class="table-info text-center">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                 
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
               
                    <tr class="text-center">
                        <td><?php echo $row['deadline']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <!-- <td><?php echo $row['status']; ?></td> -->
                       
                        <td>
                            <?php 
                                 if ($row['status'] == 'Pending'){
                                    echo '<span class="badge bg-danger">Pending</span>';
                                 }elseif ($row['status'] == 'In progress'){
                                    echo '<span class="badge bg-warning ">In Progress</span>';
                                 }else{
                                    echo '<span class="badge bg-success">Completed</span>';
                                 }
                            ?>
                        </td>

                        <td>
                            <a href="dashboard.php?action=in-progress&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">In Progress</a>
                            <a href="dashboard.php?action=completed&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Completed</a>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#submitTaskModal<?php echo $row['id']; ?>">Submit Task</button>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editTaskModal<?php echo $row['id']; ?>">Edit</button>

                        </td>

                    </tr>

                    <?php include 'update_task.php';?>

                <?php endwhile; ?>
            
            </tbody>

        </table>

    <?php else: ?>
        <p class="alert alert-info">No tasks pending</p>
    
    <?php endif; ?>

    <?php include 'taskModal.php'; ?>
    
    </div>

    <!-- <div class="container text-center mt-5">
        <a href="leave_request.php" class="btn btn-info p-3" style="font-size:19px;">Apply for leave</a>
    </div> -->

    <!-- <?php
    // include 'leave_request.php';
    ?> -->

<script>
document.addEventListener("DOMContentLoaded", function () {
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function (modal) {
        new bootstrap.Modal(modal);
    });
});
</script>


</body>
</html>


