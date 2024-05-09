<?php
include('../inc/topbar.php');
if(empty($_SESSION['admin-username'])) {
    header("Location: login.php");
}

include('../inc/db_connection.php'); // Include your database connection file

if(isset($_POST["btnpost"])) {
    $title = $_POST['txttitle'];
    $content = $_POST['txtcontent'];
    $date_posted = date("Y-m-d H:i:s"); // Current date and time

    // Validate inputs
    if(empty($title) || empty($content)) {
        $_SESSION['error'] = 'Please fill in all fields';
    } else {
        // Insert announcement details into the database
        $sql = 'INSERT INTO announcements (title, content, date_posted) VALUES (:title, :content, :date_posted)';
        $statement = $dbh->prepare($sql);
        $success = $statement->execute([
            ':title' => $title,
            ':content' => $content,
            ':date_posted' => $date_posted
        ]);

        if ($success) {
            header("Location: list-announcements.php"); // Redirect after successful insertion
            exit(); // Ensure script stops here after redirection
        } else {
            $_SESSION['error'] = 'Problem Posting Announcement';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barangay Announcement - <?php echo $sitename; ?></title>
    <link rel="shortcut icon" href="../<?php echo $logo; ?>" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Announcement</div>
                <div class="card-body">
                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['error']; ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="txttitle">Title:</label>
                            <input type="text" class="form-control" id="txttitle" name="txttitle" required>
                        </div>
                        <div class="form-group">
                            <label for="txtcontent">Content:</label>
                            <textarea class="form-control" id="txtcontent" name="txtcontent" rows="5" required></textarea>
                        </div>
                        <button type="submit" name="btnpost" class="btn btn-primary">Post Announcement</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
