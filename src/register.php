<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
    <link rel="'stylesheet" href="design/style.css">
</head>
<body>
    <div class="inlog">
        
        <br>

        <form action="register.php" method="post">
            <input type="text" name="gnaam" placeholder="Gebruikersnaam:" class="in">
            <br>
            <input type="password" name="pwd" placeholder="Wachtwoord:" class="in">
            <input type="password" name="repeatPwd" placeholder="Herhaal je wachtwoord:" class="in">
            <br>
            <input type="submit" value="Register" class="butt">
        </form>

        <?php 
        if(isset($_SESSION['user']))
            {echo '<form action="logout.php" method="post">
            <input type="submit" value="uitloggen" class="logs">
            </form>';
        } else{
            echo '<br>';
            echo '<a href="index.php">Heb je al een account?</a><br>';
        }
        ?>
        <?php
            require_once('db.php');
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $gnaam = $_POST['gnaam'];
                $pwd = $_POST['pwd'];
                $repeatPwd = $_POST['repeatPwd'];

                if(empty($gnaam) || empty($pwd) || empty($repeatPwd)){
                echo 'Je moet alle velden invullen!<br><br>';
                    echo '<a href="register.php">Terug naar registratie</a>';
                    exit;
                } elseif($pwd !== $repeatPwd){
                    echo 'Wachtwoorden komen niet overeen!<br><br>';
                    echo '<a href="register.php">Terug naar registratie</a>';
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

