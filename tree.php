<?php
include 'db.php';

$filter = $_GET['filter'] ?? 'All';
$order = $_GET['order'] ?? 'DESC';

$query = "SELECT * FROM feedback";
if ($filter !== 'All') {
  $query .= " WHERE category = '" . $conn->real_escape_string($filter) . "'";
}
$query .= " ORDER BY created_at $order";

$result = $conn->query($query);

function getBorderColor($category) {
  return match ($category) {
    'Praise' => '#91d8f7',
    'Concern' => '#f7a8a8',
    'Suggestion' => '#a8f7b5',
    default => '#ccc'
  };
}

function getInitials($str) {
  return strtoupper(substr($str, 0, 2));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Animated Feedback Tree</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: url('tree-bg.png') center bottom no-repeat, linear-gradient(to bottom, #e6ffe6, #ffffff);
      background-size: contain;
      min-height: 100vh;
      padding: 20px;
      overflow-x: hidden;
    }

    h1 {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 1rem;
    }

    .filters {
      text-align: center;
      margin-bottom: 1rem;
    }

    .tree {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
      gap: 20px;
      justify-items: center;
      padding: 20px;
      max-width: 1200px;
      margin: auto;
    }

    .leaf {
      position: relative;
      width: 110px;
      height: 110px;
      clip-path: ellipse(60% 45% at 50% 50%);
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      transition: transform 0.3s ease;
      border: 3px solid #ccc;
      background-color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      animation: sway 6s ease-in-out infinite;
      cursor: pointer;
      flex-direction: column;
    }

    .leaf:hover {
      transform: scale(1.1);
    }

    .leaf img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
    }

    .fallback {
      font-size: 2rem;
      color: #333;
      background-color: #f1f1f1;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .message-overlay {
      position: relative;
      z-index: 2;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 4px 6px;
      font-size: 0.7rem;
      text-align: center;
      border-radius: 5px;
      max-width: 90%;
      word-wrap: break-word;
    }

    .tooltip {
      position: absolute;
      top: 120%;
      left: 50%;
      transform: translateX(-50%) scale(0);
      transform-origin: top;
      width: 220px;
      background: white;
      border: 1px solid #ccc;
      border-radius: 12px;
      padding: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      opacity: 0;
      pointer-events: none;
      transition: all 0.3s ease;
      z-index: 100;
    }

    .leaf.active .tooltip {
      opacity: 1;
      pointer-events: auto;
      transform: translateX(-50%) scale(1);
    }

    @keyframes sway {
      0%, 100% { transform: rotate(-2deg); }
      50% { transform: rotate(2deg); }
    }

    @media (max-width: 600px) {
      .tooltip {
        width: 180px;
        font-size: 0.85rem;
      }
    }
  </style>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll('.leaf').forEach(leaf => {
        leaf.addEventListener('click', e => {
          document.querySelectorAll('.leaf').forEach(el => {
            if (el !== leaf) el.classList.remove('active');
          });
          leaf.classList.toggle('active');
        });
      });
    });
  </script>
</head>
<body>
  <h1>🌳 Interactive Feedback Tree</h1>
  <div class="filters">
    <form method="GET">
      <label>Filter:</label>
      <select name="filter">
        <option value="All">All</option>
        <option value="Suggestion" <?= $filter === 'Suggestion' ? 'selected' : '' ?>>Suggestion</option>
        <option value="Praise" <?= $filter === 'Praise' ? 'selected' : '' ?>>Praise</option>
        <option value="Concern" <?= $filter === 'Concern' ? 'selected' : '' ?>>Concern</option>
      </select>

      <label>Sort:</label>
      <select name="order">
        <option value="DESC" <?= $order === 'DESC' ? 'selected' : '' ?>>Newest</option>
        <option value="ASC" <?= $order === 'ASC' ? 'selected' : '' ?>>Oldest</option>
      </select>

      <button type="submit">➕ Apply</button>
    </form>
  </div>

  <div class="tree">
    <?php while ($row = $result->fetch_assoc()):
      $borderColor = getBorderColor($row['category']);
      $imgSrc = $row['image_path'] ?? '';
      $initials = getInitials($row['message']);
    ?>
      <div class="leaf" style="border-color: <?= $borderColor ?>;">
        <?php if ($imgSrc && file_exists($imgSrc)): ?>
          <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($row['category']) ?>">
        <?php else: ?>
          <div class="fallback"><?= htmlspecialchars($initials) ?></div>
        <?php endif; ?>
        <div class="message-overlay">
          <?= htmlspecialchars($row['message']) ?>
        </div>
        <div class="tooltip">
          <strong><?= htmlspecialchars($row['category']) ?></strong><br>
          <?= htmlspecialchars($row['message']) ?><br>
          <small>🕒 <?= date("F j, Y", strtotime($row['created_at'])) ?></small>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
