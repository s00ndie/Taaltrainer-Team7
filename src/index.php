<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$username = $loggedIn ? $_SESSION['user'] : null;

if (!isset($_SESSION['Levens1'])) {
    $_SESSION['Levens1'] = 3;
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levels</title>
    <link rel="stylesheet" href="../design/index.css">
</head>
<body>
    <?php if ($loggedIn): ?>
        <div class="container">
            <h2 class="welcome">Welkom, <?= htmlspecialchars($username) ?>!</h2>
            <div class="header">Levels</div>
            <div class="levels-grid">
            <div class="level-row">
                <a href="quiz.php" class="level-btn">1</a>
                <a href="test.php" class="level-btn">2</a>
        </div>
        <?php endif; ?>
        <div class="login-links">
            <?php if ($loggedIn): ?>
                
                <form action="uitlogen.php" method="post" style="display: inline;">
                    <button class="menu-btn" style="padding: 10px 18px;">Uitloggen</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="log-btn">Heb je al een account?</a>
                <a href="register.php" class="log-btn">Heb je nog geen account?</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>