<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = trim($_POST['message']);
    $category = $_POST['category'] ?? 'Suggestion';

    // Handle file upload
    $imagePath = null;
    if (!empty($_FILES['profile']['name'])) {
        $targetDir = "uploads/";
        $filename = time() . '_' . basename($_FILES["profile"]["name"]);
        $targetFile = $targetDir . $filename;

        move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile);
        $imagePath = $targetFile;
    }

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO feedback (message, category, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $message, $category, $imagePath);
        $stmt->execute();
        header("Location: tree.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Submit Feedback</title>
</head>
<body>
  <h2>🌱 Submit Your Feedback</h2>
  <form method="POST" enctype="multipart/form-data">
    <label>Message:</label><br>
    <textarea name="message" rows="4" cols="50" required></textarea><br><br>

    <label>Category:</label>
    <select name="category">
      <option value="Suggestion">💡 Suggestion</option>
      <option value="Praise">🌟 Praise</option>
      <option value="Concern">🚨 Concern</option>
    </select><br><br>

    <label>Upload Profile Image:</label><br>
    <input type="file" name="profile" accept="image/*" required><br><br>

    <button type="submit">🌿 Add to Tree</button>
  </form>
</body>
</html>
