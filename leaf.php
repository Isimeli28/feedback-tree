<?php
// Simulate one feedback row
$feedback = [
  'category' => 'Suggestion',
  'message' => 'We appreciate the recent improvements, but it would be even better if more training sessions were available for the team on using the updated system effectively and efficiently.',
  'image_path' => 'uploads/sample.jpg', // use '' to test fallback
  'created_at' => '2025-06-23 12:00:00'
];

// Helper functions
function getBorderColor($category) {
  return match ($category) {
    'Praise' => '#91d8f7',
    'Concern' => '#f7a8a8',
    'Suggestion' => '#a8f7b5',
    default => '#ccc'
  };
}

function getInitials($str) {
  return strtoupper(substr(preg_replace('/\s+/', '', $str), 0, 2));
}

// Limit message to 30 words
function limitWords($text, $limit = 30) {
  $words = preg_split('/\s+/', strip_tags($text));
  if (count($words) > $limit) {
    $words = array_slice($words, 0, $limit);
    return implode(' ', $words) . '...';
  }
  return implode(' ', $words);
}

$borderColor = getBorderColor($feedback['category']);
$imgSrc = $feedback['image_path'];
$initials = getInitials($feedback['message']);
$popupText = limitWords($feedback['message'], 30);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leaf with Click Popup</title>
  <style>
    body {
      font-family: sans-serif;
      background: #eefbe7;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .leaf {
      position: relative;
      width: 120px;
      height: 120px;
      clip-path: ellipse(60% 45% at 50% 50%);
      border: 3px solid <?= $borderColor ?>;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
      cursor: pointer;
      background-color: white;
      overflow: hidden;
      transition: transform 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .leaf:hover {
      transform: scale(1.05);
    }

    .leaf img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      position: absolute;
      top: 0;
      left: 0;
    }

    .fallback {
      z-index: 1;
      font-size: 2rem;
      background-color: #f1f1f1;
      padding: 10px 15px;
      border-radius: 10px;
      color: #333;
    }

   .leaf-wrapper {
  position: relative;
  display: inline-flex;
  flex-direction: column;
  align-items: center;
}

.popup-card {
  position: absolute;
  top: 140px;
  background: white;
  border: 1px solid #ccc;
  padding: 12px;
  border-radius: 10px;
  box-shadow: 0 8px 16px rgba(0,0,0,0.25);
  width: 260px;
  text-align: center;
  font-size: 0.85rem;
  opacity: 0;
  visibility: hidden;
  transform: scale(0.95);
  transition: all 0.3s ease;
  pointer-events: none;
  z-index: 10;
}

.leaf-wrapper.active .popup-card {
  opacity: 1;
  visibility: visible;
  transform: scale(1);
  pointer-events: auto;
}

  </style>
</head>
<body>
  <div class="leaf-wrapper" onclick="this.classList.toggle('active')">
    <div class="leaf" style="border-color: <?= $borderColor ?>;">
      <?php if ($imgSrc && file_exists($imgSrc)): ?>
        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Feedback Image">
      <?php else: ?>
        <div class="fallback"><?= htmlspecialchars($initials) ?></div>
      <?php endif; ?>
    </div>
    
    <div class="popup-card">
      <strong><?= htmlspecialchars($feedback['category']) ?></strong><br>
      <?= htmlspecialchars($popupText) ?><br>
      <small>🕒 <?= date("F j, Y", strtotime($feedback['created_at'])) ?></small>
    </div>
  </div>
</body>

</html>
