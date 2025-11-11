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
    <title>Winkelwagen - BakTech</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <h1>BakTech Webshop</h1>
    <nav>
        <a href="index.php">Home</a>
        <!-- <a href="login.php">Login</a> -->
        <a href="cart.php">Winkelwagen</a>
        <a href="vragen.php">Vragen</a>
        <form action="logout.php" method="post" style="display:inline;">
            <button type="submit" name="logout" class="nav-button">Logout</button>
        </form>
    </nav>
</header>

<main class="cart-main">
    <h2>Jouw Winkelwagen</h2>
    <section class="cart-page">
        <table id="cartTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Prijs</th>
                    <th>Aantal</th>
                    <th>Totaal</th>
                    <th>Verwijderen</th>
                </tr>
            </thead>
            <tbody id="cartItems"></tbody>
        </table>
        <p id="cartTotal">Totaal: €0</p>
        <button id="clearCart">Winkelwagen leegmaken</button>
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
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function updateCartDisplay() {
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    cartItems.innerHTML = '';
    let total = 0;

    cart.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.name}</td>
            <td>€${item.price}</td>
            <td><input type="number" min="1" value="${item.quantity}" onchange="updateQuantity(${index}, this.value)"></td>
            <td>€${item.price * item.quantity}</td>
            <td><button onclick="removeItem(${index})">✖</button></td>
        `;
        cartItems.appendChild(row);
        total += item.price * item.quantity;
    });

    cartTotal.textContent = `Totaal: €${total}`;
}

function removeItem(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

function updateQuantity(index, value) {
    value = parseInt(value);
    if (value < 1) value = 1;
    cart[index].quantity = value;
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

document.getElementById('clearCart').onclick = () => {
    cart = [];
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

updateCartDisplay();
</script>
</body>
</html>
