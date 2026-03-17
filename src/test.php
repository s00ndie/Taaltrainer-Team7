<?php
session_start();
require_once('db.php'); // Підключення до вашої БД

// 1. Отримуємо випадкове слово з бази
$sql = "SELECT * FROM woorden ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);
$word = $result->fetch_assoc();

// Якщо в базі порожньо
if (!$word) {
    die("De woordendatabase is leeg! Meer informatie over phpMyAdmin.");
}

$message = "";

// 2. Логіка перевірки відповіді
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_answer = trim($_POST['answer']);
    $correct_answer = $_POST['correct_answer'];
    $original_word = $_POST['original_word'];

    if (mb_strtolower($user_answer) == mb_strtolower($correct_answer)) {
        $message = "<p style='color: green;'>✅ Correct! <b>$original_word</b> - dat is <b>$correct_answer</b>.</p>";
    } else {
        $message = "<p style='color: red;'>❌ Fout. <b>$original_word</b> - dat is <b>$correct_answer</b>, maar niet $user_answer.</p>";
    }
    
    // Після перевірки ми завантажимо нове слово (через оновлення сторінки)
    echo $message;
    echo '<br><a href="test.php">Volgende woord!</a>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Test Taaltrainer</title>
    <link rel="stylesheet" href="disign/style.css">
</head>
<body>
    <h2>Vertaal de woord:</h2>
    
    <div class="card">
        <h3><?php echo $word['nl_article'] . " " . $word['nl_word']; ?></h3>
        
        <form method="post">
            <input type="text" name="answer" placeholder="Jouw vertaling(spaans)" required autofocus>
            
            <input type="hidden" name="correct_answer" value="<?php echo $word['es_word']; ?>">
            <input type="hidden" name="original_word" value="<?php echo $word['nl_word']; ?>">
            
            <br><br>
            <button type="submit" class="butt">Controleer</button>
        </form>
    </div>
</body>
</html>