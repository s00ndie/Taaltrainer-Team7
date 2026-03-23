<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="disign/style.css">
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
            color: var(--button-bg);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <form action="" method="post" class="login-kaart">
        <h1 class="login-title">Inloggen</h1>
        <p class="login-subtitle">Voer je gebruikersnaam en wachtwoord in.</p>

        <div class="form-group">
            <label for="gnaam">Gebruikersnaam</label>
            <input type="text" id="gnaam" name="gnaam" placeholder="Gebruikersnaam" required>
        </div>

        <div class="form-group">
            <label for="pwd">Wachtwoord</label>
            <input type="password" id="pwd" name="pwd" placeholder="Wachtwoord" required>
        </div>

        <button type="submit" class="login-knop">Inloggen</button>
        <p class="extra-link"><a href="register.php">Nog geen account?</a></p>
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