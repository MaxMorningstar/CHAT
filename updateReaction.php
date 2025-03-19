<?php
require_once 'config.php';

if (isset($_POST['postId']) && isset($_POST['reaction'])) {
    $postId = $_POST['postId'];
    $reaction = $_POST['reaction'];  // Puede ser "like" o "dislike"

    if ($reaction === 'like') {
        $sql = "UPDATE posts SET likes = likes + 1 WHERE id = :postId";
    } else if ($reaction === 'dislike') {
        $sql = "UPDATE posts SET dislikes = dislikes + 1 WHERE id = :postId";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->execute();

    echo "OK";
} else {
    echo "Error: Datos inválidos";
}
?>
