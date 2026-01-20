<?php
session_start();
include 'config.php';

// Vetëm admin mund të hyjë
if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1){
    header("Location: Login.php");
    exit;
}

// Merr ID nga URL
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("Location: admin_dashboard.php");
    exit;
}

$id = $_GET['id'];

// Merr userin nga DB
$stmt = $conn->prepare("SELECT id, name, username, email, is_admin FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user){
    echo "Useri nuk ekziston.";
    exit;
}

// Nëse forma është dorëzuar
if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $userQuery = $conn->prepare("UPDATE users SET name=:name, username=:username, email=:email, is_admin=:is_admin WHERE id=:id");
    $userQuery->bindParam(':name', $name);
    $userQuery->bindParam(':username', $username);
    $userQuery->bindParam(':email', $email);
    $userQuery->bindParam(':is_admin', $is_admin);
    $userQuery->bindParam(':id', $id);
    $userQuery->execute();

    header("Location: manage_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit User | EkoKosova</title>
<link rel="stylesheet" href="style.css">
<style>

.edit-container {
    max-width: 500px;
    margin: 50px auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    text-align: left;
    font-family: Arial, sans-serif;
}

.edit-container h2 {
    color: #2e7d32;
    margin-bottom: 25px;
    text-align: center;
}

.edit-container label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
    color: #2e7d32;
}

.edit-container input[type=text],
.edit-container input[type=email] {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #bfbfbf;
    border-radius: 8px;
    font-size: 15px;
}

.edit-container input[type=checkbox] {
    margin-top: 15px;
    transform: scale(1.2);
}

.edit-container input[type=submit] {
    margin-top: 25px;
    width: 100%;
    padding: 12px;
    background-color: #2e7d32;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.edit-container input[type=submit]:hover {
    background-color: #1b5e20;
}

.back-link {
    display: inline-block;
    margin-bottom: 20px;
    color: #2e7d32;
    text-decoration: none;
    font-weight: bold;
}
.back-link:hover {
    text-decoration: underline;
}
</style>
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
            <li><a href="quotes.php">Thenje</a></li>
            <li><a href="contact.php">Kontakti</a></li>
            <li><a href="manage_users.php" class="active">Menaxho Userat</a></li>
        </ul>

        <div class="nav-buttons">
            <button class="login">Mirësevjen, <?= htmlspecialchars($_SESSION['username']) ?></button>
            <form action="Logout.php" method="POST" style="display:inline;">
                <button type="submit" class="translate">
                    <img src="img/logout.png" class="logoutsymbol" style="width:20px;">
                </button>
            </form>
        </div>
    </nav>
</header>

<main class="edit-container">
    <a href="admin_dashboard.php" class="back-link">⬅ Kthehu ne Dashboard</a>
    <h2>✏️ Edit User: <?= htmlspecialchars($user['username']) ?></h2>

    <form method="POST">
        <label>Emri:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>
            <input type="checkbox" name="is_admin" <?= $user['is_admin'] ? 'checked' : '' ?>> Admin
        </label>

        <input type="submit" name="submit" value="Ruaj Ndryshimet">
    </form>
</main>

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
                <li><a href="quotes.php">Thenje</a></li>
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
