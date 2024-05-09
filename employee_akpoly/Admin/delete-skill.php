<?php
include('../inc/topbar.php');

// Check if the user is logged in
if(empty($_SESSION['admin-username'])) {
    header("Location: login.php");
    exit(); // Stop further execution
}

// Check if the 'id' parameter is set in the URL
if(isset($_GET['id'])) {
    // Get the 'id' value from the URL
    $id = $_GET['id'];

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM tblskill WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);

    // Redirect to the edit_skill.php page after deleting
    header("Location: edit_skill.php");
    exit(); // Stop further execution
} else {
    // Redirect to edit_skill.php if 'id' parameter is not set
    header("Location: edit_skill.php");
    exit(); // Stop further execution
}
?>
