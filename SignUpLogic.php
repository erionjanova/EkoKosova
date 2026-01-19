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
        echo "<script>alert('Plotësoni të gjitha fushat.'); window.history.back();</script>";
        exit;
    }

    if($password !== $confirm_password){
        echo "<script>alert('Fjalëkalimet nuk përputhen.'); window.history.back();</script>";
        exit;
    }

    $checkSql = "SELECT id FROM users WHERE username = :username OR email = :email";
    $stmt = $conn->prepare($checkSql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        echo "<script>alert('Username ose email ekziston tashmë.'); window.history.back();</script>";
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, username, password, is_admin) 
            VALUES (:name, :email, :username, :password)";
    $insertSql = $conn->prepare($sql);
    $insertSql->bindParam(':name', $name);
    $insertSql->bindParam(':email', $email);
    $insertSql->bindParam(':username', $username);
    $insertSql->bindParam(':password', $hashedPassword);

    
    if($insertSql->execute()){
        echo "<script>alert('Regjistrimi u krye me sukses!'); window.location='Login.php';</script>";
        exit;
    } else {
        echo "<script>alert('Ndodhi një gabim gjatë regjistrimit.'); window.history.back();</script>";
        exit;
    }
}
?>
