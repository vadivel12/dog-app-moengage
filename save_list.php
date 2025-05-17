<?php
session_start();
include 'db.php';
$user = $_SESSION['user'];
$list_name = $_POST['list_name'];
$codes = explode(',', $_POST['codes']);
$date = date("Y-m-d");
foreach ($codes as $code) {
    $img = "https://http.dog/$code.jpg";
    $conn->query("INSERT INTO lists (user_email, name, code, img, created_at) VALUES ('$user', '$list_name', '$code', '$img', '$date')");
}
header("Location: view_lists.php");
?>