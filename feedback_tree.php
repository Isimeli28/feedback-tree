<?php
include 'db.php';

// Filtering & Sorting
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
  return strtoupper(substr(preg_replace('/\s+/', '', $str), 0, 2));
}
?>

<div class="filter-card">
  <div class="filters" id="feedback-tree">
    <form method="GET">
      <label>Filter:</label>
      <select name="filter">
        <option value="All" <?= $filter === 'All' ? 'selected' : '' ?>>All</option>
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
</div>


<div class="tree-background">
  <div class="tree">
    <?php
   $positions = [
    ['top' => 494, 'left' => 215], // index 0
    ['top' => 88, 'left' => 322],  // index 1
    ['top' => 75, 'left' => 407],  // index 2
    ['top' => 504, 'left' => 304], // index 3
    ['top' => 477, 'left' => 407], // index 4
    ['top' => 221, 'left' => 110], // index 5
    ['top' => 388, 'left' => 74],  // index 6
    ['top' => 230, 'left' => 213], // index 7
    ['top' => 336, 'left' => 243], // index 8
    ['top' => 237, 'left' => 384], // index 9
    ['top' => 509, 'left' => 488], // index 10
    ['top' => 81,  'left' => 492], // index 11
    ['top' => 476, 'left' => 579], // index 12
    ['top' => 160, 'left' => 616], // index 13
    ['top' => 532, 'left' => 771], // index 14 (updated)
    ['top' => 341, 'left' => 1043],// index 15 (updated)
    ['top' => 301, 'left' => 63],  // index 16
    ['top' => 294, 'left' => 154], // index 17
    ['top' => 423, 'left' => 332], // index 18
    ['top' => 339, 'left' => 339], // index 19
    ['top' => 155, 'left' => 451], // index 20
    ['top' => 239, 'left' => 472], // index 21
    ['top' => 236, 'left' => 558], // index 22
    ['top' => 235, 'left' => 640], // index 23
    ['top' => 303, 'left' => 696], // index 24 (updated)
    ['top' => 417, 'left' => 1085],// index 25 (updated)
    ['top' => 157, 'left' => 168], // index 26
    ['top' => 374, 'left' => 160], // index 27
    ['top' => 418, 'left' => 238], // index 28
    ['top' => 162, 'left' => 367], // index 29
    ['top' => 400, 'left' => 427], // index 30
    ['top' => 325, 'left' => 515], // index 31 (updated)
    ['top' => 156, 'left' => 535], // index 32
    ['top' => 396, 'left' => 599], // index 33
    ['top' => 384, 'left' => 685], // index 34
    ['top' => 507, 'left' => 947], // index 35 (updated)
    ['top' => 107, 'left' => 964], // index 36 (updated from 69)
    ['top' => 457, 'left' => 131], // index 37
    ['top' => 173, 'left' => 280], // index 38
    ['top' => 258, 'left' => 302], // index 39
    ['top' => 326, 'left' => 430], // index 40
    ['top' => 410, 'left' => 511], // index 41 (updated)
    ['top' => 487, 'left' => 1036], // index 42 (updated)
    ['top' => 315, 'left' => 603], // index 43
    ['top' => 465, 'left' => 667], // index 44
    ['top' => 514, 'left' => 860], // index 45 (updated)
    ['top' => 358, 'left' => 869],  // index 46
    ['top' => 343, 'left' => 953],  // index 47
    ['top' => 266, 'left' => 965],  // index 48 (updated)
    ['top' => 189, 'left' => 1008], // index 49 (updated)
    ['top' => 120, 'left' => 874],  // index 50 (updated)
    ['top' => 195, 'left' => 822],  // index 51 (updated)
    ['top' => 43,  'left' => 854],  // index 52 (updated)
    ['top' => 415, 'left' => 990],  // index 53 (updated)
    ['top' => 437, 'left' => 825],  // index 54 (updated)
    ['top' => 261, 'left' => 1053], // index 55 (updated)
    ['top' => 367, 'left' => 781],  // index 56
    ['top' => 286, 'left' => 791],  // index 57 (updated)
    ['top' => 197, 'left' => 918],  // index 58
    ['top' => 269, 'left' => 876],  // index 59 (updated)
    ['top' => 215, 'left' => 730],  // index 60 (updated)
    ['top' => 192, 'left' => 920],  // index 61
    ['top' => 44,  'left' => 770],  // index 62
    ['top' => 45,  'left' => 678],  // index 63
    ['top' => 519, 'left' => 925],  // index 64
    ['top' => 125, 'left' => 705],  // index 65
    ['top' => 395, 'left' => 430],  // index 66
    ['top' => 85,  'left' => 609],  // index 67 (updated)
    ['top' => 120, 'left' => 874],  // index 68 (updated)
    ['top' => 107, 'left' => 964],  // index 69 (updated)
    ['top' => 450, 'left' => 744],  // index 70 (updated)
];

    $i = 0;
    while ($row = $result->fetch_assoc()):
      $imgSrc = $row['image_path'] ?? '';
      $initials = getInitials($row['message']);
      $top = $positions[$i % count($positions)]['top'];
      $left = $positions[$i % count($positions)]['left'];
      $i++;
    ?>
      <div class="leaf-wrapper" style="position: absolute; top: <?= $top ?>px; left: <?= $left ?>px;">
        <div class="leaf" style="border-color: <?= $borderColor ?>;">
          <?php if ($imgSrc && file_exists($imgSrc)): ?>
            <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($row['category']) ?>">
          <?php else: ?>
            <div class="fallback"><?= htmlspecialchars($initials) ?></div>
          <?php endif; ?>
        </div>
        <div class="popup-card">
          
          <?= htmlspecialchars($row['message']) ?><br>
          <small>🕒 <?= date("F j, Y", strtotime($row['created_at'])) ?></small>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.leaf-wrapper').forEach(wrapper => {
      wrapper.addEventListener('click', e => {
        e.stopPropagation();
        document.querySelectorAll('.leaf-wrapper').forEach(w => {
          if (w !== wrapper) w.classList.remove('active');
        });
        wrapper.classList.toggle('active');
      });
    });

    document.addEventListener('click', () => {
      document.querySelectorAll('.leaf-wrapper').forEach(w => w.classList.remove('active'));
    });
  });
