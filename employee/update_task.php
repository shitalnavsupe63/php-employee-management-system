<?php 
// session_start();

include '../database/connection.php';

$employee_id = $_SESSION['company_id'];
$db_id = $_SESSION['user_id'];

// Fetch tasks assigned to the logged-in employee
$query = "SELECT * FROM tasks WHERE assigned_to = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $db_id);
$stmt->execute();
$result = $stmt->get_result();


if(isset($_POST['update_task'])){
    $task_id = $_POST['task_id'];
    $submission_link = $_POST['submission_link'];
    $submission_text = $_POST['submission_text'];

    $uploaded_images = [];
    if(!empty($_FILES['submission_images']['name'][0])){
        $upload_dir = "../uploads/";

        foreach($_FILES['submission_images']['tmp_name'] as $key => $tmp_name){
            $image_name = time(). "_". $_FILES['submission_images']['name'][$key];
            move_uploaded_file($tmp_name, $upload_dir.$image_name);
            $uploaded_images[] = $image_name;
        }
    }

    $query = "SELECT submission_images FROM tasks WHERE  id=? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $existing_images = !empty($row['submission_images']) ? explode(',', $row['submission_images']) : [];

    $final_images = array_merge($existing_images, $uploaded_images);
    $final_images_str = implode(',', $final_images);

    // update db
    $update_query = "UPDATE tasks SET submission_link=?, submission_images=?, submission_text=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $submission_link, $final_images_str, $submission_text, $task_id);

    if($stmt->execute()){
        $_SESSION['success'] = "Task Updated Successfully!";
    }else{
        $_SESSION['error'] = "Failed to update task.";
    }

    header("Location: dashboard.php");
    exit();
}
?>

<?php if(mysqli_num_rows($result) > 0) : ?>

<?php while ($row = mysqli_fetch_assoc($result)) : ?>

<div class="modal fade" id="editTaskModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editTaskModalLabel<?php echo $row['id'];?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel<?php echo $row['id'];?>">Edit task submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="update_task.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Task Link</label>
                        <input type="url" name="submission_link" class="form-control" value="<?php echo htmlspecialchars($row['submission_link']); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Existing Images</label>
                            <div class="d-flex flex-wrap">
                                <?php
                                    $images = explode(',', $row['submission_images']);
                                    foreach ($images as $image) {
                                        if (!empty($image)) {
                                            echo '<img src="../uploads/' . $image . '" class="img-thumbnail m-1" style="width: 100px; height: 100px;">';
                                        }
                                    }
                                ?>
                            </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload New Images</label>
                            <input type="file" name="submission_images[]" class="form-control" multiple>
                            <small>Leave empty to keep existing images.</small>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Additional Notes</label>
                        <textarea name="submission_text" id="submission_text" class="form-control" rows="3"><?php echo htmlspecialchars($row['submission_text']); ?></textarea>
                    </div>

                    <button type="submit" name="update_task" class="btn btn-outline-primary">Update task</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>

<?php else: ?>
    <p class="alert alert-warning">No tasks available for editing.</p>
<?php endif;?>






