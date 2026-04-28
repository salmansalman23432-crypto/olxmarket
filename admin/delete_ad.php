<?php
include('../config/db.php');
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') { exit; }

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    mysqli_query($conn, "DELETE FROM ads WHERE id = '$id'");
    header("Location: dashboard.php?deleted=1");
}