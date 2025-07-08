<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LabTest | Main Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
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
            background: transparent;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .menu-wrapper {
            background-color: rgba(255, 255, 255, 0.75);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }

        .menu-wrapper h2 {
            font-family: 'Segoe UI', sans-serif;
            color: #333;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .menu-card {
            width: 100%;
            margin: 15px auto;
            padding: 25px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .menu-card:hover {
            transform: scale(1.05);
        }

        .menu-card a {
            font-size: 1.5rem;
            padding: 15px 25px;
        }
    </style>
</head>
<body>

<!-- ✅ Background Video -->
<video autoplay muted loop class="video-bg">
    <source src="image/bg.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
</video>

<!-- ✅ Main Menu Overlay -->
<div class="overlay">
    <div class="menu-wrapper">
        <h2 class="display-5 fw-bold mb-4">📱Mobile Application Review</h2>

        <div class="menu-card">
            <a href="applications.php" class="btn btn-primary w-100 fs-4 py-3">📱 Applications</a>
        </div>
        <div class="menu-card">
            <a href="categories.php" class="btn btn-success w-100 fs-4 py-3">🗂️ Categories</a>
        </div>
        <div class="menu-card">
            <a href="comments.php" class="btn btn-warning w-100 fs-4 py-3">💬 Comments</a>
        </div>
    </div>
</div>

</body>
</html>
