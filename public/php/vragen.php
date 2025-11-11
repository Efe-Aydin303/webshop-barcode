<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vragen - BakTech</title>
    <link rel="stylesheet" href="../css/style.css">
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

<main class="hero">
    <h2>Stel je vraag</h2>
    <p>Heb je vragen over onze machines? Vul hieronder je vraag in:</p>

    <form class="vragen-form">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="vraag">Vraag:</label>
        <textarea id="vraag" name="vraag" rows="5" required></textarea>

        <button type="submit">Verstuur</button>
    </form>
</main>

<footer>
    <p>&copy; 2025 BakTech. Alle rechten voorbehouden.</p>
</footer>
</body>
</html>