</script>

<style>
  .filter-card {
  background: #ffffffcc;
  backdrop-filter: blur(6px);
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  margin: 30px 0;
}

.filters form {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  align-items: center;
}

.filters label {
  font-weight: bold;
}

.filters select,
.filters button {
  padding: 8px 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 0.95rem;
}

.filters button {
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
  transition: background 0.3s ease;
}

.filters button:hover {
  background-color: #388e3c;
}

  .tree-background {
    background-image: url('images/trees.png');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    position: relative;
    width: 100%;
    height: 1100px;
  }
  .tree {
    position: relative;
    width: 100%;
    height: 100%;
  }
  .leaf-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 260px;
    cursor: pointer;
  }
  .leaf {
    position: relative;
    width: 70px;
    height: 80px;
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
    flex-direction: column;
  }
  .leaf:hover {
    transform: scale(3);
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
  .popup-card {
    position: absolute;
    top: 130%;
    left: 50%;
    transform: translateX(-50%) scale(0.95);
    background: white;
    border: 2px solid #ccc;
    border-radius: 12px;
    padding: 12px;
    width: 240px;
    max-width: 90vw;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    opacity: 0;
    visibility: hidden;
    transition: all 0.35s ease;
    z-index: 10;
    pointer-events: none;
  }
  .leaf-wrapper.active .popup-card {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) scale(1);
    pointer-events: auto;
  }
  @keyframes sway {
    0%, 100% { transform: rotate(-2deg); }
    50% { transform: rotate(2deg); }
  }
  @media (max-width: 600px) {
    .popup-card {
      width: 180px;
      font-size: 0.85rem;
    }
  }
  .msg-preview {
    text-align: center;
    font-size: 0.75rem;
    max-width: 100px;
    margin-top: 5px;
    color: #444;
  }
</style>
