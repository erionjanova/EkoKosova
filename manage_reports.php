<?php
session_start();
include 'config.php';


if(!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1){
    header("Location: Login.php");
    exit;
}

echo "MENAXHIMI I RAPORTIMEVE!!! COMING SOON...";
?>
