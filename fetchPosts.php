<?php
require_once 'config.php';

// Consulta de todas las publicaciones, ordenadas por fecha descendente
$sql = "SELECT id, titulo, contenido, likes, dislikes, fecha
        FROM posts
        ORDER BY fecha DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolvemos la lista de publicaciones en formato JSON
header('Content-Type: application/json');
echo json_encode($posts);
?>
