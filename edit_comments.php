<?php
include('db.php');

// Get comment by ID
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid request.";
    exit;
}

// Fetch comment
$stmt = $conn->prepare("SELECT * FROM comments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$comment = $result->fetch_assoc();

if (!$comment) {
    echo "Comment not found.";
    exit;
}

// Fetch apps for dropdown
$apps = $conn->query("SELECT id, title FROM applications WHERE status='active'");

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app_id = $_POST['application_id'];
    $name = $_POST['name'];
    $text = $_POST['comment'];
    $rating = $_POST['rating'];
    $status = $_POST['status'];
    $modified = date('Y-m-d H:i:s');

    $update = $conn->prepare("UPDATE comments SET application_id=?, name=?, comment=?, rating=?, status=?, modified=? WHERE id=?");
    $update->bind_param("ssssssi", $app_id, $name, $text, $rating, $status, $modified, $id);

    if ($update->execute()) {
        echo "<script>alert('Comment updated successfully!'); window.location='comments.php';</script>";
    } else {
        echo "<script>alert('Update failed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Comment</title>
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
    <h2 class="text-center mb-4">✏️ Edit Comment</h2>

    <form method="POST" class="bg-white p-4 shadow rounded">
        <div class="mb-3">
            <label class="form-label">Application</label>
            <select name="application_id" class="form-select" required>
                <option value="">Select application</option>
                <?php while ($app = $apps->fetch_assoc()): ?>
                    <option value="<?= $app['id'] ?>" <?= $app['id'] == $comment['application_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($app['title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Your Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($comment['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Comment</label>
            <textarea name="comment" class="form-control" rows="4" required><?= htmlspecialchars($comment['comment']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Rating</label>
            <select name="rating" class="form-select" required>
                <option value="">Select rating</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>" <?= $comment['rating'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active" <?= $comment['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $comment['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="comments.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
