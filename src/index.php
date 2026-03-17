<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoofdpagina</title>
    <link rel="stylesheet" href="disign/style.css">
</head>
<body>
    <?php
        session_start();
        if (isset($_SESSION['user']))
            {
                echo "Welcome " . $_SESSION['user'] . "!";
            }

    ?>
    <br>
    <?php
        if (isset($_SESSION["user"]))
            {echo '<form action="uitlogen.php" method="post">
            <input type="submit" value="uitloggen" class="logs">

            </form>';

        } else{
            echo '<br>';
            echo '<a href="login.php">Heb je al een account?</a> <br>';
            echo '<a href="register.php">Heb je nog geen account?</a>';

        }
            

    ?> 

</body>