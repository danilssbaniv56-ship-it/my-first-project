<?php
require_once 'config.php';
if (!isset($_SESSION['current_user']) || $_SESSION['current_user']['role'] !== 'user') {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['current_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_id = empty($_SESSION['requests']) ? 1001 : max(array_column($_SESSION['requests'], 'id')) + 1;
    $_SESSION['requests'][] = [
        'id' => $new_id,
        'user_login' => $user['login'],
        'fio' => $user['fio'],
        'phone' => $user['phone'],
        'email' => $user['email'],
        'course' => $_POST['course'],
        'date' => $_POST['date'],
        'payment' => ($_POST['payment'] === 'cash') ? 'Наличными' : 'Переводом по номеру телефона',
        'status' => 'Новая',
        'created_at' => date('d.m.Y')
    ];
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новая заявка | Корочки.есть</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header class="header">
        <div class="header-left">
            <div class="logo">
                <span class="logo-icon">🎓</span>
                <span class="logo-text">Корочки.есть</span>
            </div>
        </div>
        <nav class="header-nav">
            <a href="index.php" class="nav-link">Мои заявки</a>
            <a href="new-request.php" class="nav-link active">Новая заявка</a>
        </nav>
        <div class="header-right">
            <div class="user-profile">
                <span class="user-avatar"><?= getInitials($user['fio']) ?></span>
                <span class="user-name"><?= htmlspecialchars($user['fio']) ?></span>
            </div>
            <a href="logout.php" class="logout-btn" style="text-decoration:none;">🚪</a>
        </div>
    </header>
    <main class="container">
        <a href="index.php" class="back-link" style="margin-top:20px; display:inline-block;">&larr; Мои заявки</a>
        <section class="page-title-section" style="margin-top:20px;">
            <p class="section-badge">СЛЕДУЮЩИЙ ШАГ В ВАШЕМ РАЗВИТИИ</p>
            <h1>Новая заявка на обучение</h1>
            <p class="subtitle">Выберите курс и удобную дату начала. Остальное мы поможем организовать.</p>
        </section>
        <div class="form-layout">
            <form class="request-form" method="POST" action="new-request.php">
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>С чего начнем?</h2>
                        <span class="required-hint">Все поля обязательны</span>
                    </div>
                    <div class="form-group">
                        <label>Курс *</label>
                        <select name="course" style="width:100%; padding:14px; border-radius:8px; border:1px solid #ccc; font-size:15px; outline:none;">
                            <option value="Основы алгоритмизации и программирования">Основы алгоритмизации и программирования</option>
                            <option value="Основы веб-дизайна" selected>Основы веб-дизайна</option>
                            <option value="Основы проектирования баз данных">Основы проектирования баз данных</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start-date">Желаемая дата начала *</label>
                        <div class="date-input-wrapper">
                            <input type="text" id="start-date" name="date" value="02.11.2026" required style="width:100%; padding:14px; border-radius:8px; border:1px solid #ccc;">
                        </div>
                        <span class="field-hint-orange">Укажите дату в формате ДД.ММ.ГГГГ</span>
                    </div>
                    <div class="form-group">
                        <label>Способ оплаты *</label>
                        <select name="payment" style="width:100%; padding:14px; border-radius:8px; border:1px solid #ccc; font-size:15px; outline:none;">
                            <option value="transfer">Переводом по номеру телефона</option>
                            <option value="cash">Наличными</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <a href="index.php" class="btn-cancel" style="text-decoration:none;">Отмена</a>
                        <button type="submit" class="btn-submit-request" style="padding:14px 28px; background:#5d3ebe; color:#fff; border:none; border-radius:8px; cursor:pointer;">&rarr; Отправить</button>
                    </div>
                </div>
            </form>
            <aside class="info-sidebar">
                <div class="steps-card">
                    <div class="steps-icon-bg">⚡</div>
                    <h3>Вы выбираете цель. Мы помогаем начать.</h3>
                    <div class="step-item">
                        <span class="step-number">1</span>
                        <div class="step-content">
                            <h4>Отправьте заявку</h4>
                            <p>Заявка поступит администратору и получит статус «Новая».</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>