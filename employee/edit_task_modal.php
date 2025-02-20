<?php 
while ($row = mysqli_fetch_assoc($result)) : ?>

<div class="modal fade" id="editTaskModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit task submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="update_task.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">

                    <div class="mb-3">
                        <label for="" class="form-label">Task Link</label>
                        <input type="url" name="submission_link" class="form-control" value="<?php echo htmlspecialchars($row['submission_link']);?>">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Upload New Images</label>
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







