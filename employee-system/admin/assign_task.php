<?php

session_start();

include '../database/connection.php';
include 'admin-sidebar.php';

$error = '';
$success = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $deadline = $_POST['deadline'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];

    $sql = "INSERT INTO tasks (deadline, description, assigned_to) VALUES ('$deadline','$description', '$assigned_to')";
    
    if (mysqli_query($conn, $sql)){
        $success = "Task assigned successfully";
    }else{
        $error = "Error assigning task";
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assign_task</title>

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

    .form-group label{
        font-weight: bold;
    }

    .form-control{
        border-radius: 8px;
    }

    .alert{
        margin-left: 20px;
        display: flex;
        justify-content: center;
    }

    .table th, .table td{
        vertical-align: middle;
    }

    
</style>



<body>
    <div class="container mt-3">
        <div class="card shadow ">
            <div class="card-header">
                <h4>Task Status</h4>
            </div>

            <div class="card-body mt-3">

            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>Deadline</th>
                        <th>Employee ID </th>
                        <th>Employee Name</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    <?php
                        $query = "SELECT tasks.deadline, tasks.assigned_to, tasks.status, employees.employee_id,  employees.fullname
                                 FROM tasks join employees on tasks.assigned_to = employees.id";

                        $result = mysqli_query($conn, $query);

                        while ($row = $result->fetch_assoc()){

                        echo "<tr>
                                 <td>{$row['deadline']}</td>
                                 <td>{$row['employee_id']}</td>
                                 <td>{$row['fullname']}</td>
                                 <td>{$row['status']}</td>
                            </tr>";
                        }
                    ?>
                </tbody>


            </table>

            </div>

        </div>


        <div class="card mt-5">
            <div class="card-header">
                <h4>Assign a task</h4>
            </div>

            <?php if ($success): ?>
                    <div class="alert alert-success text-center w-50 mt-3"><?= $success ?></div>
            <?php endif; ?>

            <?php if ($error) : ?>
                <div class="alert alert-danger text-center w-50 mt-3"><?= $error ?></div>
            <?php endif; ?>
                
            <div class="card-body">
                <form action="assign_task.php" method="post">
                    <div class="form-group">
                        <label for="deadline" class="form-label">Deadline : </label>
                        <input type="date" class="form-control w-50" name="deadline" id="deadline" required>
                       
                        <label for="assigned_to" class="form-label mt-3">Assign to : </label>
                        <select class="form-select w-50" name="assigned_to" id="assigned_to" required>
                            <option value="">Employee</option>
                        
                            <?php 
                                $query = "SELECT * FROM employees where is_admin='0' ";
                                $result = mysqli_query($conn, $query);
                            ?>

                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['fullname']; ?>

                            </option>
                            <?php endwhile; ?>
                    
                         </select>

                    </div>

                    <div class="form-group mt-3">

                         <label class="form-label" for="description">Task : </label>
                         <textarea class="form-control" name="description" id="description" rows="4" required></textarea>

                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Assign Task</button>

                </form>

                

            </div>

        </div>

        

        

    </div>
</body>
</html>