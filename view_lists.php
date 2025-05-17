<?php
session_start();
include 'db.php';
$user = $_SESSION['user'];
$lists = $conn->query("SELECT DISTINCT name FROM lists WHERE user_email='$user'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Saved Lists</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #fff;
            min-height: 100vh;
            padding-top: 50px;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            background-color: #ffffff;
            color: #333;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
            max-width: 600px;
        }

        h2 {
            color: #2c5364;
            margin-bottom: 25px;
        }

        .list-item {
            padding: 15px;
            margin-bottom: 10px;
            background-color: #f1f1f1;
            border-radius: 8px;
        }

        .list-item strong {
            font-size: 1.2rem;
        }

        .action-links a {
            margin-left: 15px;
            text-decoration: none;
            color: #2c5364;
            font-weight: bold;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: block;
            margin-top: 30px;
            color: #fff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container mx-auto">
        <h2>Your Saved Lists</h2>

        <?php while($row = $lists->fetch_assoc()): ?>
            <div class="list-item d-flex justify-content-between align-items-center">
                <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                <div class="action-links">
                    <a href="edit_list.php?name=<?php echo urlencode($row['name']); ?>">Edit</a>
                    <a href="delete_list.php?name=<?php echo urlencode($row['name']); ?>">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>

        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
