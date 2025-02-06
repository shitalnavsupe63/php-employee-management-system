<?php
session_start();

include '../database/connection.php';
include 'admin-sidebar.php';

$query = "SELECT * FROM employees where is_admin='0' ";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin-dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<style>
    body{
        background:rgb(204, 214, 227);
    }

    .header{
        background:rgb(112, 146, 182);
        color: white;
        font-size: 20px;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
    }

    .table-container{
        padding: 20px;
        border-radius: 10px;

    }

    .btn-container{
        display: flex;
        justify-content: center;
        gap: 15px;
    
    }

    @media(max-width: 768px){
        .table{
            font-size: 14px;
        }
        .btn{
            font-size: 14px;
            padding: 8px 15px;
        }
    }

</style>

<body>

    <div class="container mt-3">

        <!-- employee list -->

        <h5 class="header">Employee List</h5>

        <div class="table-container ">

        <table class="table table-striped table-bordered">

            <thead class="table-light">

                <tr class="text-center">
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>

                </tr>

            </thead>

            <tbody>

                <?php while ($row = mysqli_fetch_assoc($result)){  ?>

                    <tr class="text-center">
                        <td><?php echo $row['employee_id']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                    </tr>
                <?php } ?>

            </tbody>

        </table>

        </div>
        
        <!-- <div class="btn-container">
            <a class="btn btn-primary p-2" href="assign_task.php">Go to assign task</a>
            <a class="btn btn-info p-2" href="manage_leaves.php">Go to manage leaves</a>
        </div> -->

    </div>

</body>
</html>