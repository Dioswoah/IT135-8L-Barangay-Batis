<?php
include('../inc/topbar.php');
if(empty($_SESSION['admin-username'])) {
    header("Location: login.php");
}

// Delete announcement
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete announcement from the database
    $sql = "DELETE FROM announcements WHERE id = :id";
    $statement = $dbh->prepare($sql);
    $statement->execute([':id' => $delete_id]);

    if ($statement) {
        $_SESSION['success'] = 'Announcement Deleted Successfully';
    } else {
        $_SESSION['error'] = 'Problem Deleting Announcement';
    }
}

// Fetch all announcements
$sql = "SELECT * FROM announcements ORDER BY date_posted DESC";
$statement = $dbh->prepare($sql);
$statement->execute();
$announcements = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List Announcements - <?php echo $sitename; ?></title>
    <link rel="shortcut icon" href="../<?php echo $logo; ?>" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>List of Announcements</h2>
            <a href="index.php" class="btn btn-primary mb-3">Back to Home</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date Posted</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($announcements as $announcement): ?>
                    <tr>
                        <td><?php echo $announcement['title']; ?></td>
                        <td><?php echo $announcement['content']; ?></td>
                        <td><?php echo $announcement['date_posted']; ?></td>
                        <td>
                            <a href="edit-announcement.php?id=<?php echo $announcement['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="?delete_id=<?php echo $announcement['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this announcement?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
