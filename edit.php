<?php
include('db.php');

// Get application by ID
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid request.";
    exit;
}

// Fetch existing application data
$stmt = $conn->prepare("SELECT * FROM applications WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$app = $result->fetch_assoc();

if (!$app) {
    echo "Application not found.";
    exit;
}

// Fetch categories
$categories = $conn->query("SELECT * FROM categories WHERE status='active'");

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $review = $_POST['review'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];
    $modified = date('Y-m-d H:i:s');

    $image_name = $app['image'];
    $image_dir = $app['image_dir'];

    // Check if new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $image_dir = 'uploads';
        move_uploaded_file($tmp_name, "$image_dir/$image_name");
    }

    $update = $conn->prepare("UPDATE applications SET category_id=?, posted_data=?, author=?, title=?, review=?, image=?, image_dir=?, status=?, modified=? WHERE id=?");
    $update->bind_param("sssssssssi", $category_id, $author, $author, $title, $review, $image_name, $image_dir, $status, $modified, $id);

    if ($update->execute()) {
        echo "<script>alert('Application updated successfully!'); window.location='applications.php';</script>";
    } else {
        echo "<script>alert('Update failed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Application</title>
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

<!-- ✅ Form Overlay -->
<div class="overlay">
    <h2 class="mb-4 text-center">✏️ Edit Application</h2>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow rounded">
        <div class="mb-3">
            <label class="form-label">App Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($app['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($app['author']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Review</label>
            <textarea name="review" class="form-control" rows="4" required><?= htmlspecialchars($app['review']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select a category</option>
                <?php while($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $app['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active" <?= $app['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $app['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Current Image:</label><br>
            <img src="<?= $app['image_dir'] . '/' . $app['image'] ?>" width="100"><br><br>
            <label class="form-label">Change Image (optional):</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="applications.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
