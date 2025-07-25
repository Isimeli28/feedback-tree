<?php
include 'db.php';

// Tree filters
$filter = $_GET['filter'] ?? 'All';
$order = $_GET['order'] ?? 'DESC';

// Chart filters
$startDate = $_GET['start'] ?? date('Y-m-01');
$endDate = $_GET['end'] ?? date('Y-m-t');
$interval = $_GET['interval'] ?? 'day';

switch ($interval) {
  case 'week': $dateFormat = "YEARWEEK(created_at)"; break;
  case 'month': $dateFormat = "DATE_FORMAT(created_at, '%Y-%m')"; break;
  default: $dateFormat = "DATE(created_at)"; break;
}

// Get feedback for chart
$stmt = $conn->prepare("SELECT $dateFormat as period, category, COUNT(*) as count
                        FROM feedback
                        WHERE DATE(created_at) BETWEEN ? AND ?
                        GROUP BY period, category
                        ORDER BY period ASC");
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$resultChart = $stmt->get_result();

$data = [];
$allPeriods = [];
$categories = ['Praise', 'Concern', 'Suggestion'];

while ($row = $resultChart->fetch_assoc()) {
  $p = $row['period'];
  $c = $row['category'];
  $data[$p][$c] = (int)$row['count'];
  $allPeriods[$p] = true;
}
ksort($allPeriods);
$labels = array_keys($allPeriods);
$dataset = [];
foreach ($categories as $c) {
  $dataset[$c] = [];
  foreach ($labels as $p) {
    $dataset[$c][] = $data[$p][$c] ?? 0;
  }
}

// Feedback tree display
$query = "SELECT * FROM feedback";
if ($filter !== 'All') {
  $query .= " WHERE category = '" . $conn->real_escape_string($filter) . "'";
}
$query .= " ORDER BY created_at $order";
$resultTree = $conn->query($query);

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

<!DOCTYPE html>
<html>
<head>
  <title>Analyse Feedback</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f0f2f5; }
    .filter-card, .chart-container { background: #fff; border-radius: 12px; padding: 20px; margin: 30px auto; max-width: 960px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .filters form, .chart-filters { display: flex; flex-wrap: wrap; gap: 15px; align-items: center; }
    select, input[type="date"], button { padding: 8px 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 0.95rem; }
    button { background-color: #4CAF50; color: white; cursor: pointer; border: none; }
    button:hover { background-color: #388e3c; }
    .tree-background { background-image: url('images/trees.png'); background-size: contain; background-repeat: no-repeat; background-position: center; position: relative; width: 100%; height: 1100px; }
    .tree { position: relative; width: 100%; height: 100%; }
    .leaf-wrapper { position: absolute; display: flex; flex-direction: column; align-items: center; max-width: 260px; cursor: pointer; }
    .leaf { width: 70px; height: 80px; clip-path: ellipse(60% 45% at 50% 50%); border: 3px solid #ccc; background-color: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.3); display: flex; justify-content: center; align-items: center; animation: sway 6s ease-in-out infinite; transition: transform 0.3s ease; }
    .leaf:hover { transform: scale(3); }
    .leaf img { width: 100%; height: 100%; object-fit: cover; }
    .fallback { font-size: 2rem; background-color: #f1f1f1; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
    .popup-card { position: absolute; top: 130%; left: 50%; transform: translateX(-50%) scale(0.95); background: white; border: 2px solid #ccc; border-radius: 12px; padding: 12px; width: 240px; max-width: 90vw; box-shadow: 0 8px 20px rgba(0,0,0,0.25); opacity: 0; visibility: hidden; transition: all 0.35s ease; z-index: 10; pointer-events: none; }
    .leaf-wrapper.active .popup-card { opacity: 1; visibility: visible; transform: translateX(-50%) scale(1); pointer-events: auto; }
    @keyframes sway { 0%, 100% { transform: rotate(-2deg); } 50% { transform: rotate(2deg); } }
    @media (max-width: 600px) { .popup-card { width: 180px; font-size: 0.85rem; } }
  </style>
</head>
<body>

<div class="filter-card">
  <div class="filters">
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
      <button type="submit">Apply</button>
    </form>
  </div>
</div>

<div class="tree-background">
  <div class="tree">
    <?php
    $positions = [['top' => 400, 'left' => 180], ['top' => 40, 'left' => 570], ['top' => 40, 'left' => 700], ['top' => 400, 'left' => 310], ['top' => 400, 'left' => 440], ['top' => 120, 'left' => 50], ['top' => 120, 'left' => 180], ['top' => 400, 'left' => 570], ['top' => 210, 'left' => 830], ['top' => 400, 'left' => 700], ['top' => 400, 'left' => 830], ['top' => 120, 'left' => 700], ['top' => 300, 'left' => 960], ['top' => 300, 'left' => 310], ['top' => 300, 'left' => 440], ['top' => 300, 'left' => 570], ['top' => 210, 'left' => 50], ['top' => 210, 'left' => 180], ['top' => 300, 'left' => 700], ['top' => 300, 'left' => 830], ['top' => 300, 'left' => 960], ['top' => 210, 'left' => 310], ['top' => 210, 'left' => 440], ['top' => 210, 'left' => 570], ['top' => 300, 'left' => 50], ['top' => 300, 'left' => 180], ['top' => 210, 'left' => 700], ['top' => 40, 'left' => 180], ['top' => 40, 'left' => 310], ['top' => 120, 'left' => 310], ['top' => 120, 'left' => 440], ['top' => 120, 'left' => 570], ['top' => 120, 'left' => 830], ['top' => 120, 'left' => 960], ['top' => 40, 'left' => 50], ['top' => 40, 'left' => 440], ['top' => 210, 'left' => 960], ['top' => 40, 'left' => 830], ['top' => 40, 'left' => 960]];
    $i = 0;
    while ($row = $resultTree->fetch_assoc()):
      $borderColor = getBorderColor($row['category']);
      $imgSrc = $row['image_path'] ?? '';
      $initials = getInitials($row['message']);
      $top = $positions[$i % count($positions)]['top'];
      $left = $positions[$i % count($positions)]['left'];
      $i++;
    ?>
      <div class="leaf-wrapper" style="top: <?= $top ?>px; left: <?= $left ?>px;">
        <div class="leaf" style="border-color: <?= $borderColor ?>;">
          <?php if ($imgSrc && file_exists($imgSrc)): ?>
            <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($row['category']) ?>">
          <?php else: ?>
            <div class="fallback"><?= htmlspecialchars($initials) ?></div>
          <?php endif; ?>
        </div>
        <div class="popup-card">
          <strong><?= htmlspecialchars($row['category']) ?></strong><br>
          <?= htmlspecialchars($row['message']) ?><br>
          <small>🕒 <?= date("F j, Y", strtotime($row['created_at'])) ?></small>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<div class="chart-container">
  <form method="GET" class="chart-filters">
    <label>Start: <input type="date" name="start" value="<?= $startDate ?>"></label>
    <label>End: <input type="date" name="end" value="<?= $endDate ?>"></label>
    <label>Interval:
      <select name="interval">
        <option value="day" <?= $interval === 'day' ? 'selected' : '' ?>>Day</option>
        <option value="week" <?= $interval === 'week' ? 'selected' : '' ?>>Week</option>
        <option value="month" <?= $interval === 'month' ? 'selected' : '' ?>>Month</option>
      </select>
    </label>
    <button type="submit">📊 Apply</button>
  </form>
  <canvas id="feedbackChart"></canvas>
</div>

<label>Category:
  <select name="chart_category">
    <option value="All" <?= ($_GET['chart_category'] ?? 'All') === 'All' ? 'selected' : '' ?>>All</option>
    <option value="Praise" <?= ($_GET['chart_category'] ?? '') === 'Praise' ? 'selected' : '' ?>>Praise</option>
    <option value="Concern" <?= ($_GET['chart_category'] ?? '') === 'Concern' ? 'selected' : '' ?>>Concern</option>
    <option value="Suggestion" <?= ($_GET['chart_category'] ?? '') === 'Suggestion' ? 'selected' : '' ?>>Suggestion</option>
  </select>
</label>


<script>
document.querySelectorAll('.leaf-wrapper').forEach(w => {
  w.addEventListener('click', e => {
    e.stopPropagation();
    document.querySelectorAll('.leaf-wrapper').forEach(o => { if (o !== w) o.classList.remove('active'); });
    w.classList.toggle('active');
  });
});
document.addEventListener('click', () => {
  document.querySelectorAll('.leaf-wrapper').forEach(w => w.classList.remove('active'));
});

const ctx = document.getElementById('feedbackChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [
      {
        label: 'Praise',
        data: <?= json_encode($dataset['Praise']) ?>,
        borderColor: '#91d8f7',
        backgroundColor: 'rgba(145, 216, 247, 0.2)',
        fill: true,
        tension: 0.4
      },
      {
        label: 'Concern',
        data: <?= json_encode($dataset['Concern']) ?>,
        borderColor: '#f7a8a8',
        backgroundColor: 'rgba(247, 168, 168, 0.2)',
        fill: true,
        tension: 0.4
      },
      {
        label: 'Suggestion',
        data: <?= json_encode($dataset['Suggestion']) ?>,
        borderColor: '#a8f7b5',
        backgroundColor: 'rgba(168, 247, 181, 0.2)',
        fill: true,
        tension: 0.4
      }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: 'Feedback Trend Over Time'
      }
    },
    scales: {
      y: { beginAtZero: true },
      x: { title: { display: true, text: '<?= ucfirst($interval) ?>' } }
    }
  }
});
</script>
</body>
</html>
