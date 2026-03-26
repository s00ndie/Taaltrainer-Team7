<?php
session_start();
require_once('db.php');

$lang_from = 1; 
$lang_to = 2;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../design/quiz.css">
</head>
<body>
    <header>
        <?php
            echo "<h1>Je hebt gewonnen!</h1><br>";
            echo "<h2>Je hebt " . $_SESSION['score'] . " vragen goed beantwoord.</h2>";
        ?>
    </header>
    <body>
        <?php
            echo "<button class='butt' type='submit' onclick='window.location.href=\"test.php\"'>Opnieuw spelen</button>";
        ?>
        <?php
            echo "<button class='butt' type='submit' onclick='window.location.href=\"index.php\"'>Terug naar menu</button>";
        ?>
    </body>
</body>
</html>