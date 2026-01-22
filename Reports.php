<?php
session_start();
include 'config.php';

$profile_pic = 'img/member.png'; // foto default

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    $reportQuery = $conn->prepare("SELECT profile_pic FROM users WHERE id = :id");
    $reportQuery->bindParam(':id', $user_id, PDO::PARAM_INT);
    $reportQuery->execute();
    $user_pic = $reportQuery->fetch(PDO::FETCH_ASSOC);

    if($user_pic && $user_pic['profile_pic']){
        $profile_pic = htmlspecialchars($user_pic['profile_pic']);
    }
}

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_report'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'] ?? null;

    $photoName = null;

    if (!empty($_FILES['photo']['name'])) {
        $photoName = time() . "_" . basename($_FILES['photo']['name']);
        $targetPath = "uploads/" . $photoName;

        if(!move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)){
            $error = "Gabim gjatë ngarkimit të fotos ❌";
        }
    }

    if (empty($error)) {
        $stmt = $conn->prepare("
            INSERT INTO reports (user_id, name, email, city, type, description, photo)
            VALUES (:user_id, :name, :email, :city, :type, :description, :photo)
        ");

        if ($stmt->execute([
            ':user_id' => $user_id,
            ':name' => $name,
            ':email' => $email,
            ':city' => $city,
            ':type' => $type,
            ':description' => $description,
            ':photo' => $photoName
        ])) {
            $success = "Raporti u dërgua me sukses ✅";
        } else {
            $error = "Gabim gjatë dërgimit të raportit ❌";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Raportimet</title>
    <style>
        .success-message {
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .error-message {
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 15px;
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
            <li><a href="Reports.php" class="active">Raportimet</a></li>
            <li><a href="contact.php">Kontakti</a></li>
            <li><a href="quotes.php">Thenie</a></li>
        </ul>

        <div class="nav-buttons">
        <?php if(isset($_SESSION['user_id'])): ?>
            <span class="welcome">
                <span style="color:white;">Miresevjen,</span>
                <strong style="color:white;"><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
            </span>

            <a href="profile.php" class="profile-link">
                <img src="<?= $profile_pic ?>" alt="Profili Im" class="nav-profile-pic">
            </a>

            <?php if($_SESSION['is_admin'] == 1): ?>
                <a href="admin_dashboard.php" style="margin-left:10px;padding:10px 20px;background-color:green;color:white;text-decoration:none;border-radius:8px;transition:0.3s;">Dashboard</a>
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
        <h2>“Mbrojmë Natyrën, Përmirësojmë Kosovën”</h2>
        <p>Raporto ndotjet dhe ndihmo komunitetin të ketë një mjedis më të pastër</p>
        <a href="Reports.php#reportform" class="btn">Raporto Tani</a>
    </div>
</section>

<section class="report-section">
    <h2 id="reportform">Raporto Ndotjen</h2>

    <!-- Mesazhet e suksesit ose gabimit -->
    <?php if(!empty($success)): ?>
        <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if(!empty($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <form class="report-form" method="POST" enctype="multipart/form-data">
        <label for="name">Emri Juaj</label>
        <input type="text" id="name" name="name" placeholder="Shkruaj emrin tuaj" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Shkruaj emailin tuaj" required>

        <label for="city">Qyteti</label>
        <select id="city" name="city" required>
            <option value="">Zgjedh qytetin</option>
            <option value="prishtina">Prishtina</option>
            <option value="gjilan">Gjilan</option>
            <option value="mitrovice">Mitrovicë</option>
            <option value="prizren">Prizren</option>
        </select>

        <label for="type">Lloji i Ndotjes</label>
        <select id="type" name="type" required>
            <option value="">Zgjedh llojin</option>
            <option value="ajri">Ajri</option>
            <option value="ujit">Ujit</option>
            <option value="tokes">Tokës</option>
            <option value="zhurmes">Zhurmës</option>
        </select>

        <label for="description">Përshkrimi i Ndotjes</label>
        <textarea id="description" name="description" placeholder="Përshkruaj ndotjen..." required></textarea>

        <label for="photo">Ngarko Foto</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <button type="submit" name="submit_report" id="submit">Dërgo Raportin</button>
    </form>
</section>

<section class="latest-reports" id="shikoraporte">
    <h2>Raportet e Fundit</h2>
    <div class="reports-row">
        <div class="report-card">
            <img src="">
            <h4></h4>
            <p></p>
        </div>
        <div class="report-card">
            <img src="">
            <h4></h4>
            <p></p>
        </div>
        <div class="report-card">
            <img src="">
            <h4></h4>
            <p></p>
        </div>
    </div>
</section>

<section class="tips-section">
    <h2 id="keshilla">Këshilla Mjedisore për Shëndetin</h2>
    <div class="tips-container">
        <div class="tip-card">
            <img src="img/riciklimi.jpg" alt="Riciklimi" class="tip-img">
            <h3>Riciklo Mbeturinat</h3>
            <p>Ndihmo të mbash ambientin të pastër duke ndarë mbeturinat dhe ricikluar sa më shumë materiale të mundshme.</p>
        </div>
        <div class="tip-card">
            <img src="img/ajripastert.jpg" alt="Ajri i pastër" class="tip-img">
            <h3>Mbro Ajrin</h3>
            <p>Shfrytëzo transportin publik, biçikletën ose ecjen për të reduktuar emetimet e automjeteve.</p>
        </div>
        <div class="tip-card">
            <img src="img/energjia.png" alt="Energjia" class="tip-img">
            <h3>Kurse Energji</h3>
            <p>Përdor energji të ripërtëritshme dhe fik pajisjet kur nuk i përdor për të reduktuar ndotjen dhe shpenzimet.</p>
        </div>
        <div class="tip-card">
            <img src="img/pemet.jpg" alt="Pemë" class="tip-img">
            <h3>Shto Hije dhe Pemë</h3>
            <p>Mbjellja e pemëve ndihmon në pastrimin e ajrit dhe ul stresin, duke kontribuar në një mjedis më të shëndetshëm.</p>
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
