<?php
session_start();
$loggedIn = isset($_SESSION['user']);
$username = $loggedIn ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levels</title>
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
            justify-content: flex-start;
            align-items: flex-start;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .menu-btn {
            background-color: #8fc74f;
            border: none;
            padding: 15px 20px;
            font-size: 24px;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .menu-btn:hover {
            background-color: #7ab43a;
        }

        .container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            background-color: #8fc74f;
            padding: 30px 80px;
            margin-bottom: 40px;
            border-radius: 5px;
            font-size: 48px;
            font-weight: bold;
            color: #333;
        }

        .levels-grid {
            display: flex;
            flex-direction: column;
            gap: 30px;
            align-items: center;
            margin-bottom: 40px;
        }

        .level-row {
            display: flex;
            gap: 20px;
        }

        .level-btn {
            background: radial-gradient(circle at 35% 35%, #d4e7a8, #a8d86f);
            border: 3px solid #8fc74f;
            border-radius: 50px;
            width: 100px;
            height: 100px;
            font-size: 48px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

        .level-btn:hover {
            transform: scale(1.1);
            background: radial-gradient(circle at 35% 35%, #dff0b0, #b8e07f);
        }

        .level-btn:active {
            transform: scale(0.95);
        }

        .chart {
            position: absolute;
            top: 50px;
            right: 30px;
            font-size: 48px;
        }

        .login-links {
            margin-top: 20px;
            display: flex;
            gap: 14px;
        }

        .login-links a {
            color: #0a0d05;
            font-weight: bold;
            text-decoration: none;
            padding: 8px 12px;
            background: #d4e7a8;
            border: 2px solid #8fc74f;
            border-radius: 8px;
        }

        .login-links a:hover {
            background: #b8e07f;
        }
    </style>
</head>
<body>
    <button class="menu-btn">☰</button>

    <div class="container">
        <div class="header">Levels</div>

        <?php if ($loggedIn): ?>
            <div class="welcome">Welkom, <?= htmlspecialchars($username) ?>!</div>
        <?php endif; ?>
        <div class="login-links">
            <?php if ($loggedIn): ?>
                
                <div class="levels-grid">
                    <div class="level-row">
                        <a href="quiz.php" class="level-btn">1</a>
                    <a href="test.php" class="level-btn">2</a>
            </div>
                <form action="uitlogen.php" method="post" style="display: inline;">
                    <button class="menu-btn" style="padding: 10px 18px;">Uitloggen</button>
                </form>
            <?php else: ?>
                <a href="login.php">Heb je al een account?</a>
                <a href="register.php">Heb je nog geen account?</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>