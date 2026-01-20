<?php
session_start();
include_once('config.php');

$error_message = ""; 

if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        $error_message = "⚠️ Ju lutem plotesoni të gjitha fushat.";
    } else {
 
        $sql = "SELECT id, name, username, email, password, is_admin FROM users WHERE username = :username";
        $userQuery = $conn->prepare($sql);
        $userQuery->bindParam(':username', $username);
        $userQuery->execute();

        $user = $userQuery->fetch(PDO::FETCH_ASSOC);

        if(!$user){
            $error_message = "⚠️ Username nuk ekziston.";
        } else if(!password_verify($password, $user['password'])){
            $error_message = "⚠️ Fjalekalimi është i gabuar.";
        } else {
           
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'];

            if($user['is_admin'] == 1){
                header("Location: admin_dashboard.php");
                exit;
            } else {
                header("Location: index.php");
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Kyçu</title>

<style>  
    .error-alert {
        max-width: 400px;
        margin: 15px auto;
        padding: 15px 20px;
        background-color: #f8d7da; 
        color: #842029;
        border-left: 5px solid #f5c2c7;
        border-radius: 8px;
        font-weight: bold;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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

       <?php if($error_message != ""): ?>
            <div class="error-alert">
                <p><?= $error_message ?></p>
            </div>
        <?php endif; ?>

        <form method="post">
            <label>Username</label>
            <input type="text" placeholder="Shkruani username tuaj" name="username">

            <label>Fjalëkalimi</label>
            <input type="password" placeholder="Shkruani fjalëkalimin tuaj" name="password">

            <button class="login-btn" type="submit" name="submit">Kyçu</button>
        </form>

        <a href="#">Keni harruar fjalëkalimin tuaj?</a>
        <a href="Signup.php">Regjistrohu</a>
    </div>
</div>

    
</body>
</html>