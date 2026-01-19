<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Kyçu</title>
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
            <button class="login"><a href="Login.php" style="text-decoration: none;  color: white;">Kyçu</a></button>
            <button class="signup"><a href="Signup.php" style="text-decoration: none;  color: white;">Regjistrohu</a></button>
            <button class="translate">🌐</button>
         </div>
    </nav>
</header>

    <div class="login-container">
    <div class="login-card">
        <h2>Kyçu</h2>

        <form action="LoginLogic.php" method="post">
            <label>Username</label>
            <input type="text" placeholder="Shkruani username tuaj" name="username" required>

            <label>Fjalëkalimi</label>
            <input type="password" placeholder="Shkruani fjalëkalimin tuaj" name="password" required>

            <button class="login-btn" type="submit" name="submit">Kyçu</button>
        </form>

        <a href="#">Keni harruar fjalëkalimin tuaj?</a>
        <a href="Signup.php">Regjistrohu</a>
    </div>
</div>
    
</body>
</html>