<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Si estuvieras usando password_hash, harías: 
            // if (password_verify($password, $user['password'])) { ... }
            // Aquí, simplificamos:
            if ($password === $user['password']) {
                // Credenciales válidas
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit;
            }
        }
        $error = "Usuario o contraseña incorrectos.";
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <h1>Iniciar sesión</h1>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post" action="">
    <label>Nombre de usuario:</label><br>
    <input type="text" name="username"><br><br>
    
    <label>Contraseña:</label><br>
    <input type="password" name="password"><br><br>
    
    <button type="submit">Login</button>
  </form>
  <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
</body>
</html>
