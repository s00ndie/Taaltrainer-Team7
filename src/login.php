<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="disign/style.css">
</head>
<body>
    <form action="" method="post">
    <input type="text" name="gnaam" placeholder="Gebruikersnaam:" class="in">
    <br>
    <input type="password" name="pwd" placeholder="Wachtwoord:" class="in">
    <br>
    <input type="submit" value="Inlogen" class="butt">
    </form>
    <a href="register.php">Nog geen account?</a>

    <?php
    session_start();
    require_once('db.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        $login = $_POST['gnaam'];
        $pwd = $_POST['pwd'];
        if(empty($login) || empty($pwd)){
            echo 'Je moet alle velden invullen!<br><br>';
            echo '<a href="login.php">Terug naar inloggen</a>';
            exit;
        } else {
            $hash = "SELECT Wachtwoord FROM logs WHERE Gebruikersnaam = '$login'";
            $hashPass = $conn->query($hash)->fetch_assoc();

        if (password_verify($pwd,$hashPass['Wachtwoord'])){
            $_SESSION['user'] = $login;
            header('Location: index.php');
        } else{
            echo 'Ongeldige gebruikersnaam of wachtwoord!<br><br>';
            echo '<a href="login.php">Terug naar inloggen</a>';
            exit;
        }
        }

        }
    
    ?>
</body>
</html>