<?php
session_start();

include '../database/connection.php';

include 'employee-sidebar.php';

if (!isset($_SESSION['user_id'])){
    die("Error: employee not logged in ");
}

$db_id = $_SESSION['user_id'];

$query = "SELECT * FROM tasks WHERE assigned_to = ? ";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $db_id);
$stmt->execute();
$result=$stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted tasks</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<style>
    body{
        background: rgb(204, 214, 227);
    }

    .table{
        background: white;
        border-radius: 10px;
        overflow: hidden;
    }
    .header {
        background: rgb(112, 146, 182);
        color: white;
        font-size: 20px;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
    }

    .img-preview img{
        width: 80px;
        height: 80px;
        object-fit: cover;
        margin-right: 5px;
        border-radius: 5px;
    }
</style>
<body>
    <div class="container">
        <h5 class="header">My submitted tasks</h5>

        <?php if(mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-info text-center">
                    <tr>
                        <th>Task ID</th>
                        <th>Submission Link</th>
                        <th>Submitted Images</th>
                        <th>Notes</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) : ?>
                        <tr class="text-center">
                            <td><?php echo $row['id'];?></td>
                            <td><a href="<?php echo $row['submission_link']; ?>" target="_blank" class="btn btn-primary btn-sm">View</a></td>
                            <td class="img-preview">
                            <?php
                            $images = explode(',', $row['submission_images']);
                            foreach ($images as $image) {
                                if (!empty($image)) {
                                    echo '<img src="../uploads/' . $image . '" alt="Task Image">';
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['submission_text']);?></td>
                        </tr>

                    <?php endwhile;?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-success">No submitted tasks found.</p>
        <?php endif;?>
    </div>
</body>
</html>