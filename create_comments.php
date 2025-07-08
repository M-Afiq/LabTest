<?php
include('db.php');

// Fetch applications for dropdown
$apps = $conn->query("SELECT id, title FROM applications WHERE status='active'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app_id = $_POST['application_id'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    $status = $_POST['status'];

    $created = date('Y-m-d H:i:s');
    $modified = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO comments (application_id, name, comment, rating, status, created, modified)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $app_id, $name, $comment, $rating, $status, $created, $modified);

    if ($stmt->execute()) {
        echo "<script>alert('Comment added successfully!'); window.location='comments.php';</script>";
    } else {
        echo "<script>alert('Failed to add comment.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Comment</title>
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
            max-width: 700px;
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
    <h2 class="text-center mb-4">➕ Add New Comment</h2>

    <form method="POST" class="bg-white p-4 shadow rounded">
        <div class="mb-3">
            <label class="form-label">Application</label>
            <select name="application_id" class="form-select" required>
                <option value="">Select an application</option>
                <?php while ($app = $apps->fetch_assoc()): ?>
                    <option value="<?= $app['id'] ?>"><?= htmlspecialchars($app['title']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Your Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Comment</label>
            <textarea name="comment" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Rating (1 to 5)</label>
            <select name="rating" class="form-select" required>
                <option value="">Select rating</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="comments.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
