<?php
include 'db-connect.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BakTech Webshop</title>
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

<main>
    <section class="hero">
        <h2>Welkom bij BakTech</h2>
        <p>Machines voor elke professionele bakkerij.</p>
    </section>

    <section class="product-grid">
        <?php
        $sql = "SELECT * FROM producten";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Afbeeldingpad direct vanuit database gebruiken
                $imgPath = $row['afbeelding'];

                echo '<div class="product">';
                echo '<img src="' . $imgPath . '" alt="' . $row['naam'] . '">';
                echo '<h3>' . $row['naam'] . '</h3>';
                echo '<p>€' . $row['prijs'] . '</p>';
                echo '<button onclick="addToCart(\'' . $row['naam'] . '\', ' . $row['prijs'] . ')">Toevoegen</button>';
                echo '</div>';
            }
        } else {
            echo '<p>Geen producten gevonden.</p>';
        }

        $conn->close();
        ?>
    </section>
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

<script>
function addToCart(name, price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let existing = cart.find(item => item.name === name);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({ name: name, price: price, quantity: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    alert(name + " is toegevoegd aan je winkelwagen!");
}
</script>
</body>
</html>
