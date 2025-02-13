<?php
// Ensure $result is available to iterate
$query = "SELECT id FROM tasks WHERE assigned_to = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $db_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php while ($row = mysqli_fetch_assoc($result)) : ?>
<!-- Modal -->
<div class="modal fade" id="submitTaskModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="submitTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitTaskModalLabel">Submit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="submit_task.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Task Link</label>
                        <input type="url" name="submission_link" class="form-control" placeholder="Enter task link">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Images</label>
                        <input type="file" name="submission_images[]" class="form-control" multiple>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Additional Notes</label>
                        <textarea name="submission_text" class="form-control" rows="3" placeholder="Enter task details"></textarea>
                    </div>

                    <button type="submit" name="submit_task" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
