<?php
session_start();
include 'config.php';


if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1){
    header("Location: Login.php");
    exit;
}

$result = $conn->query("SELECT id, name, username, email, is_admin FROM users");

$profile_pic = 'img/member.png'; 

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    $queryPic = $conn->prepare("SELECT profile_pic FROM users WHERE id = :id");
    $queryPic->bindParam(':id', $user_id, PDO::PARAM_INT); // e lidh vleren reale te $user_id me :id PDO::PARAM_INT tregon qe eshte integer
    $queryPic->execute(); // ekzekutohet
    $user_pic = $queryPic->fetch(PDO::FETCH_ASSOC); // kur ekzekutohet merr nje array asociative ku qdo kolon nga databaza ka me jep nje key ne kete array me emer tvet

    if($user_pic && $user_pic['profile_pic']){ // e kontrollon nese useri ekziston edhe kontrollon nese fusha e fotos ka vlere pra nese eshte ngarkuar foto perndryshe nuk vazhdon
        $profile_pic = htmlspecialchars($user_pic['profile_pic']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | EkoKosova</title>
<link rel="stylesheet" href="style.css"> 
<style>

.dashboard-container {
    border: 3px solid #4CAF50; 
    padding: 30px 20px;
    border-radius: 10px;
    width: 100%;
    max-width: 1200px;
    margin: 20px auto;
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    box-sizing: border-box;
}

.dashboard-label {
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    color: #4CAF50;
    margin-bottom: 20px; 
}

.dashboard-buttons {
    display: flex;
    justify-content: center; 
    gap: 20px;
    flex-wrap: wrap; 
}

.dashboard-buttons .btn {
    padding: 15px 30px;
    background: linear-gradient(90deg, #4CAF50, #2E7D32);
    color: white;
    text-decoration: none;
    font-weight: bold;
    border-radius: 8px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.dashboard-buttons .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 10px rgba(0,0,0,0.3);
}

.close {
    float: right;
    font-size: 22px;
    cursor: pointer;
}

.footer{
    margin-top:88px;
}
@media screen and (max-width:768px){
    .dashboard-container {
        flex-direction: column;
        align-items: center;
    }
    .dashboard-card {
        width: 90%;
    }
    .user-table {
        font-size: 14px;
    }
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
            <li><a href="contact.php">Kontakti</a></li>
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
<div class="dashboard-container">
    <div class="dashboard-label">Quick Actions</div>
    <div class="dashboard-buttons">
        <a href="manage_users.php" class="btn">👥 Menaxho Userat</a>
        <a href="manage_reports.php" class="btn">📄 Menaxho Raportimet</a>
        <a href="manage_contacts.php" class="btn">📞 Menaxho Kontaktimet</a>
        <a href="konfigurimet.php" class="btn">⚙️ Konfigurimet</a>
    </div>
</div>


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
