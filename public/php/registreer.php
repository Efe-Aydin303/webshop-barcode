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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wachtwoord = $_POST['wachtwoord'];
    
    $cipher = 'aes-128-gcm';
    $key = substr(hash('sha256', 'key123', true), 0, 16);
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $tag = '';
    $ciphertext_raw = openssl_encrypt($wachtwoord, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag, '', 16);
    $ciphertext = base64_encode($iv . $tag . $ciphertext_raw);
    // $stmt = $pdo->prepare('INSERT INTO gebruiker (naam, wachtwoord) VALUES (:naam, :ciphertext)');
    // $stmt->execute([
    //     'naam' => $_POST['naam'],
    //     'ciphertext' => $ciphertext,
    // ]);
    header("Location: index.php");
    exit;
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

<form action="login.php">
    <label for="login">Al een account?</label>
    <button type="submit" name="login">login</button>
</form>

</body>
</html>