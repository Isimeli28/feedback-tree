<?php include 'header.php'; ?>
<?php
include 'db.php';

// Handle form submission
function handleFormSubmission($conn) {
  $message = trim($_POST['message'] ?? '');
  $selectedName = $_POST['name'] ?? '';
  $imagePath = '';

  // Map names to image filenames (stored in 'images/' folder)
  $nameToImage = [
    'Michelle Belisle' => 'images/Michelle.jpg',
    'Seci Waqabaca' => 'images/Seci.jpg',
    'Dipshika K. Singh' => 'images/Dipshika.jpg',
    'Adharsan Kumar' => 'images/Adharsan.jpg',
    'Vau P. Afamasaga' => 'images/Vau.jpg',
    'Seni Wainiqolo' => 'images/Senirewa.jpg',
    'Anoj Sharma' => 'images/Anoj.jpg',
    'Kalpana Singh' => 'images/Kalpana.jpg',
    'Aashna Kumar' => 'images/Aashna Kumar.jpg',
    'Marica Tuivaga' => 'images/Marica.jpg',
    'Lavenia Josefa' => 'images/Lavenia.jpg',
    'Lynett Reddy' => 'images/Lynett.jpg',
    'Laura Bulisovasova' => 'images/Laura.jpg',
    'Meava Tigarea' => 'images/Meava.jpg',
    'Mischelle Lal' => 'images/bk.jpg',
    'Sweta Rao' => 'images/Sweta.jpg',
    'Rima Prasad' => 'images/Rima.jpg',
    'Karishna Karan' => 'images/Karishna.jpg',
    'Ashwanti Devi' => 'images/Ashwanti.jpg',
    'Shalin Lata' => 'images/Shalin.jpg',
    'Shamal Singh' => 'images/Shamal.jpg',
    'Jiulia Ledua' => 'images/Jiulia.jpg',
    'Sonal Aujla' => 'images/Sonal.jpg',
    'Ellen Meleisea' => 'images/Ellen M.png',
    'Tokasa Tilatila' => 'images/Tokasa.jpg',
    'Tera Narayan' => 'images/Tera.jpg',
    'Isimeli Savutini' => 'images/Isimeli.jpg',
    'Michael Noa' => 'images/Michael.jpg',
    'Adrian Alamu' => 'images/Adrian.jpg',
    'Seema Prasad' => 'images/Seema.jpg',
    'Krishneel Reddy' => 'images/Krishneel.jpg',
    'Salote Valentine' => 'images/Salote.jpg',
    'Torika Taoi' => 'images/Torika.jpg',
    'Tuila Seniloli' => 'images/Seniloli.jpg',
    'Ratieli Tora' => 'images/Ratieli.jpg',
    'Seru Ramakita' => 'images/Seru.jpg',
    'Simita Kumar' => 'images/Simita.jpg',
    'Ruci Qele' => 'images/Ruci.jpg',
    'Jennytima Taufa' => 'images/Jennytima.jpg',
    'Rova Waqanivalu' => 'images/Rova.jpg',
    'Doreen Tuala' => 'images/Doreen.jpg',
    'Geetanjali Lal' => 'images/Geeta.jpg',
    'Koroi Matadigo' => 'images/Koroi.jpg',
    'Lili T. Motufaga' => 'images/Lili.jpg',
    'Taukiei Tokintekai' => 'images/Taukiei.jpg',
    'Ruth Kuilamu' => 'images/Ruth.jpg',
    'Tevaogali Elisala' => 'images/Tevaogali.jpg',
    'Rajendra Prasad' => 'images/Rajen.jpg',
    'Selai Waqainabete' => 'images/Selai.jpg',
    'Apenisa Tamani' => 'images/Apenisa.jpg',
    'Ikatonga Hingano' => 'images/Ikatonga.jpg',
    'Kabir Mia' => 'images/Kabir.jpg',
    'Uma Devi' => 'images/Uma.jpg',
    'Tawaqa Naisoro' => 'images/Tawaqa.jpg',
    'Sina Tane' => 'images/SINA.jpg',
    'Sandeep Singh' => 'images/SANDEEP.jpg',
    'Senitiki Rokocakau' => 'images/Senitiki.jpg',
    'Edwin Nand' => 'images/Edwin.jpg',
    'Amendra Chand' => 'images/Amendra.jpg',
    'Akshay Deo' => 'images/Akshay.jpg',
    'Avishek Ram' => 'images/Avishek.jpg',
    'Sanjeet Chand' => 'images/Sanjeet.jpg',
    // Add more mappings as needed
  ];

  if (array_key_exists($selectedName, $nameToImage)) {
    $imagePath = $nameToImage[$selectedName];
  }

  if ($message && $imagePath) {
    $stmt = $conn->prepare("INSERT INTO feedback (message, image_path, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $message, $imagePath);
    $stmt->execute();
    header("Location: index.php");
    exit;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  handleFormSubmission($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Submit Feedback</title>
</head>
<body>

<div class="background-wrapper">
  <div class="form-box" id="submit-form">
    <h2>🌱 Submit Feedback</h2>
    <form action="feedback_form.php" method="POST">

      <label>Describe your experience working for the Pacific Community's Educational Quality and Assessment Programme?</label>
      <textarea name="message" id="message" rows="4" required></textarea>
      <span id="word-count-warning" style="color: red; display: none;">Maximum 50 words allowed.</span>

      <script>
        const textarea = document.getElementById('message');
        const warning = document.getElementById('word-count-warning');

        textarea.addEventListener('input', () => {
          const words = textarea.value.trim().split(/\s+/).filter(word => word.length > 0);
          if (words.length > 50) {
            warning.style.display = 'inline';
            textarea.value = words.slice(0, 50).join(' ');
          } else {
            warning.style.display = 'none';
          }
        });
      </script>

           <label for="name">Name:</label>
<input type="text" id="nameInput" name="name" list="nameSuggestions" required autocomplete="off">
<datalist id="nameSuggestions">
  <option value="Michelle Belisle">
  <option value="Seci Waqabaca">
  <option value="Dipshika K. Singh">
  <option value="Adharsan Kumar">
  <option value="Vau P. Afamasaga">
  <option value="Seni Wainiqolo">
  <option value="Anoj Sharma">
  <option value="Kalpana Singh">
  <option value="Aashna Kumar">
  <option value="Marica Tuivaga">
  <option value="Lavenia Josefa">
  <option value="Lynett Reddy">
  <option value="Laura Bulisovasova">
  <option value="Meava Tigarea">
  <option value="Mischelle Lal">
  <option value="Sweta Rao">
  <option value="Rima Prasad">
  <option value="Karishna Karan">
  <option value="Ashwanti Devi">
  <option value="Shalin Lata">
  <option value="Shamal Singh">
  <option value="Jiulia Ledua">
  <option value="Sonal Aujla">
  <option value="Ellen Meleisea">
  <option value="Tokasa Tilatila">
  <option value="Tera Narayan">
  <option value="Isimeli Savutini">
  <option value="Michael Noa">
  <option value="Adrian Alamu">
  <option value="Seema Prasad">
  <option value="Krishneel Reddy">
  <option value="Salote Valentine">
  <option value="Torika Taoi">
  <option value="Tuila Seniloli">
  <option value="Ratieli Tora">
  <option value="Seru Ramakita">
  <option value="Simita Kumar">
  <option value="Ruci Qele">
  <option value="Jennytima Taufa">
  <option value="Rova Waqanivalu">
  <option value="Doreen Tuala">
  <option value="Geetanjali Lal">
  <option value="Koroi Matadigo">
  <option value="Lili T. Motufaga">
  <option value="Taukiei Tokintekai">
  <option value="Ruth Kuilamu">
  <option value="Tevaogali Elisala">
  <option value="Rajendra Prasad">
  <option value="Selai Waqainabete">
  <option value="Apenisa Tamani">
  <option value="Ikatonga Hingano">
  <option value="Kabir Mia">
  <option value="Uma Devi">
  <option value="Tawaqa Naisoro">
  <option value="Sina Tane">
  <option value="Sandeep Singh">
  <option value="Senitiki Rokocakau">
  <option value="Edwin Nand">
  <option value="Amendra Chand">
  <option value="Akshay Deo">
  <option value="Avishek Ram">
  <option value="Sanjeet Chand">
</datalist>

      <button type="submit">Submit Feedback</button>
    </form>
  </div>
</div>
</body>
</html>

<style>
  html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', sans-serif;
  }

  .background-wrapper {
    background-image: url('');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    position: relative;
    min-height: 50vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 80px 20px;
  }

  .background-wrapper::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 1;
  }

  .form-box {
    position: relative;
    z-index: 2;
    max-width: 600px;
    background: #ffffff;
    padding: 20px;
    border-radius: 35px;
    box-shadow: 0 0 10px rgba(0,0,0,0.15);
    width: 100%;
  }

  .form-box form {
    display: flex;
    flex-direction: column;
  }

  .form-box label {
    font-weight: bold;
    margin: 5px 0 2px;
  }

  .form-box textarea,
  .form-box input {
    padding: 8px;
    margin-bottom: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
  }

  .form-box button {
    background: #4CAF50;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
  }
</style>

<?php include 'footer.php'; ?>
