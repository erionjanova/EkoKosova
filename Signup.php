<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Krijo Llogari</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">🌿 EkoKosova</div>
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-icon">&#9776;</label>
            <ul class="nav-links">
                <li><a href="index.php">Ballina</a></li>
                <li><a href="about.php">Rreth Nesh</a></li>
                <li><a href="Reports.php">Raportimet</a></li>
                <li><a href="contact.php">Kontakti</a></li>
                <li><a href="quotes.php">Thenje</a></li>
            </ul>
            <div class="nav-buttons">
                <button class="login"><a href="Login.php" style="text-decoration: none; color: white;">Kyçu</a></button>
                <button class="signup"><a href="Signup.php" style="text-decoration: none; color: white;">Regjistrohu</a></button>
                <button class="translate">🌐</button>
            </div>
        </nav>
    </header>

    <div class="signup-container">
        <div class="signup-card">
            <h2>Krijo llogari</h2>

            <form action="signupLogic.php" method="post">
                <label>Emri dhe Mbiemri</label>
                <input type="text" name="name" placeholder="Shkruani Emrin dhe Mbiemrin" required>

                <label>Email</label>
                <input type="email" name="email" placeholder="Shkruani emailin tuaj" required>

                <label>Username</label>
                <input type="text" name="username" placeholder="Shkruani username tuaj" required>

                <label>Fjalëkalimi</label>
                <input type="password" name="password" placeholder="Krijo një fjalëkalim" required>

                <label>Konfirmo fjalëkalimin</label>
                <input type="password" name="confirm_password" placeholder="Konfirmo fjalëkalimin" required>

                <button class="signup-btn" type="submit" name="submit">Regjistrohu</button>
            </form>

            <a href="Login.php">Keni tashmë një llogari? Kyçu</a>
        </div>
    </div>
</body>
</html>
