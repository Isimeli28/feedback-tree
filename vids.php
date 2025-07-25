<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Video Background Page</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: Arial, sans-serif;
      overflow: hidden;
    }

    /* Video background styling */
    .video-bg {
      position: fixed;
      top: 0;
      left: 0;
      min-width: 100%;
      min-height: 100%;
      z-index: -1;
      object-fit: cover;
    }

    /* Overlay content */
    .content {
      position: relative;
      z-index: 1;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
    }
  </style>
</head>
<body>

  <!-- Background Video -->
  <video class="video-bg" autoplay muted loop>
    <source src="http://localhost:8080/images/vids/bg.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
  </video>

  <!-- Page Content -->
  <div class="content">
    <h1>Welcome</h1>
  </div>

</body>
</html>
