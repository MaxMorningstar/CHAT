<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Error: Debes iniciar sesión para publicar.");
}

if (isset($_POST['titulo']) && isset($_POST['contenido'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    $sql = "INSERT INTO posts (titulo, contenido) VALUES (:titulo, :contenido)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':contenido', $contenido);
    $stmt->execute();

    echo "OK";
} else {
    echo "Error: Datos incompletos";
}
?>
