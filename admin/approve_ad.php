<?php
include('../config/db.php');
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') { exit; }

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    mysqli_query($conn, "UPDATE ads SET status = 'active' WHERE id = '$id'");
    header("Location: dashboard.php?filter=pending&success=1");
}