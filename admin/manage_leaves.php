<?php

session_start();

include '../database/connection.php';
include 'admin-sidebar.php';

$query = "SELECT leaves.id, employees.employee_id, leaves.start_date, leaves.end_date, leaves.reason, leaves.status, employees.fullname, employees.email
         FROM leaves JOIN employees ON leaves.employee_id = employees.id WHERE leaves.status = 'Pending'";

$result = mysqli_query($conn, $query);


if (isset($_GET['action']) && isset($_GET['id'])){
    $leave_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'approve'){
        $update_query = "UPDATE leaves SET status = 'Approved' WHERE id = '$leave_id'";

    }elseif  ($action === 'reject'){
        $update_query = "UPDATE leaves SET status = 'Rejected' WHERE id='$leave_id'";

    }

    mysqli_query($conn, $update_query);

    header("Location: manage_leaves.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manage_leaves</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<style>
    body{
        background:rgb(204, 214, 227);
    }

    .container{
        max-width: 1200px;
    }

    .card{
        border: none;
        border-radius: 15px;
    }

    .card-header{
        background:rgb(112, 146, 182);
        color: white;
        font-size: 20px;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
    }

    .table{
        border-radius: 8px;
    }

    .badge{
        font-size: 0.9rem;
    }

    .btn{
        border-radius: 8px;
        padding: 8px 15px;
    }

    .btn:hover{
        opacity: 0.8;
    }
    
    .btn-success {
        background-color: #28a745;
        border: none;
    }
    
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
        
</style>
<body>

    <div class="container">

        <div class="card mt-5">
            <div class="card-header">
                <h4>Manage Pending Leaves</h4>
            </div>

            <div class="card-body">
                <?php if (mysqli_num_rows($result) > 0): ?>

                    <table class="table table-striped table-bordered ">
                        <thead>
                            <tr class="text-center">
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Email</th>
                                <th>Reason</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th> 
                                <th>Actions</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr class="text-center">
                                    <td><?php echo $row['employee_id'];?></td>
                                    <td><?php echo $row['fullname'];?></td>
                                    <td><?php echo $row['email'];?></td>
                                    <td><?php echo $row['reason'];?></td>
                                    <td><?php echo $row['start_date'];?></td>
                                    <td><?php echo $row['end_date'];?></td>
                                    <td>
                                       <?php 
                                            if ($row['status'] == 'Pending') {
                                                    echo '<span class="badge bg-warning">Pending</span>';
                                            } elseif ($row['status'] == 'Approved') {
                                                    echo '<span class="badge bg-success">Approved</span>';
                                            } else {
                                                    echo '<span class="badge bg-danger">Rejected</span>';
                                            }
                                        ?>
                                    </td>

                                    <td>
                                        <a href="manage_leaves.php?action=approve&id=<?php echo $row['id']; ?>" class="btn btn-success">Approve</a>
                                         <a href="manage_leaves.php?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-danger">Reject</a>
                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                 <?php else: ?>
                    <p>No pending leave requests found.</p>

                <?php endif; ?>

            </div>

        </div>

    </div>

</body>
</html>