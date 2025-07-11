<?php
session_start();
include("database.php");

// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Delete profile entry for this user
$delete_stmt = mysqli_prepare($connection, "DELETE FROM profile WHERE user_id = ?");
mysqli_stmt_bind_param($delete_stmt, "i", $user_id);

if (mysqli_stmt_execute($delete_stmt)) {
    header("Location: ../dashboard.php?section=profile&success=deleted");
} else {
    header("Location: ../dashboard.php?section=profile&error=delete_failed");
}
exit();
?>
