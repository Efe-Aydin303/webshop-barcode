<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Winkelwagen - BakTech</title>
<link rel="stylesheet" href="../css/style.css">

<style>
.cart-main {
    max-width: 900px;
    margin: 40px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}
.cart-main h2 { text-align: center; color: #003366; margin-bottom: 30px; }

table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
th, td { padding: 15px; text-align: center; border-bottom: 1px solid #ddd; }
th { background-color: #003366; color: white; }

input[type=number] { width: 60px; padding: 5px; border-radius: 5px; border: 1px solid #ccc; text-align: center; }

button { background-color: #003366; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
button:hover { background-color: #0055aa; }

#cartTotal { text-align: right; font-weight: bold; font-size: 1.2em; color: #003366; }
#checkoutBtn, #clearCart { display: inline-block; margin: 10px 5px; }
</style>
</head>
<body>

<header>
<h1>BakTech Webshop</h1>
<nav>
<a href="index.php">Home</a>
<a href="cart.php">Winkelwagen</a>
<a href="vragen.php">Vragen</a>
<?php if(isset($_SESSION['user_id'])): ?>
<form action="logout.php" method="post" style="display:inline;">
<button type="submit" name="logout" class="nav-button">Logout</button>
</form>
<?php else: ?>
<a href="login.php">Login</a>
<?php endif; ?>
</nav>
</header>

<main class="cart-main">
<h2>Jouw Winkelwagen</h2>
<table id="cartTable">
<thead>
<tr>
<th>Product</th>
<th>Aantal</th>
<th>Prijs per stuk</th>
<th>Totaal</th>
<th>Verwijder</th>
</tr>
</thead>
<tbody></tbody>
</table>

<p id="cartTotal"></p>
<button id="clearCart">Winkelwagen Leegmaken</button>
<button id="checkoutBtn">Afrekenen</button>
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

// Tabel renderen
function renderCart() {
    const tbody = document.querySelector('#cartTable tbody');
    tbody.innerHTML = '';
    let total = 0;

    if(cart.length === 0){
        tbody.innerHTML = '<tr><td colspan="5">Winkelwagen is leeg.</td></tr>';
    } else {
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            tbody.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="quantity-input">
                    </td>
                    <td>€${item.price.toFixed(2)}</td>
                    <td>€${itemTotal.toFixed(2)}</td>
                    <td><button class="removeBtn" data-index="${index}">X</button></td>
                </tr>
            `;
        });
    }

    document.getElementById('cartTotal').textContent = `Totaal: €${total.toFixed(2)}`;

    // Event listeners toevoegen
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', (e) => {
            const idx = e.target.dataset.index;
            let val = parseInt(e.target.value);
            if(val < 1) val = 1;
            cart[idx].quantity = val;
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        });
    });

    document.querySelectorAll('.removeBtn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const idx = e.target.dataset.index;
            cart.splice(idx, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        });
    });
}

// Winkelwagen leegmaken
document.getElementById('clearCart').onclick = () => {
    cart = [];
    localStorage.removeItem('cart');
    renderCart();
};

// Afrekenen
document.getElementById('checkoutBtn').onclick = () => {
    if(cart.length === 0){
        alert('Je winkelwagen is leeg.');
        return;
    }
    localStorage.setItem('checkoutCart', JSON.stringify(cart));
    window.location.href = 'betaal.php';
};

// Initial render
renderCart();
</script>

</body>
</html>
