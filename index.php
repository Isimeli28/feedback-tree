<?php
// index.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EQAP Feedback Tree</title>
  <style>
    /* Full screen overlay for intro */
    #intro {
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: black;
      color: white;
      font-size: 3rem;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      overflow: hidden;
      animation: fadeOut 1s ease forwards;
      animation-delay: 0.5s; /* show for 4 seconds */
    }

    /* Fade out animation */
    @keyframes fadeOut {
      to {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
      }
    }

    /* Hide main content initially */
    #main-content {
      display: none;
    }

    /* Background video styles */
    #intro video {
      position: absolute;
      top: 50%;
      left: 50%;
      min-width: 100%;
      min-height: 100%;
      width: auto;
      height: auto;
      transform: translate(-50%, -50%);
      object-fit: cover;
      z-index: -1; /* behind text */
      filter: brightness(0.5); /* darken video for text contrast */
    }

    /* Intro text styles */
    #intro .intro-text {
      position: relative;
      z-index: 1;
      text-align: center;
      font-weight: bold;
      text-shadow: 0 0 10px rgba(0,0,0,0.8);
    }
  </style>
</head>
<body>

<div id="intro">
  <video autoplay muted loop playsinline>
    <source src="http://192.168.8.166/:8080/Dev%20Projects/EQAP%20Feedback%20trees/vids/bg_2.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>
  <div class="intro-text">EQAP Feedback Tree</div>
</div>

<div id="main-content">
  <?php include 'header.php'; ?>
  <?php include 'feedback_tree.php'; ?>
  <footer><?php include 'footer.php'; ?></footer>
</div>

<script>
  window.addEventListener('load', () => {
    // Show main content after 5.5 seconds (video + fade)
    setTimeout(() => {
      document.getElementById('intro').style.display = 'none';
      document.getElementById('main-content').style.display = 'block';
    }, 100);
  });
</script>

</body>
</html>
