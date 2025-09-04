<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .error { color: red; padding: 10px; margin: 10px 0; }
        .success { color: green; padding: 10px; margin: 10px 0; }
        .link { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Connexion</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Mot de passe:</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Se connecter</button>
    </form>

    <div class="link">
        <a href="/register">Pas de compte ? S'inscrire</a>
    </div>
</body>
</html>