<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Interactive Feedback Tree</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: none;
      min-height: 100vh;
      padding: 0;
      overflow-x: hidden;
      overflow-y: auto;
    }

    /* Background Video Styling */
    .video-bg {
      position: fixed;
      top: 0;
      left: 0;
      min-width: 100%;
      min-height: 100%;
      object-fit: cover;
      z-index: -2;
      opacity: 0.8;
    }

    .page-background {
      background-image: url('');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      min-height: 100vh;
      padding: 40px 20px;
      position: relative;
    }

    .page-background::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: rgba(255, 255, 255, 0.0);
      z-index: 0;
    }

    .page-background > * {
      position: relative;
      z-index: 1;
    }

    header {
      background: #ffffffcc;
      backdrop-filter: blur(5px);
      padding: 15px 20px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    header .top-bar {
      display: flex;
      width: 100%;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      margin: 0;
      font-size: 1.5rem;
      color: #2f6627;
    }

    nav {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    nav a {
      text-decoration: none;
      background: #4CAF50;
      color: white;
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      font-size: 0.9rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    nav a:hover {
      background: #388e3c;
    }

    .filter-form {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
      margin-top: 15px;
      width: 100%;
    }

    .filter-form label {
      font-weight: bold;
      font-size: 0.9rem;
    }

    .filter-form select,
    .filter-form button {
      padding: 20px 40px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 0.9rem;
    }

    .filter-form button {
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .filter-form button:hover {
      background-color: #388e3c;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    @media (max-width: 600px) {
      nav {
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
      }

      .filter-form {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>

<!-- Background Video -->
<video class="video-bg" autoplay muted loop>
  <source src="/Dev Projects/EQAP Feedback trees/vids/bg_2.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>

<header>
  <div class="top-bar">
    <h1>🌳 Feedback Tree</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="feedback_form.php">Submit Feedback</a>
      <a href="">Admin Dashboard</a>
    </nav>

  </div>

  
</header>

<div class="container page-background">
