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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #a8d86f 0%, #b8e07f 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            background: #90c056;
            padding: 40px;
            border-radius: 14px;
            text-align: center;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        h2 {
            background-color: #8fc74f;
            padding: 20px 60px;
            margin-bottom: 40px;
            border-radius: 5px;
            font-size: 36px;
            font-weight: bold;
            color: #0f2a0d;
            display: inline-block;
            width: 100%;        
        }

        .card {
            background-color: #a8d86f;
            border: 2px solid #8fc74f;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.12);
        }

        .card h3 {
            font-size: 2.25rem;
            margin-bottom: 24px;
            color: #1b2a16;
        }

        .in {
            width: 100%;
            padding: 18px 16px;
            font-size: 18px;
            border-radius: 12px;
            border: 2px solid #8fc74f;
            background: #ffffff;
            margin: 18px 0 24px;
        }

        .in::placeholder {
            color: #bbb;
        }

        .butt {
            width: 100%;
            padding: 18px 25px;
            font-size: 22px;
            font-weight: bold;
            color: #ffffff;
            background-color: #7ab43a;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 14px;
        }

        .butt:hover {
            background-color: #6ba02f;
        }

        .butt:active {
            background-color: #5a8f26;
        }
    </style>
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