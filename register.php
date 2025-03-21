<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $hashedPassword = $password; // ⚠️ En un entorno real, usa password_hash($password, PASSWORD_DEFAULT)

        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword
        ]);

        echo "<div class='success-message'>🎉 Usuario registrado con éxito. <a href='login.php'>Ir a Login</a></div>";
        exit;
    } else {
        $error = "⚠️ Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
            backdrop-filter: blur(10px);
            color: white;
        }

        h1 {
            margin-bottom: 15px;
        }

        .input-group {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .input-group i {
            color: white;
            margin-right: 10px;
        }

        .input-group input {
            border: none;
            outline: none;
            background: transparent;
            color: white;
            width: 100%;
            font-size: 16px;
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .error-message, .success-message {
            background: rgba(255, 0, 0, 0.7);
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .success-message {
            background: rgba(0, 255, 0, 0.7);
        }

        button {
            background: #ff5a5f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background: #ff1e29;
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1><i class="fa-solid fa-user-plus"></i> Registro</h1>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" placeholder="Nombre de usuario">
            </div>
            
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Contraseña">
            </div>
            
            <button type="submit"><i class="fa-solid fa-check"></i> Registrar</button>
        </form>
    </div>

</body>
</html>
