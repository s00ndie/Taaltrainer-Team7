<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['Levens1'])) {
    $_SESSION['Levens1'] = 3;
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

// 1. НАЛАШТУВАННЯ МОВ
$lang_from_id = 1; // Нідерландська
$lang_to_id = 2;   // Іспанська

// 2. ОБРОБКА ВІДПОВІДІ (якщо натиснули кнопку)
$show_result = false;
$is_correct = false;
$user_answer = "";
$correct_answer = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_answer'])) {
    $show_result = true;
    $user_answer = $_POST['user_answer'];
    $correct_answer = $_POST['hidden_correct'];
    $is_correct = ($user_answer === $correct_answer);
}

// 3. ПІДГОТОВКА НОВОГО ПИТАННЯ (тільки якщо ми не показуємо результат)
if (!$show_result) {
    $sql = "SELECT t1.word_text AS q_word, t1.article AS q_art, t2.word_text AS a_word, t1.term_id
            FROM translations t1
            JOIN translations t2 ON t1.term_id = t2.term_id
            WHERE t1.lang_id = $lang_from_id AND t2.lang_id = $lang_to_id
            ORDER BY RAND() LIMIT 1";

    $result = $conn->query($sql);
    $data = $result->fetch_assoc();

    if ($data) {
        $correct_term_id = $data['term_id'];
        // Беремо 3 неправильні варіанти
        $sql_wrong = "SELECT word_text FROM translations 
                      WHERE lang_id = $lang_to_id AND term_id != $correct_term_id 
                      ORDER BY RAND() LIMIT 3";
        $res_wrong = $conn->query($sql_wrong);

        $options = [$data['a_word']];
        while($row = $res_wrong->fetch_assoc()) { $options[] = $row['word_text']; }
        shuffle($options);
    }
}

if ($_SESSION['score'] >= 10) {
    header("Location: Testsites.html");
    $_SESSION['score'] = 0;
    $_SESSION['Levens1'] = 3;
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Taaltrainer Quiz</title>
    <link rel="stylesheet" href="disign/style.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: linear-gradient(135deg, #a8d86f 0%, #b8e07f 100%);
            min-height: 100vh;
            color: #0a0d05;
            font-family:  'Cascadia Code', Consolas, 'Courier New', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: min(900px, 100%);
            padding: 30px;
            background: rgba(255,255,255,0.18);
            border: 2px solid #8fc74f;
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.14);
        }

        .question-box {
            background: #8fc74f;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            padding: 20px;
        }

        .question-box h1 {
            font-size: 4rem;
            font-weight: 700;
            color: #0a0d05;
        }

       .options-container {

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;


        }

        .option-card {
            display: flex;
            width: 250px;
            background: #94c95c;
            border: 2px solid #7ab43a;
            border-radius: 12px;
            padding: 16px;
            font-size: 1.6rem;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .option-card input {
            margin-right: 10px;
            transform: scale(1.3);
        }

        .option-card:hover {
            transform: translateY(-3px);
            background: #b8e07f;
        }

        .butt {
            background: #7ab43a;
            color: white;
            border: 0;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-right: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .butt:hover {
            background: #93c55f;
        }

        .result-box {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.5rem;
        }

        .correct { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .wrong { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($show_result): ?>
            <div class="result-box <?php echo $is_correct ? 'correct' : 'wrong'; ?>">
                <?php if ($is_correct) {
                    $_SESSION['score'] += 1;
                } ?>
                <h1><?php echo $is_correct ? "✅ Goed gedaan!" : "❌ Helaas..."; ?></h1>
                <p>Jouw antwoord: <b><?php echo htmlspecialchars($user_answer); ?></b></p>
                <?php if (!$is_correct): ?>
                    <p>Het juiste antwoord was: <b><?php echo htmlspecialchars($correct_answer); ?></b></p>
                <?php endif; ?>
                <br>
                <a href="quiz.php" class="butt" style="text-decoration: none;">Volgende vraag</a>
            </div>

        <?php else: ?>
            <?php echo "<h2>Score: " . $_SESSION['score'] . "</h2>"; ?>
            <h2>Vertaal naar het Spaans:</h2>
            <h1 style="color: #2c3e50;">
                <?php echo ($data['q_art'] ? "<i>" . $data['q_art'] . "</i> " : "") . $data['q_word']; ?>
            </h1>

            <form action="quiz.php" method="post">
                <input type="hidden" name="hidden_correct" value="<?php echo $data['a_word']; ?>">
                
                <div class="options-container">
                    <?php foreach ($options as $option): ?>
                        <label class="option-card">
                            <input type="radio" name="user_answer" value="<?php echo $option; ?>" required>
                            <span><?php echo $option; ?></span>
                        </label><br>
                    <?php endforeach; ?>
                </div>

                <br>
                <button type="submit" class="butt">Controleren</button>
                <?php
                    echo '<button type="button" class="butt" onclick="window.location.href=\'index.php\'">Terug naar start</button>';
                    $_SESSION['score'] = 0;
                    $_SESSION['Levens1'] = 3;
                ?>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>