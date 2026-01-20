<?php
session_start();

$user = "root";
$pass = "root";
$server = "localhost";
$dbname = "ekokosova";

try {
    $conn = new PDO("mysql:host=$server;dbname=$dbname;charset=utf8",$user,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Gabim në lidhje me DB: " . $e->getMessage());
}
?>
