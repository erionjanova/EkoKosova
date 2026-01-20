<?php
session_start();
include_once('config.php');

if(isset($_POST['submit'])){

    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($name) || empty($username) || empty($email) || empty($password) || empty($confirm_password)){
        $_SESSION['error_message'] = "⚠️ Plotesoni te gjitha fushat.";
        header("Location: SignUp.php");
        exit;
    } elseif($password !== $confirm_password){
        $_SESSION['error_message'] = "⚠️ Fjalekalimet nuk perputhen.";
        header("Location: SignUp.php");
        exit;
    }

    $checkSql = "SELECT id FROM users WHERE username = :username OR email = :email";
    $userQuery = $conn->prepare($checkSql);
    $userQuery->bindParam(':username', $username);
    $userQuery->bindParam(':email', $email);
    $userQuery->execute();

    if($userQuery->rowCount() > 0){
        $_SESSION['error_message'] = "⚠️ Username ose email ekziston tashme.";
        header("Location: SignUp.php");
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $is_admin = 0;

    $sql = "INSERT INTO users (name, email, username, password, is_admin) 
            VALUES (:name, :email, :username, :password, :is_admin)";
    $insertSql = $conn->prepare($sql);
    $insertSql->bindParam(':name', $name);
    $insertSql->bindParam(':email', $email);
    $insertSql->bindParam(':username', $username);
    $insertSql->bindParam(':password', $hashedPassword);
    $insertSql->bindParam(':is_admin', $is_admin);

    if($insertSql->execute()){
        $_SESSION['success_message'] = "✅ Regjistrimi u krye me sukses! Mund të kyçeni tani.";
        header("Location: SignUp.php");
        exit;
    } else {
        $_SESSION['error_message'] = "⚠️ Ndodhi një gabim gjate regjistrimit.";
        header("Location: SignUp.php");
        exit;
    }
}
?>
