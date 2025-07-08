<?php
include('db.php');

// Get ID from URL
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid request.";
    exit;
}

// Fetch comment to verify existence
$stmt = $conn->prepare("SELECT * FROM comments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$comment = $result->fetch_assoc();

if (!$comment) {
    echo "Comment not found.";
    exit;
}

// Perform delete
$delete = $conn->prepare("DELETE FROM comments WHERE id = ?");
$delete->bind_param("i", $id);

if ($delete->execute()) {
    echo "<script>alert('Comment deleted successfully.'); window.location='comments.php';</script>";
} else {
    echo "<script>alert('Failed to delete comment.'); window.location='comments.php';</script>";
}
?>
