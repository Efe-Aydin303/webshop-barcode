<?php
require __DIR__ . '/db-connect.php';

// Vragen ophalen (nieuwste eerst)
$stmt = $pdo->query("SELECT * FROM vragen ORDER BY created_at DESC");
$vragen = $stmt->fetchAll();

$errors = [];

// Nieuwe vraag verwerken
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barcode = trim($_POST['barcode'] ?? '');
    $titel = trim($_POST['titel'] ?? '');
    $beschrijving = trim($_POST['beschrijving'] ?? '');

    if (empty($titel) || empty($beschrijving)) {
        $errors[] = "Titel en beschrijving zijn verplicht.";
    }

    if (empty($barcode)) {
        $errors[] = "Barcode is verplicht.";
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM producten WHERE barcode = :barcode");
        $stmt->execute(['barcode' => $barcode]);
        if ($stmt->fetchColumn() == 0) {
            $errors[] = "De ingevoerde barcode bestaat niet.";
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO vragen (barcode, titel, beschrijving) VALUES (:barcode, :titel, :beschrijving)");
        $stmt->execute([
            'barcode' => $barcode,
            'titel' => $titel,
            'beschrijving' => $beschrijving
        ]);

        header("Location: vragen.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BakTech Webshop - Vragen</title>
<link rel="stylesheet" href="../css/style.css">
<style>
.hero { text-align: center; background: #e0e0e0; padding: 50px 20px; margin-bottom: 20px; }

/* Vragen lijst gecentreerd */
.vragen-lijst { display: flex; flex-direction: column; align-items: center; }
.vraag { background: white; border-radius: 10px; padding: 15px; margin-bottom: 15px; box-shadow: 0 0 8px rgba(0,0,0,0.1); max-width: 600px; width: 100%; text-align: center; }
.vraag-title { font-weight: bold; color: #003366; margin-bottom: 5px; }
.vraag-desc { margin-bottom: 5px; }
.vraag-date { font-size: 0.8em; color: #666; }

/* Formulier */
.vragen-form { max-width: 600px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
.vragen-form label { display: block; margin-top: 10px; font-weight: bold; }
.vragen-form input, .vragen-form textarea { width: 100%; padding: 8px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc; }
.vragen-form button { margin-top: 15px; padding: 10px 20px; background-color: #003366; color: white; border: none; border-radius: 5px; cursor: pointer; }
.vragen-form button:hover { background-color: #0055aa; }
.error { background: #ffdddd; border: 1px solid #ff5c5c; padding: 10px; margin-bottom: 15px; border-radius: 5px; color: #900; text-align: center; }
</style>
</head>
<body>

<header>
    <h1>BakTech Webshop</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="cart.php">Winkelwagen</a>
        <a href="vragen.php">Vragen</a>
    </nav>
</header>

<main>
    <div class="container">
        <section class="hero">
            <h2>Veelgestelde Vragen & Stel je eigen vraag</h2>
            <p>Bekijk de meest gestelde vragen of stel een nieuwe vraag over onze machines.</p>
        </section>

        <?php if(!empty($errors)): ?>
            <div class="error">
                <?php foreach($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <section class="vragen-lijst">
            <h2 style="text-align:center;">Veelgestelde Vragen</h2>
            <?php if ($vragen): ?>
                <?php foreach ($vragen as $vraag): ?>
                    <div class="vraag">
                        <div class="vraag-title"><?= htmlspecialchars($vraag['titel']) ?></div>
                        <div class="vraag-desc"><?= htmlspecialchars($vraag['beschrijving']) ?></div>
                        <div class="vraag-date">(<?= $vraag['created_at'] ?>)</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center;">Er zijn nog geen vragen gesteld.</p>
            <?php endif; ?>
        </section>

        <section class="vragen-formulier">
            <h2 style="text-align:center;">Stel je eigen vraag</h2>
            <form class="vragen-form" method="post">
                <label for="titel">Titel van je vraag</label>
                <input type="text" name="titel" id="titel" placeholder="Titel van je vraag" required>

                <label for="beschrijving">Beschrijving</label>
                <textarea name="beschrijving" id="beschrijving" rows="4" placeholder="Beschrijf je vraag..." required></textarea>

                <label for="barcode">Barcode (verplicht)</label>
                <input type="text" name="barcode" id="barcode" placeholder="Voer een geldige barcode in" required>

                <button type="submit">Verstuur vraag</button>
            </form>
        </section>
    </div>
</main>

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h4>Over BakTech</h4>
            <p>Wij leveren betrouwbare machines voor elke professionele bakkerij.</p>
        </div>
        <div class="footer-section">
            <h4>Contact</h4>
            <p>Email: info@baktech.nl</p>
            <p>Tel: 074-1234567</p>
        </div>
        <div class="footer-section">
            <h4>Volg ons</h4>
            <p><a href="#">Instagram</a> | <a href="#">LinkedIn</a></p>
        </div>
    </div>
    <p class="footer-bottom">&copy; 2025 BakTech. Alle rechten voorbehouden.</p>
</footer>

</body>
</html>
