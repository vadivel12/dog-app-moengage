<?php
session_start();
include 'db.php';
$name = $_GET['name'];
$user = $_SESSION['user'];
$result = $conn->query("SELECT * FROM lists WHERE user_email='$user' AND name='$name'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit List: <?php echo htmlspecialchars($name); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #232526, #414345);
            color: #fff;
            padding-top: 50px;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            background-color: #fff;
            color: #333;
            padding: 30px;
            border-radius: 12px;
            max-width: 700px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.25);
        }

        h2 {
            color: #333;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: bold;
            color: #414345;
        }

        .dog-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
        }

        .dog-item img {
            border-radius: 8px;
            border: 2px solid #adb5bd;
        }

        .form-check-input {
            transform: scale(1.3);
            margin-top: 10px;
        }

        .btn-custom {
            background-color: #414345;
            color: #fff;
            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: #232526;
        }

        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mx-auto">
        <h2>Edit List: <?php echo htmlspecialchars($name); ?></h2>

        <form method="post" action="update_list.php">
            <!-- Hidden original name to identify the list -->
            <input type="hidden" name="original_name" value="<?php echo htmlspecialchars($name); ?>">

            <!-- Editable list name -->
            <div class="mb-4">
                <label for="new_name" class="form-label">List Name</label>
                <input type="text" id="new_name" name="new_name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>

            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="dog-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="codes[]" value="<?php echo htmlspecialchars($row['code']); ?>" checked>
                    </div>
                    <img src="<?php echo htmlspecialchars($row['img']); ?>" alt="Dog <?php echo htmlspecialchars($row['code']); ?>" width="100">
                    <span class="badge bg-secondary"><?php echo htmlspecialchars($row['code']); ?></span>
                </div>
            <?php endwhile; ?>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-custom">Update List</button>
                <a href="view_lists.php" class="btn btn-outline-secondary btn-back">← Back</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
