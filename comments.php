<?php
include('db.php');

// Handle search
$search = $_GET['search'] ?? '';
$sql = "SELECT c.*, a.title AS app_title 
        FROM comments c 
        LEFT JOIN applications a ON c.application_id = a.id 
        WHERE c.name LIKE '%$search%' OR a.title LIKE '%$search%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments</title>
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

<!-- ✅ Content Overlay -->
<div class="overlay">
    <h2 class="text-center mb-4">💬 Comments</h2>

    <div class="mb-4 text-center">
        <a href="index.php" class="btn btn-outline-secondary">← Back to Home Page</a>
    </div>

    <form class="mb-4 d-flex" method="GET">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by app or name..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary">Search</button>
    </form>

    <a href="create_comments.php" class="btn btn-success mb-3">+ Add New Comment</a>

    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>App</th>
                <th>Name</th>
                <th>Comment</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Created</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['app_title']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['comment']) ?></td>
                <td><?= htmlspecialchars($row['rating']) ?></td>
                <td>
                    <?php if ($row['status'] == 'active'): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                </td>
                <td><?= date('d M Y h:i A', strtotime($row['created'])) ?></td>
                <td><?= date('d M Y h:i A', strtotime($row['modified'])) ?></td>
                <td>
                    <a href="edit_comments.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_comments.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this comment?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
