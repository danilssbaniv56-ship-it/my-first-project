<?php
require_once 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (isset($_SESSION['users'][$login])) {
        $error = 'Пользователь с таким логином уже существует.';
    } else {
        $_SESSION['users'][$login] = [
            'password' => $password,
            'fio' => $fullname,
            'phone' => $phone,
            'email' => $email,
            'role' => 'user'
        ];
        $_SESSION['current_user'] = $_SESSION['users'][$login];
        $_SESSION['current_user']['login'] = $login;
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация | Корочки.есть</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header class="header header-auth">
        <div class="logo"><span class="logo-text">Корочки.есть</span></div>
    </header>
    <main class="container container-auth">
        <div class="auth-layout">
            <section class="form-container">
                <h2>Давайте знакомиться</h2>
                <?php if ($error): ?>
                <div class="alert-error-box"><div class="alert-content"><p class="alert-desc"><?= htmlspecialchars($error) ?></p></div></div>
                <?php endif; ?>
                <form method="POST" action="register.php">
                    <div class="form-group"><label>Логин *</label><input type="text" name="login" required></div>
                    <div class="form-group"><label>Пароль *</label><input type="password" name="password" required></div>
                    <div class="form-group"><label>ФИО *</label><input type="text" name="fullname" required></div>
                    <div class="form-row">
                        <div class="form-group"><label>Телефон *</label><input type="tel" name="phone" required></div>
                        <div class="form-group"><label>Email *</label><input type="email" name="email" required></div>
                    </div>
                    <button type="submit" class="btn-submit">Зарегистрироваться</button>
                    <div class="login-redirect">Уже есть аккаунт? <a href="login.php">Войти →</a></div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
