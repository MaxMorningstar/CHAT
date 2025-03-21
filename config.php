<?php
session_start();  // Importante para usar sesiones en todas las páginas

$host = 'localhost'; // o 127.0.0.1
$db   = 'feed_db';
$user = 'root';
$pass = 'vertrigo';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
