<?php
require_once 'config.php';

// Debe estar logueado
if (!isset($_SESSION['user_id'])) {
    die("Error: No has iniciado sesión.");
}

if (isset($_POST['postId']) && isset($_POST['reaction'])) {
    $postId = $_POST['postId'];
    $reaction = $_POST['reaction'];  // "like" o "dislike"
    $userId = $_SESSION['user_id'];

    // 1) Verificar si el usuario ya reaccionó a este post
    $checkSql = "SELECT reaction FROM post_reactions 
                 WHERE user_id = :userId AND post_id = :postId";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([
        ':userId' => $userId,
        ':postId' => $postId
    ]);
    $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing) {
        // 2) Si no existe, insertamos
        $insertSql = "INSERT INTO post_reactions (user_id, post_id, reaction) 
                      VALUES (:userId, :postId, :reaction)";
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->execute([
            ':userId' => $userId,
            ':postId' => $postId,
            ':reaction' => $reaction
        ]);
        echo "OK";
    } else {
        // 3) Si ya existe, NO hacemos nada (solo un like o dislike por usuario)
        // Si quisieras permitir cambiar la reacción, descomenta:
        /*
        if ($existing['reaction'] !== $reaction) {
            $updateSql = "UPDATE post_reactions 
                          SET reaction = :reaction 
                          WHERE user_id = :userId AND post_id = :postId";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                ':reaction' => $reaction,
                ':userId' => $userId,
                ':postId' => $postId
            ]);
        }
        */
        echo "OK";
    }
} else {
    echo "Error: Datos inválidos";
}
?>
