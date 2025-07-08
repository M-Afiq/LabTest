<?php
include('db.php');

// Get category by ID
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid request.";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if (!$category) {
    echo "Category not found.";
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $status = $_POST['status'];
    $modified = date('Y-m-d H:i:s');

    $update = $conn->prepare("UPDATE categories SET title=?, status=?, modified=? WHERE id=?");
    $update->bind_param("sssi", $title, $status, $modified, $id);

    if ($update->execute()) {
        echo "<script>alert('Category updated successfully!'); window.location='categories.php';</script>";
    } else {
        echo "<script>alert('Failed to update category.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
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
            max-width: 600px;
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
    <h2 class="mb-4 text-center">✏️ Edit Category</h2>

    <form method="POST" class="bg-white p-4 shadow rounded">
        <div class="mb-3">
            <label class="form-label">Category Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($category['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active" <?= $category['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $category['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="categories.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
