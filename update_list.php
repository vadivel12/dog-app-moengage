<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Grab the original name (hidden input) and new name (editable field)
$original_name = $conn->real_escape_string($_POST['original_name']);
$new_name = $conn->real_escape_string($_POST['new_name']);

// Codes selected in the form, might be empty array
$codes = isset($_POST['codes']) ? $_POST['codes'] : [];

// Start transaction to avoid partial updates
$conn->begin_transaction();

try {
    // 1. If the list name changed, update it in the DB first
    if ($original_name !== $new_name) {
        $updateNameSql = "UPDATE lists SET name='$new_name' WHERE user_email='$user' AND name='$original_name'";
        $conn->query($updateNameSql);
    }

    // 2. Delete all codes linked to the updated list name (because we’ll re-insert)
    $conn->query("DELETE FROM lists WHERE user_email='$user' AND name='$new_name'");

    // 3. Insert new codes with new list name
    $stmt = $conn->prepare("INSERT INTO lists (user_email, name, code, img, created_at) VALUES (?, ?, ?, ?, NOW())");
    foreach ($codes as $code) {
        $img = "https://http.dog/$code.jpg";
        $stmt->bind_param("ssss", $user, $new_name, $code, $img);
        $stmt->execute();
    }

    $conn->commit();

    // Redirect back to view lists page after success
    header("Location: view_lists.php");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    echo "Failed to update list: " . $e->getMessage();
    exit;
}
?>
