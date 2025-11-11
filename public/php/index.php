    <?php
    // db-connect.php
    $host = '127.0.0.1';
    $db   = 'project_week';
    $user = 'root'; // jouw DB-gebruiker
    $pass = '';     // jouw wachtwoord
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die("Database connectie mislukt: " . $e->getMessage());
    }

    // Haal alle producten op
    $stmt = $pdo->query("SELECT * FROM producten ORDER BY barcode ASC");
    $producten = $stmt->fetchAll();
    ?>
    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BakTech Webshop</title>
        <link rel="stylesheet" href="../css/style.css">
        <style>
            /* Product grid styling */
            .product-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
            }
            .product {
                border: 1px solid #ccc;
                padding: 10px;
                width: 250px;
                text-align: center;
            }
            .product img {
                max-width: 200px;
                max-height: 200px;
            }
            .prijs {
                font-weight: bold;
                margin-top: 5px;
            }
            .hero {
                text-align: center;
                margin-bottom: 40px;
            }
        </style>
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

    <main>
        <section class="hero">
            <h2>Welkom bij BakTech</h2>
            <p>Machines voor elke professionele bakkerij.</p>
        </section>

        <section class="product-grid">
            <?php foreach ($producten as $product): ?>
                <div class="product">
                    <h3><?= htmlspecialchars($product['naam']) ?></h3>
                    <img src="<?= htmlspecialchars($product['foto_url']) ?>" alt="<?= htmlspecialchars($product['naam']) ?>">
                    <div class="prijs">€<?= number_format($product['prijs'], 2, ',', '.') ?></div>
                    <button onclick="addToCart('<?= htmlspecialchars($product['naam']) ?>', <?= $product['prijs'] ?>)">Toevoegen</button>
                </div>
            <?php endforeach; ?>
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
    // Winkelwagen functionaliteit
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
