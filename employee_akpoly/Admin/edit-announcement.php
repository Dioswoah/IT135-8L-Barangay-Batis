<?php
include('../inc/topbar.php');
if(empty($_SESSION['admin-username'])) {
    header("Location: login.php");
}

// Fetch announcement details based on ID
if(isset($_GET['id'])) {
    $announcement_id = $_GET['id'];
    
    // Fetch announcement details from the database
    $sql = "SELECT * FROM announcements WHERE id = :id";
    $statement = $dbh->prepare($sql);
    $statement->execute([':id' => $announcement_id]);
    $announcement = $statement->fetch(PDO::FETCH_ASSOC);
    
    if(!$announcement) {
        $_SESSION['error'] = 'Announcement not found';
        header("Location: index.php");
        exit();
    }
}

// Update announcement
if(isset($_POST['update_announcement'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $announcement_id = $_POST['announcement_id'];

    // Form validation
    if(empty($title) || empty($content)) {
        $_SESSION['error'] = 'Title and content cannot be empty';
    } else {
        // Update announcement in the database
        $sql = "UPDATE announcements SET title = :title, content = :content WHERE id = :id";
        $statement = $dbh->prepare($sql);
        $result = $statement->execute([':title' => $title, ':content' => $content, ':id' => $announcement_id]);

        if($result) {
            $_SESSION['success'] = 'Announcement updated successfully';
            header("Location: list-announcements.php"); // Redirect to list-announcements.php
            exit();
        } else {
            $_SESSION['error'] = 'Error updating announcement';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Announcement - <?php echo $sitename; ?></title>
    <link rel="shortcut icon" href="../<?php echo $logo; ?>" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Edit Announcement</h2>
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <form method="post" action="">
                <input type="hidden" name="announcement_id" value="<?php echo $announcement['id']; ?>">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $announcement['title']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control" name="content" rows="5" required><?php echo $announcement['content']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="update_announcement">Update Announcement</button>
                <a href="list-announcements.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
