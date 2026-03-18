<?php
session_start();
require_once('db.php'); // Підключення до БД

// Визначаємо ID мов (як ми домовилися: 1 - NL, 2 - ES)
$lang_from = 1; 
$lang_to = 2;

// 1. Отримуємо випадкову пару слів через JOIN
$sql = "SELECT 
            t1.word_text AS q_word, 
            t1.article AS q_art,
            t2.word_text AS a_word, 
            t2.article AS a_art
        FROM translations t1
        JOIN translations t2 ON t1.term_id = t2.term_id
        WHERE t1.lang_id = $lang_from AND t2.lang_id = $lang_to
        ORDER BY RAND() LIMIT 1";

$result = $conn->query($sql);
$word = $result->fetch_assoc();

if (!$word) {
    die("De database is leeg або мови налаштовані неправильно!");
}

$message = "";

// 2. Логіка перевірки відповіді
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_answer = trim($_POST['answer']);
    $correct_answer = $_POST['correct_answer'];
    $original_word = $_POST['original_word'];

    if (mb_strtolower($user_answer) == mb_strtolower($correct_answer)) {
        $message = "<div class='container'><p style='color: green;'>✅ Correct! <b>$original_word</b> - dat is <b>$correct_answer</b>.</p>";
    } else {
        $message = "<div class='container'><p style='color: red;'>❌ Fout. <b>$original_word</b> - dat is <b>$correct_answer</b>, maar niet $user_answer.</p></div>";
    }
    
    echo $message;
    echo '<br><a href="test.php" class="butt">Volgende woord!</a></div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Test Taaltrainer</title>
    <link rel="stylesheet" href="disign/style.css">
</head>
<body>
    <div class="container">
        <h2>Vertaal het woord:</h2>
        
        <div class="card">
            <h3>
                <?php 
                    echo ($word['q_art'] ? $word['q_art'] . " " : "") . $word['q_word']; 
                ?>
            </h3>
            
            <form method="post">
                <input type="text" name="answer" placeholder="Jouw vertaling (Spaans)" required autofocus class="in">
                
                <input type="hidden" name="correct_answer" value="<?php echo $word['a_word']; ?>">
                <input type="hidden" name="original_word" value="<?php echo $word['q_word']; ?>">
                
                <br><br>
                <button type="submit" class="butt">Controleer</button>
                <button type="button" class="butt" onclick="window.location.href='index.php'">Terug naar start</button> 
            </form>
            <script>
                Levens = 3;
                VragenBeantwoord = 0;
                if (mb_strtolower($user_answer) == mb_strtolower($correct_answer)) {
                    Levens = Levens
                    VragenBeantwoord = VragenBeantwoord + 1
                    console.log(Levens)
                }
                else {
                    Levens = Levens - 1
                    console.log(Levens)
                }

                if Levens == 0 {
                    print("Game over")
                    <a href="index.php" id="GoverBack">Terug naar start</a>
                }

                if VragenBeantwoord == 10 {
                    print("Je hebt gewonnen")
                    <a href="test.php" id="WinRetry">Opnieuw</a>
                    <a href="index.php" id="WinReturn">Terug naar start</a>
                }
            </script>
        </div>
    </div>
</body>
</html>