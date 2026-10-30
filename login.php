<?php
require_once 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if (isset($_SESSION['users'][$login]) && $_SESSION['users'][$login]['password'] === $password) {
        $_SESSION['current_user'] = $_SESSION['users'][$login];
        $_SESSION['current_user']['login'] = $login;
        header('Location: ' . ($_SESSION['current_user']['role'] === 'admin' ? 'admin.php' : 'index.php'));
        exit;
    } else {
        $error = 'Неверный логин или пароль. Проверьте данные и раскладку клавиатуры, затем попробуйте еще раз.';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход | Корочки.есть</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header class="header header-auth">
        <div class="logo">
            <span class="logo-icon">🎓</span>
            <span class="logo-text">Корочки.есть</span>
        </div>
        <div class="header-tagline">Дополнительное профессиональное образование</div>
    </header>
    <main class="container container-auth">
        <div class="auth-layout">
            <section class="promo-sidebar">
                <div class="promo-top">
                    <p class="promo-badge">• ЗНАНИЯ, КОТОРЫЕ МЕНЯЮТ</p>
                    <h1>Ваш следующий шаг — к новым возможностям.</h1>
                    <p class="promo-desc">Онлайн-курсы для профессионального роста.</p>
                </div>
                <div class="promo-image-container"><div class="promo-image-mock">💻 Рабочее пространство</div></div>
            </section>
            <section class="form-container">
                <p class="section-label">РАДЫ ВАС ВИДЕТЬ</p>
                <h2>С возвращением</h2>
                <?php if ($error): ?>
                <div class="alert-error-box">
                    <div class="alert-icon">⚠️</div>
                    <div class="alert-content"><p class="alert-desc"><?= htmlspecialchars($error) ?></p></div>
                </div>
                <?php endif; ?>
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label>Логин</label>
                        <input type="text" name="login" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" name="password" required>
                    </div>
                    <button type="submit" class="btn-submit">Войти</button>
                    <div class="register-redirect">Еще не зарегистрированы? <a href="register.php">Регистрация</a></div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
