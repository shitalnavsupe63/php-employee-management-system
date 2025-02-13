<?php
session_start();
include '../database/connection.php';
include 'admin-sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Tasks</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<style>
    body {
        background: rgb(204, 214, 227);
    }

    .container {
        max-width: 1200px;
    }

    .card {
        border: none;
        border-radius: 15px;
    }

    .card-header {
        background: rgb(112, 146, 182);
        color: white;
        font-size: 20px;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .submission-images img {
        width: 50px;
        height: 50px;
        margin: 2px;
        border-radius: 5px;
    }
</style>

<body>
    <div class="container mt-3">
        <div class="card shadow">
            <div class="card-header">
                <h4>Submitted Tasks</h4>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="table-info text-center">
                        <tr>
                            <th>Task ID</th>
                            <th>Employee</th>
                            <th>Submission Link</th>
                            <th>Notes</th>
                            <th>Images</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        <?php
                        $query = "SELECT ts.*, e.fullname 
                                  FROM task_submissions ts 
                                  JOIN employees e ON ts.employee_id = e.id";
                        $result = mysqli_query($conn, $query);

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['task_id']}</td>
                                    <td>{$row['fullname']}</td>
                                    <td><a href='{$row['submission_link']}' target='_blank'>View Link</a></td>
                                    <td>{$row['submission_notes']}</td>
                                    <td class='submission-images'>";
                            
                            // Display images
                            if (!empty($row['submission_images'])) {
                                $images = json_decode($row['submission_images']);
                                foreach ($images as $image) {
                                    echo "<img src='../uploads/$image' />";
                                }
                            } else {
                                echo "No images";
                            }

                            echo "</td>
                                  <td>{$row['submitted_at']}</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
