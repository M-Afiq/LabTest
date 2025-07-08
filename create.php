<?php
include('db.php');

// Fetch categories for dropdown
$categories = $conn->query("SELECT * FROM categories WHERE status='active'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $review = $_POST['review'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];

    $created = date('Y-m-d H:i:s');
    $modified = date('Y-m-d H:i:s');

    // Handle image upload
    $image_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = 'uploads';
    $target_file = $upload_dir . '/' . $image_name;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir);
    }

    move_uploaded_file($tmp_name, $target_file);

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO applications (category_id, posted_data, author, title, review, image, image_dir, status, created, modified)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $category_id, $author, $author, $title, $review, $image_name, $upload_dir, $status, $created, $modified);

    if ($stmt->execute()) {
        echo "<script>alert('Application added successfully!'); window.location='applications.php';</script>";
    } else {
        echo "<script>alert('Failed to add application.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Application</title>
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

<!-- ✅ Overlay Form -->
<div class="overlay">
    <h2 class="mb-4 text-center">➕ Add New Application</h2>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow rounded">
        <div class="mb-3">
            <label class="form-label">App Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Review</label>
            <textarea name="review" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select a category</option>
                <?php while($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['title']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="applications.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
