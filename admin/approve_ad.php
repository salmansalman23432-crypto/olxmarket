<?php
session_start();
include('../config/db.php');

// حماية الصفحة
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') { exit("Access Denied"); }

$id = $_GET['id'];
$query = "UPDATE ads SET status = 'active' WHERE id = '$id'";

if (mysqli_query($conn, $query)) {
    header("Location: dashboard.php?msg=approved");
}
?>