<?php 
session_start();

include '../database/connection.php';
include 'admin-sidebar.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $holiday_name = $_POST['holiday_name'];
    $holiday_date = $_POST['holiday_date'];

    $query = "INSERT INTO holidays (holiday_name, holiday_date) VALUES 
            ('$holiday_name', '$holiday_date' )";

    mysqli_query($conn, $query);

    header("Location: manage_holidays.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manage holiday</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<style>
    body{
        background-color: rgb(204, 214, 227);
    }

    .card{
        border: none;
        border-radius: 15px;
    }

    .card-header{
        background:rgb(112, 146, 182);
        color: white;
        font-size: 18px;
        padding: 10px;
        border-radius: 10px;
        text-align: center;
    }

    .form-control{
        max-width: 600px;
    }
    .table th{
        background-color:rgb(165, 187, 225);
    }
    
</style>
<body>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Add New Holiday</h2>
            </div>


            <div class="card-body">
                <form class="form" action="" method="post">
                        <div class="mt-3">
                            <label for="" class="form-label">Holiday Name :</label>
                            <input type="text" class="form-control" name="holiday_name" required>
                        </div>

                        <div class="mt-2">
                            <label for="" class="form-label">Date :</label>
                            <input type="date" class="form-control" name="holiday_date" required>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-warning" name="submit" type="submit">Add Holiday</button>
                        </div>
                </form>
            </div>

        </div>

    <div class="card mt-5">

        <div class="card-header">
            <h2 class="text-center">Existing Holiday</h2>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">
                <tr>
                    <th>Holiday Name</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                    
                <?php 
                    $result = mysqli_query($conn, "SELECT * FROM holidays ORDER BY holiday_date");
                    while ($row = mysqli_fetch_assoc($result)){
                    echo "<tr>
                        <td>{$row['holiday_name']}</td>
                        <td>{$row['holiday_date']}</td>
                        <td><a class='btn btn-danger' href='delete_holiday.php?id={$row['id']}'>Delete</a></td>
                    </tr>";
                    }
                ?>
            </table>
        </div>      
    </div>
        
</div>


    

</body>
</html>