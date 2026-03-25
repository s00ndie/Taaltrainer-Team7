<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="../design/login.css">
</head>
<body>
    <form action="" method="post">
        <div class="login-kaart">
            <h1 class="login-title">Inloggen</h1>
            <p class="login-subtitle">Voer je gegevens in om in te loggen.</p>
            <div class="form-group">
                <label for="gnaam">Gebruikersnaam:</label>
                <input type="text" name="gnaam" id="gnaam" class="in">
            </div>
            <div class="form-group">
                <label for="pwd">Wachtwoord:</label>
                <input type="password" name="pwd" id="pwd" class="in">
            </div>
            <input type="submit" value="Inloggen" class="login-knop">
            <p class="extra-link"><a href="register.php">Nog geen account?</a></p>
        </div>
        
    </form>

    <?php
    session_start();
    require_once('db.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        $login = $_POST['gnaam'];
        $pwd = $_POST['pwd'];
        if(empty($login) || empty($pwd)){
            echo 'Je moet alle velden invullen!<br><br>';
            
            exit;
        } else {
            $hash = "SELECT Wachtwoord FROM logs WHERE Gebruikersnaam = '$login'";
            $hashPass = $conn->query($hash)->fetch_assoc();

        if (password_verify($pwd,$hashPass['Wachtwoord'])){
            $_SESSION['user'] = $login;
            header('Location: index.php');
        } else{
            echo '<br>Ongeldige gebruikersnaam of wachtwoord!<br><br>';
            exit;
        }
        }

        }
    
    ?>
</body>
</html>