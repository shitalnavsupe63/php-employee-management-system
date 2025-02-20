<?php
session_start();

include '../database/connection.php';
include 'admin-sidebar.php';

// if (!isset($_SESSION['role'])) {
//         header('Location: login.php');
//         exit();
//     }


// count of total no of employees
$employees_query = "SELECT COUNT(*) AS total_employees FROM employees";
$employees_result = mysqli_query($conn, $employees_query);
$total_employees = mysqli_fetch_assoc($employees_result)['total_employees'];

// employees currently on leave
$leave_query = "SELECT COUNT(DISTINCT employees.id) AS employees_on_leave FROM employees JOIN leaves ON employees.id = leaves.employee_id WHERE CURDATE() BETWEEN leaves.start_date AND leaves.end_date AND leaves.status = 'Approved'";
$leave_result = mysqli_query($conn, $leave_query);
$employees_on_leave = mysqli_fetch_assoc($leave_result)['employees_on_leave'] ?? 0;

// total leaves in current year 
$leaves_yearly_query = "SELECT COUNT(*) AS total_leaves FROM leaves WHERE YEAR(start_date) = YEAR(CURDATE()) AND status = 'Approved'";
$leaves_yearly_result = mysqli_query($conn, $leaves_yearly_query);
$total_leaves = mysqli_fetch_assoc($leaves_yearly_result)['total_leaves'];

// leave by each employee
$employee_leaves_query = "SELECT employees.fullname, COUNT(leaves.id) AS leave_count FROM employees LEFT JOIN leaves ON employees.id = leaves.employee_id AND leaves.status = 'Approved' GROUP BY employees.id";
$employee_leaves_result = mysqli_query($conn, $employee_leaves_query);

// Query to get task summary
$task_query = "SELECT 
    (SELECT COUNT(*) FROM tasks WHERE status = 'Completed') AS completed_tasks,
    (SELECT COUNT(*) FROM tasks WHERE status = 'Pending') AS pending_tasks";
$task_result = mysqli_query($conn, $task_query);
$task_data = mysqli_fetch_assoc($task_result);
$completed_tasks = $task_data['completed_tasks'];
$pending_tasks = $task_data['pending_tasks'];

// Query to get list of employees with completed & pending tasks
$employee_tasks_query = "SELECT employees.fullname, tasks.status FROM tasks JOIN employees ON tasks.assigned_to = employees.id WHERE tasks.status IN ('Completed', 'Pending')";
$employee_tasks_result = mysqli_query($conn, $employee_tasks_query);


// list of employees
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

        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Employees</h5>
                        <p class="card-text display-6"><?php echo $total_employees; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Employees on Leave</h5>
                        <p class="card-text display-6"><?php echo $employees_on_leave; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Leaves Taken</h5>
                        <p class="card-text display-6"><?php echo $total_leaves; ?></p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">Task Summary</div>
                    <div class="card-body">
                        <p>Completed Tasks: <strong><?php echo $completed_tasks; ?></strong></p>
                        <p>Pending Tasks: <strong><?php echo $pending_tasks; ?></strong></p>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-secondary text-white">Task Status of Employees</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Task Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($employee_tasks_result)) { ?>
                                    <tr>
                                        <td><?php echo $row['fullname']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->


        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">Employee Leave Count</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Leave Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($employee_leaves_result)) { ?>
                                    <tr>
                                        <td><?php echo $row['fullname']; ?></td>
                                        <td><?php echo $row['leave_count']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

        <!-- employee list -->

        <div class="container mt-5" id="employee_list">
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
        
        </div>
        
        <!-- <div class="btn-container">
            <a class="btn btn-primary p-2" href="assign_task.php">Go to assign task</a>
            <a class="btn btn-info p-2" href="manage_leaves.php">Go to manage leaves</a>
        </div> -->

    </div>

</body>
</html>