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
    $wachtwoord = $_POST['wachtwoord'];
    $mail = $_POST['mail'];
    $stmt = $pdo->prepare('SELECT * FROM gebruiker WHERE email = :mail');
    $stmt->execute(['mail' => $mail]);
    $user = $stmt->fetch();
    if ($user) {
        if(password_verify($wachtwoord, $user['wachtwoord'])){
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Onjuiste inloggegevens";
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
            justify-content: center;
        }
        form > input {
            margin-bottom: 10px;
        }
        header {
            width: 100vw;
            text-align: center;
            margin-bottom: 40px;
        }
        .registreer {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .registreer > button {
            margin-top: 10px;
            width: inherit;
        }
    </style>
</head>
<header>
    <h1>BakTech Webshop</h1>
</header>
<body>
    <form method="post">
        <label for="mial">Email</label>
        <input type="email" name="mail">
        <label for="wachtwoord">Wachtwoord</label>
        <input type="password" name="wachtwoord">
        <?php if (!empty($error)): ?>
            <div class="error" style="color:red; margin-bottom: 10px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button type="submit">Submit</button>
    </form>

    <form action="registreer.php" class="registreer">
        <label for="registreer">Nog geen account?</label>
        <button type="submit" name="registreer">Registreer</button>
    </form>

</body>
</html>