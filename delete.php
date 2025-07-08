<?php
include('db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid request.";
    exit;
}

// Get the image path before deleting
$stmt = $conn->prepare("SELECT image, image_dir FROM applications WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$app = $result->fetch_assoc();

if (!$app) {
    echo "Application not found.";
    exit;
}

// Delete the image file (optional)
$image_path = $app['image_dir'] . '/' . $app['image'];
if (file_exists($image_path)) {
    unlink($image_path); // Remove the image file
}

// Delete the record from DB
$delete = $conn->prepare("DELETE FROM applications WHERE id = ?");
$delete->bind_param("i", $id);

if ($delete->execute()) {
    echo "<script>alert('Application deleted successfully.'); window.location='applications.php';</script>";
} else {
    echo "<script>alert('Failed to delete application.'); window.location='applications.php';</script>";
}
?>
