<?php
// intro.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Intro Animation</title>
  <style>
    /* Full screen intro animation styling */
    body, html {
      margin: 0; padding: 0; height: 100%;
      overflow: hidden;
      background-color: #222;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-family: Arial, sans-serif;
    }

    .intro-text {
      font-size: 3rem;
      animation: pulse 10s ease forwards;
    }

    @keyframes pulse {
      0% { opacity: 0; transform: scale(0.8); }
      50% { opacity: 1; transform: scale(1.1); }
      100% { opacity: 0; transform: scale(1); }
    }
  </style>
</head>
<body>

  <div class="intro-text">
    Welcome to My Site!
  </div>

  <script>
    // Redirect to index.php after 3 seconds
    setTimeout(() => {
      window.location.href = 'index.php';
    }, 10000);
  </script>

</body>
</html>
