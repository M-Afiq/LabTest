<?php
include('db.php');

// Get ID from URL
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid request.";
    exit;
}

// Fetch category to verify existence
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if (!$category) {
    echo "Category not found.";
    exit;
}

// Perform delete
$delete = $conn->prepare("DELETE FROM categories WHERE id = ?");
$delete->bind_param("i", $id);

if ($delete->execute()) {
    echo "<script>alert('Category deleted successfully.'); window.location='categories.php';</script>";
} else {
    echo "<script>alert('Failed to delete category.'); window.location='categories.php';</script>";
}
?>
