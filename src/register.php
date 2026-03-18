<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie</title>
    <style>
        :root {
            --bg-color: #B5CD8A;    
            --card-bg: #92B25E;
            --text-color: #0A0D05;
            --muted-text: #0A0D05;
            --border-color: #bef39b;
            --button-bg: #6a8241;
            --button-hover: #b2e771;
            --button-text: #0A0D05;
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
            font-family: Arial, Helvetica, sans-serif;
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

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 12px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
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
            margin-bottom: 14px;
        }

        .login-knop:hover {
            background: var(--button-hover);
        }

        .extra-link {
            font-size: 0.9rem;
            text-align: center;
            color: var(--muted-text);
        }

        .extra-link a {
            color: darkblue;
            text-decoration: none;
        }

        .extra-link a:hover {
            text-decoration: underline;
        }

        .message {
 FF            padding: 12px;
            margin-bottom: 16px;
            border-radius: 8px;
            text-align: center;
            font-size: 0.95rem;
        }

        .error {
            background-color: #ffcccc;
            color: #cc0000;
            border: 1px solid #ff9999;
        }

        .success {
            background-color: #ccffcc;
            color: #00cc00;
            border: 1px solid #99ff99;
        }
    </style>
</head>
<body>
    <main class="login-kaart">
        <h1 class="login-title">Registratie</h1>
        <p class="login-subtitle">Maak een nieuw account aan</p>

        <?php 
        if(isset($_SESSION['user']))
            {echo '<form action="logout.php" method="post">
            <button class="login-knop" type="submit">Uitloggen</button>
            </form>';
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
                    echo '<div class="message error">Je moet alle velden invullen!</div>';
                } elseif($pwd !== $repeatPwd){
                    echo '<div class="message error">Wachtwoorden komen niet overeen!</div>';
                } else {
                    $pwd = password_hash($pwd, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO `logs` (Gebruikersnaam, Wachtwoord) VALUES ('$gnaam', '$pwd')";
                    if($conn->query($sql) === TRUE){
                        echo '<div class="message success">Registratie succesvol!</div>';
                        header('Refresh: 2; url=index.php');
                    } else {
                        echo '<div class="message error">Er is een fout opgetreden. Probeer opnieuw.</div>';
                    }
                }
            }
        ?>

        <?php if(!isset($_SESSION['user'])) { ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="gnaam">Gebruikersnaam</label>
                <input id="gnaam" type="text" name="gnaam" placeholder="Jouw gebruikersnaam" required>
            </div>

            <div class="form-group">
                <label for="pwd">Wachtwoord</label>
                <input id="pwd" type="password" name="pwd" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label for="repeatPwd">Herhaal wachtwoord</label>
                <input id="repeatPwd" type="password" name="repeatPwd" placeholder="••••••••" required>
            </div>

            <button class="login-knop" type="submit">Registreren</button>
        </form>

        <p class="extra-link">Heb je al een account? <a href="index.php">Log hier in</a></p>
        <?php } ?>
    </main>
</body>
</html>