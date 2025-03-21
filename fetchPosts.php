<?php
require_once 'config.php';

// Consulta con subconsultas para contar likes y dislikes
$sql = "SELECT 
            p.id, 
            p.titulo, 
            p.contenido, 
            p.fecha,
            (SELECT COUNT(*) FROM post_reactions r 
                WHERE r.post_id = p.id AND r.reaction = 'like') AS likes,
            (SELECT COUNT(*) FROM post_reactions r 
                WHERE r.post_id = p.id AND r.reaction = 'dislike') AS dislikes
        FROM posts p
        ORDER BY p.fecha DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($posts);
?>
