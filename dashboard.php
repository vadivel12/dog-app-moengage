<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
function matchCode($code, $pattern) {
    $regex = str_replace('x', '\\d', $pattern);
    return preg_match("/^$regex$/", $code);
}
$responseCodes = ["200", "201", "202", "203", "204", "300", "301", "302", "400", "401"];
$filter = $_GET['filter'] ?? '';
$matched = [];
foreach ($responseCodes as $code) {
    if (matchCode($code, $filter)) {
        $matched[] = $code;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HTTP Dog Filter</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            min-height: 100vh;
            padding-top: 40px;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
        }

        .form-control:focus {
            border-color: #2a5298;
            box-shadow: none;
        }

        .btn-custom {
            background-color: #2a5298;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #1e3c72;
        }

        .img-thumbnail {
            margin: 10px;
            border: 2px solid #2a5298;
            border-radius: 10px;
        }

        a {
            color: #2a5298;
            text-decoration: none;
            margin: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        h2 {
            color: #2a5298;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">HTTP Dog Filter</h2>

        <!-- Filter Form -->
        <form method="get" class="mb-4">
            <div class="input-group">
                <input type="text" name="filter" class="form-control" placeholder="e.g. 2xx, 203" required>
                <button type="submit" class="btn btn-custom">Filter</button>
            </div>
        </form>

        <!-- Display Filtered Images -->
        <div class="text-center">
            <?php foreach ($matched as $code): ?>
                <img src="https://http.dog/<?php echo $code; ?>.jpg" alt="<?php echo $code; ?>" class="img-thumbnail" width="200">
            <?php endforeach; ?>
        </div>

        <!-- Save List Form -->
        <?php if (!empty($matched)): ?>
        <form method="post" action="save_list.php" class="mt-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <input type="text" name="list_name" class="form-control" placeholder="List Name" required>
                    <input type="hidden" name="codes" value="<?php echo implode(',', $matched); ?>">
                </div>
                <div class="col-md-4 d-grid">
                    <button type="submit" class="btn btn-custom">Save List</button>
                </div>
            </div>
        </form>
        <?php endif; ?>

        <!-- Navigation Links -->
        <div class="text-center mt-4">
            <a href="view_lists.php">View My Lists</a> |
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
