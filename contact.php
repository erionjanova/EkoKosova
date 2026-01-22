<?php
session_start();
include 'config.php';

$profile_pic = 'img/member.png'; 

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    $queryPic = $conn->prepare("SELECT profile_pic FROM users WHERE id = :id");
    $queryPic->bindParam(':id', $user_id, PDO::PARAM_INT);
    $queryPic->execute();
    $user_pic = $queryPic->fetch(PDO::FETCH_ASSOC);

    if($user_pic && $user_pic['profile_pic']){
        $profile_pic = htmlspecialchars($user_pic['profile_pic']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakti</title>
    <link rel="stylesheet" href="style.css">
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
            <li><a href="contact.php" class="active">Kontakti</a></li>
            <li><a href="quotes.php">Thenie</a></li>
        </ul>

       
        <div class="nav-buttons">
            <?php if(isset($_SESSION['user_id'])): ?>
                <span class="welcome">
                    <span style="color:white;">Miresevjen,</span>
                    <strong style="color:white;"><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                </span>

                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="profile-link">
                        <img src="<?= $profile_pic ?>" alt="Profili Im" class="nav-profile-pic">
                    </a>
                <?php endif; ?>

                <?php if($_SESSION['is_admin'] == 1): ?>
                    <a href="admin_dashboard.php"style=" margin-left:10px;padding: 10px 20px;background-color: green;color: white;text-decoration: none;border-radius: 8px;transition: 0.3s;">Dashboard</a>
                <?php endif; ?>

                <form action="Logout.php" method="POST" class="translate" style="display:inline; margin-left:5px;">
                    <button type="submit" class="translate">
                        <img src="img/logout.png" class="logoutsymbol" style="width:20px;">
                    </button>
                </form>

                <button class="translate" style="margin-left:5px;">🌐</button>

            <?php else: ?>
    
                <button class="login">
                    <a href="Login.php" style="text-decoration:none;color:white;">Kyçu</a>
                </button>

                <button class="signup">
                    <a href="Signup.php" style="text-decoration:none;color:white;">Regjistrohu</a>
                </button>

                <button class="translate">🌐</button>
            <?php endif; ?>
        </div>
    </nav>
</header>
<section class="hero">
    <div>
        <h2>Na kontaktoni</h2>
        <p>Ne jemi këtu për t'ju ndihmuar dhe për t'iu përgjigjur çdo pyetjeje që keni.</p>
    </div>
</section>

<section class="report-section">
    <h2>Na dërgoni një mesazh</h2>
    <form class="report-form">
        <label>Emri dhe Mbiemri</label>
        <input type="text" placeholder="Shkruani emrin tuaj" required>

        <label>Email </label>
        <input type="email" placeholder="Shkruani emailin tuaj" required>

        <label>Tema</label>
        <input type="text" placeholder="Tema e mesazhit" required>

        <label>Mesazhi</label>
        <textarea rows="5" placeholder="Shkruani mesazhin tuaj këtu..." required></textarea>
        <button id="submit">Dërgo</button>
    </form>
</section>

<section class="stats-section">
    <h2>Na kontaktoni</h2>

    <div class="cards-container">
        <div class="stats-card">
            <h3>📍 Lokacioni</h3>
            <p>Prishtinë, Kosovë</p>
        </div>

        <div class="stats-card">
            <h3>📞 Nr.telefonit</h3>
            <p>+383 44 123 456</p>
        </div>

        <div class="stats-card">
            <h3>📧 Email</h3>
            <p>info@ekokosova.com</p>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-about">
            <h3 class="logo">🌿 EkoKosova</h3>
            <p>“Mbrojmë Natyrën, Përmirësojmë Kosovën”</p>
        </div>
        <div class="footer-links">
            <h4>Navigimi</h4>
            <ul>
                <li><a href="index.php">Ballina</a></li>
                <li><a href="about.php">Rreth Nesh</a></li>
                <li><a href="Reports.php">Raportimet</a></li>
                <li><a href="contact.php">Kontakti</a></li>
                <li><a href="quotes.php">Thenie</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <h4>Kontakti</h4>
            <p>Email: info@ekokosova.com</p>
            <p>Tel: +383 44 123 456</p>
            <p>Prishtinë, Kosovë</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 EkoKosova. Të gjitha të drejtat e rezervuara.</p>
    </div>
</footer>

</body>
</html>
