<?php
$host = 'localhost';       // Host de MySQL
$db   = 'feed_db';         // Nombre de tu base de datos
$user = 'root';            // Usuario de MySQL
$pass = 'vertrigo';                // Contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Configuramos para que PDO lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
