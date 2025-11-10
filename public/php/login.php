<!DOCTYPE html>
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

    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext = openssl_encrypt($wachtwoord, $cipher, $key, $options = 0, $iv, $tag);
    
}


?> 

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <style>
        body{
            display: flex;
            justify-content: center;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 200px;
        }
        form > input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<header>
</header>
<form action="" method="POST">
    <label for="naam">Naam</label>
    <input type="text" name="naam">
    <label for="wachtwoord">Wachtwoord</label>
    <input type="password" name="wachtwoord">
    <button type="submit">Submit</button>
</form>

</body>
</html>