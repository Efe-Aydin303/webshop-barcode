<?php 

$host = '127.0.0.1';
$db = 'project_week';
$user = 'bit_academy';
$pass = 'bit_academy';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = '';
    if (isset($_POST['naam']) && isset($_POST['wachtwoord']) && isset($_POST['wachtwoord2']) && isset($_POST['mail'])) {
        $wachtwoord = $_POST['wachtwoord'];
        $stmt = $pdo->prepare('SELECT * FROM gebruiker WHERE email = :mail');
        $stmt->execute(['mail' => $_POST['mail']]);
        $existingUser = $stmt->fetch();
        if ($existingUser) {
            $error = "Email is al in gebruik";
        } else {
        if ($wachtwoord == $_POST['wachtwoord2']) {
            $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO gebruiker (email, naam, wachtwoord) VALUES (:email, :naam, :password)');
            $stmt->execute([
                    'email' => $_POST['mail'],
                    'naam' => $_POST['naam'],
                    'password' => $hash,
                ]);
                $_SESSION['user_id'] = $pdo->lastInsertId();
                header("Location: index.php");
                exit;  
        } else {
            echo "<h3 style=color:red>Wachtwoorden komen niet overeen</h3>";
        }
    }
}
}   

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body{
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            width: 100vw;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 200px;
            margin-bottom: 30px;
        }
        form > input {
            margin-bottom: 10px;
        }
        header {
            width: 100vw;
            text-align: center;
            margin-bottom: 40px;
        }
        .login {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login > button {
            margin-top: 10px;
            width: inherit;
        }
    </style>
</head>
<body>
    
<header>
    <h1>BakTech Webshop</h1>
</header>
    <form method="post">
        <label for="mail">Email</label>
        <input type="email" name="mail" required>
        <?php if (!empty($error)): ?>
            <div class="error" style="color:red; margin-bottom: 10px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <label for="naam">Naam</label>
        <input type="text" name="naam" required>
        <label for="wachtwoord">Wachtwoord</label>
        <input type="password" name="wachtwoord" required>
        <label for="wachtwoord2">Bevestig Wachtwoord</label>
        <input type="password" name="wachtwoord2" required>
        <button type="submit">Submit</button>
    </form>

    <form action="login.php" class="login">
        <label for="login">Al een account?</label>
        <button type="submit" name="login">login</button>
    </form>

</body>
</html>