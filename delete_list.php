<?php
session_start();
include 'db.php';
$name = $_GET['name'];
$user = $_SESSION['user'];
$conn->query("DELETE FROM lists WHERE user_email='$user' AND name='$name'");
header("Location: view_lists.php");
?>