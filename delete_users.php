<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1){
    header("Location: Login.php");
    exit;
}

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];

    if($id == $_SESSION['user_id']){
        echo "<script>alert('Nuk mund te fshini veten.'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: manage_users.php");
    exit;
} else {
    header("Location: manage_users.php");
    exit;
}
?>
