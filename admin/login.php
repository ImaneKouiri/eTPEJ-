<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $users = array_map('str_getcsv', file('data/users.csv'));
    foreach ($users as $user) {
        if ($user[0] === $username && $user[1] === $password) {
            $_SESSION['admin'] = true;
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Nom d'utilisateur ou mot de passe incorrect.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Administrateur</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffe8c8;
            padding: 40px;
            border-radius: 30px;
            text-align: center;
            width: 400px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        .login-container img {
            width: 200px;
            margin-bottom: 10px;
        }

        h2 {
            color: #ec6f28;
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 10px;
            margin-bottom: 25px;
            border: none;
            border-bottom: 3px solid #ec6f28;
            background-color: transparent;
            font-size: 18px;
            outline: none;
            color: #444;
        }

        .login-btn {
            background-color: #ec6f28;
            color: white;
            padding: 15px 30px;
            font-size: 20px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #d75f1e;
        }

        .error-message {
            color: red;
            font-size: 16px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="/admin/assets/logo.png" alt="Logo TGR">
        <h2>Connexion Administrateur</h2>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <br>
            <button type="submit" class="login-btn">Connexion</button>
        </form>
    </div>
</body>
</html>