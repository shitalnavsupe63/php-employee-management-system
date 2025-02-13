<?php

session_start();

include '../database/connection.php';

include 'employee-sidebar.php';

$query = "SELECT * FROM holidays ORDER BY holiday_date";
$result = mysqli_query($conn, $query);

// $events = [];

// while ($row = mysqli_fetch_assoc($result)){
//     $events[] = [
//         'title'=>$row['holiday_name'],
//         'start'=>$row['holiday_date']
//     ];
// }

// echo  json_encode($events);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>holiday-calender</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<style>
    body{
        background-color: rgb(204, 214, 227);
    }

    .table{
        background: white;
        border-radius: 10px;
        overflow: hidden;
        /* max-width: 800px; */
        /* margin-left: 250px; */
    }

    .table th{
        background-color:rgb(165, 187, 225);
    }

</style>

<body>
    <div class="container mt-2 ">
        <h2 class="text-center mb-4">Holiday Calender</h2>

        <div class="text-center ">

        <table class="table text-center  table-bordered table-striped">
            
            <thead>
                <tr class="table-row" >
                    <th>Holiday Name</th>
                    <th>Date</th>
                    <th>Day</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_assoc($result)) {?>
                <tr>
                    <td><?php echo $row['holiday_name'];?></td>
                    <td><?php echo date("d-M-Y", strtotime($row['holiday_date']));?></td>
                    <td><?php echo $row['holiday_day'];?></td>
                </tr>
            <?php } ?>
        </table>

        </div>

    </div>

    <!-- <div id="calendar"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: 'holidays_json.php'
            });

            calendar.render();
        });
    </script> -->


</body>
</html>

