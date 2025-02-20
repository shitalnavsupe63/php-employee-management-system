<?php

session_start();

include '../database/connection.php'; 
include 'admin-sidebar.php';

// Query to get completed tasks with descriptions and images
$completed_tasks_query = "SELECT tasks.id, tasks.description, tasks.submission_text, tasks.submission_link, tasks.submission_images, employees.fullname FROM tasks 
JOIN employees ON tasks.assigned_to = employees.id 
WHERE tasks.status = 'Completed'";
$completed_tasks_result = mysqli_query($conn, $completed_tasks_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Tasks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<style>
    body{
        background:rgb(204, 214, 227);
    }

    .container{
        max-width: 1200px;
    }

    .card-header{
        background:rgb(112, 146, 182);
        color: white;
        font-size: 20px;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
    }

    .table th{
        vertical-align: middle;
    }

</style>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 card-header">Completed Tasks</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>Employee Name</th>
                            <th>Description</th>
                            <th>Submission Link</th>
                            <th>Additional Notes</th>
                            <th>Images</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($completed_tasks_result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($row['submission_link']); ?>" target="_blank">View</a></td>
                                <td><?php echo nl2br(htmlspecialchars($row['submission_text']));?></td>
                                <td>
                                    <div style="display: flex; flex-wrap: wrap; gap: 5px;"> 
                                    <?php 
                                    $images = explode(',', $row['submission_images']);
                                    foreach ($images as $image) {
                                        $image = trim($image);
                                        if (!empty($image)) {
                                            $imagePath = "../uploads/". htmlspecialchars($image);
                                            if (file_exists($imagePath)){
                                                echo "<a href='#' data-bs-toggle='modal' data-bs-target='#imageModal' data-bs-image='$imagePath'>
                                                        <img src='$imagePath' alt='Task Image' class='img-thumbnail' width='100'></a>";
                                            }else{
                                                echo "<p>Image not found: $image</p>";
                                            }
                                        }
                                    }
                                    ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- image modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>

                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Preview Image">
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            var imageModal = document.getElementById("imageModal");
            imageModal.addEventListener("show.bs.modal", function(event){
                var button = event.relatedTarget;
                var imageUrl = button.getAttribute("data-bs-image");
                var modalImage = document.getElementById("modalImage");
                
                console.log("opening modal with image: ", imageUrl);

                if (imageUrl){
                    modalImage.src = imageUrl;
                }else{
                    modalImage.src = "../uploads/default.png";
                }
                
            });
        });
    </script>








</body>
</html>
