<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
    <link rel="stylesheet" href="../design/register.css">
</head>
<body>
    <form action="register.php" method="post" class="login-kaart">
        <h1 class="login-title">Registreren</h1>
        <p class="login-subtitle">Maak een nieuw account aan.</p>

        <div class="form-group">
            <label for="gnaam">Gebruikersnaam</label>
            <input type="text" id="gnaam" name="gnaam" placeholder="Gebruikersnaam" required>
        </div>

        <div class="form-group">
            <label for="pwd">Wachtwoord</label>
            <input type="password" id="pwd" name="pwd" placeholder="Wachtwoord" required>
        </div>

        <div class="form-group">
            <label for="repeatPwd">Herhaal wachtwoord</label>
            <input type="password" id="repeatPwd" name="repeatPwd" placeholder="Herhaal je wachtwoord" required>
        </div>

        <button type="submit" class="login-knop">Registeren</button>
        <p class="extra-link"><a href="login.php">Heb je al een account?</a></p>
    </form>

        <?php 
        if(isset($_SESSION['user']))
            {echo '<form action="uitlogen.php" method="post">
            <input type="submit" value="uitloggen" class="logs">
            </form>';
        } else{
            echo '<br>';
        }
        ?>
        <?php
            require_once('db.php');
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $gnaam = $_POST['gnaam'];
                $pwd = $_POST['pwd'];
                $repeatPwd = $_POST['repeatPwd'];

                if(empty($gnaam) || empty($pwd) || empty($repeatPwd)){
                echo 'Je moet alle velden invullen!<br><br>';
                    exit;
                } elseif($pwd !== $repeatPwd){
                    echo 'Wachtwoorden komen niet overeen!<br><br>';
                    exit;
                }
                $pwd = password_hash($pwd, PASSWORD_DEFAULT);

                $sql = "INSERT INTO `logs` (Gebruikersnaam, Wachtwoord) VALUES ('$gnaam', '$pwd')";
                if($conn->query($sql) === TRUE){
                    echo 'Registratie succesvol!';
                };
                header('Location: index.php');
            }
        ?>     
    </div>
</body>
</html>

