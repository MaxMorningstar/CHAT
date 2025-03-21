<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // En un entorno real, se recomienda:
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Aquí lo hacemos “tal cual” por simplicidad.
        $hashedPassword = $password;

        // Insertamos el nuevo usuario
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword
        ]);

        echo "Usuario registrado con éxito. <a href='login.php'>Ir a Login</a>";
        exit;
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
</head>
<body>
  <h1>Registro de usuario</h1>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post" action="">
    <label>Nombre de usuario:</label><br>
    <input type="text" name="username"><br><br>
    
    <label>Contraseña:</label><br>
    <input type="password" name="password"><br><br>
    
    <button type="submit">Registrar</button>
  </form>
</body>
</html>
