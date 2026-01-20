<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1){
    header("Location: Login.php");
    exit;
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header("Location: konfigurimet.php");
    exit;
}

$id = intval($_GET['id']);

// Merr thënien ekzistuese
$stmt = $conn->prepare("SELECT * FROM quotes WHERE id=?");
$stmt->execute([$id]);
$quote = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$quote){
    echo "Thënia nuk ekziston.";
    exit;
}

if(isset($_POST['submit'])){
    $thenje_text = trim($_POST['thenje_text']);
    $autori = trim($_POST['autori']);
    $autor_img = $quote['autor_img'];

    if(isset($_FILES['autor_img']) && $_FILES['autor_img']['error'] == 0){
        $ext = pathinfo($_FILES['autor_img']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $ext;
        $target = "uploads/" . $filename;

        if(!is_dir('uploads')){
            mkdir('uploads', 0777, true);
        }

        if(move_uploaded_file($_FILES['autor_img']['tmp_name'], $target)){
            if($autor_img && file_exists($autor_img)){
                unlink($autor_img);
            }
            $autor_img = $target;
        }
    }

    $update = $conn->prepare("UPDATE quotes SET thenje_text=?, autori=?, autor_img=? WHERE id=?");
    $update->execute([$thenje_text, $autori, $autor_img, $id]);

    header("Location: konfigurimet.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Quote | EkoKosova</title>
<link rel="stylesheet" href="style.css">
<style>
.edit-container {
    max-width: 600px;
    margin: 50px auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
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

.edit-container textarea,
.edit-container input[type=text] {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #bfbfbf;
    border-radius: 8px;
    font-size: 15px;
}

.edit-container input[type=file] {
    margin-top: 10px;
}

img.preview{
    width:100px;
    height:100px;
    object-fit:cover;
    border-radius:50%;
    margin-top:10px;
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
            <li><a href="konfigurimet.php" class="active">Menaxho Theniet</a></li>
        </ul>

        <div class="nav-buttons">
            <button class="login">Mirësevjen, <?= htmlspecialchars($_SESSION['username']) ?></button>
            <form action="Logout.php" method="POST" style="display:inline;">
                <button type="submit" class="translate">
                    <img src="img/logout.png" style="width:20px;">
                </button>
            </form>
        </div>
    </nav>
</header>

<main class="edit-container">
    <a href="konfigurimet.php" class="back-link">⬅ Kthehu te Lista e Thenieve</a>
    <h2>✏️ Edit Thenien</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Thënie:</label>
        <textarea name="thenje_text" rows="4"><?= htmlspecialchars($quote['thenje_text']) ?></textarea>

        <label>Autor:</label>
        <input type="text" name="autori" value="<?= htmlspecialchars($quote['autori']) ?>">

        <label>Foto ekzistuese:</label><br>
        <?php if($quote['autor_img']): ?>
            <img src="<?= $quote['autor_img'] ?>" alt="foto autor" class="preview"><br>
        <?php else: ?>
            <p>Nuk ka foto të ngarkuar</p>
        <?php endif; ?>

        <label>Ngarko foto te re (opsionale):</label>
        <input type="file" name="autor_img" accept="image/*">

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
