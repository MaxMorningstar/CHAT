<?php
require_once 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "❌ Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "⚠️ Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Plataforma</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-container h2 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-custom {
            background: #ff4b2b;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background: #ff1e00;
        }
        .error-msg {
            color: #ff4b2b;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .fa {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2><i class="fas fa-user-lock"></i> Iniciar Sesión</h2>
    
    <?php if (isset($error)): ?>
        <p class="error-msg"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label text-white"><i class="fas fa-user"></i> Nombre de usuario:</label>
            <input type="text" name="username" class="form-control" placeholder="Ingresa tu usuario" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-white"><i class="fas fa-lock"></i> Contraseña:</label>
            <input type="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
        </div>

        <button type="submit" class="btn btn-custom"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
    </form>

    <p class="mt-3 text-white text-center">
        ¿No tienes cuenta? <a href="register.php" class="text-warning">Regístrate aquí</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
