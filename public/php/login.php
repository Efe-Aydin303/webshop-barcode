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
    $wachtwoord = $_POST['wachtwoord'];
    $naam = $_POST['naam'];
    $stmt = $pdo->prepare('SELECT * FROM gebruiker WHERE naam = :naam');
    $stmt->execute(['naam' => $naam]);
    $user = $stmt->fetch();
    if ($user) {
        $cipher = 'aes-128-gcm';
        $key = substr(hash('sha256', 'key123', true), 0, 16);
        $c = base64_decode($user['wachtwoord']);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($c, 0, $ivlen);
        $tag = substr($c, $ivlen, 16);
        $ciphertext_raw = substr($c, $ivlen + 16);
        $decrypted_wachtwoord = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
        if ($decrypted_wachtwoord === $wachtwoord) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            echo "<h3 style=color:red>Onjuiste naam of wachtwoord</h3>";
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
    <button type="submit">Submit</button>
</form>

<form action="registreer.php">
    <label for="registreer">Nog geen account?</label>
    <button type="submit" name="registreer">Registreer</button>
</form>

</body>
</html>