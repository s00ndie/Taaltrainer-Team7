<?php
session_start();
require_once('db.php');

$lang_from = 1; 
$lang_to = 2;

if (!isset($_SESSION['Levens'])) {
    $_SESSION['Levens'] = 3;
}
if (!isset($_SESSION['score1'])) {
    $_SESSION['score1'] = 0;
}

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

$result_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_answer = trim($_POST['answer']);
    $correct_answer = $_POST['correct_answer'];
    $original_word = $_POST['original_word'];

    if (mb_strtolower($user_answer) == mb_strtolower($correct_answer)) {
        $_SESSION['score1'] += 1;
 
        $result_message = "
        <div class='result-box correct'><h2>✅ Goed gedaan!</h2><p><strong>$original_word</strong> is <strong>$correct_answer</strong> correct.</p></div>
        ";
        if ($_SESSION['score1'] === 10) {
            $_SESSION['Levens'] = 3;
            header("Location: Testsites.html");
            $_SESSION['score1'] = 0;
            exit();
        }
    } else {
        $result_message = "<div class='result-box wrong'><h2>❌ Helaas...</h2><p><strong>$original_word</strong> is <strong>$correct_answer</strong>, niet <strong>$user_answer</strong>.</p></div>";
        $_SESSION['Levens'] -= 1;
        if ($_SESSION['Levens'] <= 0) {
            $_SESSION['score1'] = 0;
            header("Location: Loser.html");
            $_SESSION['Levens'] = 3;
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Test Taaltrainer</title>
    <link rel="stylesheet" href="../design/test.css">
</head>
<body>
    <div class="container">
        <?php echo "<h2>Score: " . $_SESSION['score1'] . "</h2> Levens: " . $_SESSION['Levens'] . "<br>"; ?>
        <h2>Vertaal het woord:</h2>
        
        <?php if (!empty($result_message)) echo $result_message; ?>

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
                <?php
                echo '<button type="button" class="butt" onclick="window.location.href=\'reset.php\'">Terug naar start</button>';
                ?>
            </form>
        </div>
    </div>
</body>
</html>