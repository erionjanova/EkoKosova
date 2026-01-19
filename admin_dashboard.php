<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1){
    header("Location: Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Mirësevini, <?php echo $_SESSION['name']; ?> (Admin)</h2>
    <a href="logout.php">Dil</a>
</body>
</html>
