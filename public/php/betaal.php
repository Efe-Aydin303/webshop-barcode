<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrekenen - BakTech</title>
    <link rel="stylesheet" href="../css/style.css">

    <!-- Barcode font -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">

    <style>
        .checkout-main {
            text-align: center;
            margin-top: 40px;
        }

        #checkoutItems {
            display: inline-block;
            text-align: left;
            border: 1px solid #ccc;
            padding: 20px 40px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .checkout-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }

        .barcode {
            font-family: 'Libre Barcode 39 Text', cursive;
            font-size: 40px;
            text-align: center;
            display: block;
            margin: 0 auto 10px auto;
            color: #333;
        }

        #checkoutTotal {
            margin-top: 25px;
            font-weight: bold;
        }

        #placeOrder {
            margin-top: 15px; /* iets hoger */
            padding: 10px 24px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<header>
    <h1>BakTech Webshop</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="cart.php">Winkelwagen</a>
        <a href="vragen.php">Vragen</a>
        <form action="logout.php" method="post" style="display:inline;">
            <button type="submit" name="logout" class="nav-button">Logout</button>
        </form>
    </nav>
</header>

<main class="checkout-main">
    <h2>Bestelling Bevestigen</h2>
    <section id="checkoutItems"></section>
    <p id="checkoutTotal"></p>
    <button id="placeOrder">Bestelling Plaatsen</button>
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
const checkoutCart = JSON.parse(localStorage.getItem('checkoutCart')) || [];
const section = document.getElementById('checkoutItems');
const totalEl = document.getElementById('checkoutTotal');
let total = 0;

if (checkoutCart.length === 0) {
    section.innerHTML = '<p>Geen producten gevonden.</p>';
} else {
    checkoutCart.forEach(item => {
        section.innerHTML += `
            <div class="checkout-item">
                <span class="barcode">*${item.id || '000'}*</span>
                <p style="text-align:center;">${item.name} (${item.quantity}x) - €${item.price * item.quantity}</p>
            </div>
        `;
        total += item.price * item.quantity;
    });
    totalEl.textContent = `Totaal: €${total}`;
}

document.getElementById('placeOrder').onclick = () => {
    alert('Bestelling succesvol geplaatst!');
    localStorage.removeItem('cart');
    localStorage.removeItem('checkoutCart');
    window.location.href = 'index.php';
};
</script>
</body>
</html>
