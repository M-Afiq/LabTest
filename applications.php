<?php
include('db.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM applications WHERE title LIKE '%$search%' OR author LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
        }

        .overlay {
            position: relative;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.85);
            margin: 40px auto;
            padding: 40px;
            border-radius: 16px;
            max-width: 1200px;
        }
    </style>
</head>
<body>

<!-- ✅ Background Video -->
<video autoplay muted loop class="video-bg">
    <source src="image/background.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
</video>

<!-- ✅ Page Content Overlay -->
<div class="overlay">
    <h2 class="mb-4 text-center">📱 Application Reviews</h2>

    <div class="mb-4 text-center">
        <a href="index.php" class="btn btn-outline-secondary">← Back to Home Page</a>
    </div>

    <form class="mb-4 d-flex" method="GET">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by title or author..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary">Search</button>
    </form>

    <a href="create.php" class="btn btn-success mb-3">+ Add New Application</a>

    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Author</th>
                <th>Review</th>
                <th>Status</th>
                <th>Created</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <img src="<?= $row['image_dir'] . '/' . $row['image'] ?>" width="80" height="80" alt="App Image">
                </td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= htmlspecialchars($row['review']) ?></td>
                <td>
                    <?php if (strtolower($row['status']) == 'active'): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Inactive</span>
                    <?php endif; ?>
                </td>
                <td><?= date("d M Y h:i A", strtotime($row['created'])) ?></td>
                <td><?= date("d M Y h:i A", strtotime($row['modified'])) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this app?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
