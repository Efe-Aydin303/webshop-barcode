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
    if (isset($_POST['naam']) && isset($_POST['wachtwoord'])) {
        $wachtwoord = $_POST['wachtwoord'];
        if ($wachtwoord == $_POST['wachtwoord2']) {
            $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO gebruiker (naam, wachtwoord) VALUES (:naam, :password)');
            $stmt->execute([
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

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
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
    </style>
</head>
<body>
    
<header>
</header>
<form method="post">
    <label for="naam">Naam</label>
    <input type="text" name="naam">
    <label for="wachtwoord">Wachtwoord</label>
    <input type="password" name="wachtwoord">
    <label for="wachtwoord2">Bevestig Wachtwoord</label>
    <input type="password" name="wachtwoord2">
    <button type="submit">Submit</button>
</form>

<form action="login.php">
    <label for="login">Al een account?</label>
    <button type="submit" name="login">login</button>
</form>

</body>
</html>