<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['Levens1'])) {
    $_SESSION['Levens1'] = 3;
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}


$lang_from_id = 1;
$lang_to_id = 2;

$show_result = false;
$is_correct = false;
$user_answer = "";
$correct_answer = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_answer'])) {
    $show_result = true;
    $user_answer = $_POST['user_answer'];
    $correct_answer = $_POST['hidden_correct'];
    
    if ($user_answer === $correct_answer) {
        $is_correct = true;
        $_SESSION['score'] += 1;
    } else {
        $is_correct = false;
        $_SESSION['Levens1'] -= 1;
    }

    if ($_SESSION['Levens1'] <= 0) {
        $_SESSION['score'] = 0;
        header("Location: Loser.html");
        $_SESSION['Levens1'] = 3;
        exit();
        }
    if ($_SESSION['score'] >= 10) {
        $_SESSION['Levens1'] = 3;
        header("Location: Winnaar.php");
        $_SESSION['score'] = 0;
        exit();
    }
}

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
        $sql_wrong = "SELECT word_text FROM translations 
        WHERE lang_id = $lang_to_id AND term_id != $correct_term_id 
        ORDER BY RAND() LIMIT 3";
        $res_wrong = $conn->query($sql_wrong);

        $options = [$data['a_word']];
        while($row = $res_wrong->fetch_assoc()) { $options[] = $row['word_text']; }
        shuffle($options);
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Taaltrainer Quiz</title>
    <link rel="stylesheet" href="../design/quiz.css">
</head>
<body>
    <div class="container">
        <?php if ($show_result): ?>
            <div class="result-box <?php echo $is_correct ? 'correct' : 'wrong'; ?>">
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
            <?php echo "<h2>Levens: " . $_SESSION['Levens1'] . "</h2>"; ?>
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
                echo '<button type="button" class="butt" onclick="window.location.href=\'reset.php\'">Terug naar start</button>';
                ?>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>