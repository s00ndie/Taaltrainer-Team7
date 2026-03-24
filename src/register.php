<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
    <link rel="stylesheet" href="design/style.css">
    <style>
        :root {
            --bg-color: #a8d86f;
            --card-bg: #b8e07f;
            --text-color: #0A0D05;
            --muted-text: #0A0D05;
            --border-color: #bef39b;
            --button-bg: #8fc74f;
            --button-hover: #7ab43a;
            --button-text: #0b0c0a;
            --radius: 12px;
            --spacing: 16px;
            --card-width: 360px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: var(--bg-color);
            color: var(--text-color);
            font-family:  'Cascadia Code', Consolas, 'Courier New', monospace;
            padding: 24px;
        }

        .login-kaart {
            width: 100%;
            max-width: var(--card-width);
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: calc(var(--spacing) * 1.5);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .login-title {
            margin: 0 0 8px;
            font-size: 1.5rem;
        }

        .login-subtitle {
            margin: 0 0 20px;
            color: var(--muted-text);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: var(--spacing);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
        }

        input:focus {
            outline: 2px solid rgba(156, 201, 242, 0.4);
            border-color: var(--button-bg);
        }

        .login-knop {
            width: 100%;
            border: none;
            border-radius: 8px;
            background: var(--button-bg);
            color: var(--button-text);
            font-size: 1rem;
            font-weight: 600;
            padding: 11px 14px;
            cursor: pointer;
        }

        .login-knop:hover {
            background: var(--button-hover);
        }

        .extra-link {
            margin-top: 14px;
            font-size: 0.9rem;
            text-align: center;
            color: var(--muted-text);
        }

        .extra-link a {
            color: color: blue;;
            text-decoration: none;
        }
    </style>
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
            {echo '<form action="logout.php" method="post">
            <input type="submit" value="uitloggen" class="logs">
            </form>';
        } else{
            echo '<br>';
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

