<?php
session_start();

include '../database/connection.php';

if (isset($_POST['submit_task'])) {
    $task_id = $_POST['task_id'];
    $submission_link = $_POST['submission_link'];
    $submission_text = $_POST['submission_text'];

    // Handle multiple image uploads
    $image_paths = [];
    $upload_dir = "uploads/"; // Ensure this folder exists
    foreach ($_FILES['submission_images']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['submission_images']['name'][$key]);
        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($tmp_name, $target_file)) {
            $image_paths[] = $target_file;
        }
    }
    $submission_images = implode(",", $image_paths); // Store as a comma-separated string

    // Update task submission details
    $query = "UPDATE tasks SET submission_link = ?, submission_images = ?, submission_text = ?, status = 'Completed' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $submission_link, $submission_images, $submission_text, $task_id);

    if ($stmt->execute()) {
        echo "<script>alert('Task submitted successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error submitting task.');</script>";
    }
}
?>
