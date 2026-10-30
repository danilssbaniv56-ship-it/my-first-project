<?php
require_once 'config.php';
if (!isset($_SESSION['current_user']) || $_SESSION['current_user']['role'] !== 'user') {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['current_user'];
$user_requests = array_filter($_SESSION['requests'], function($req) use ($user) {
    return $req['user_login'] === $user['login'];
});
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет | Корочки.есть</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <!-- Шапка сайта приведена в строгое соответствие с main.css -->
    <header class="header">
        <div class="header-left">
            <div class="logo">
                <span class="logo-icon">🎓</span>
                <span class="logo-text">Корочки.есть</span>
            </div>
        </div>
        <nav class="header-nav" style="display: flex; gap: 30px;">
            <a href="index.php" class="nav-link active">Мои заявки</a>
            <a href="new-request.php" class="nav-link">Новая заявка</a>
        </nav>
        <div class="header-right">
            <div class="user-profile">
                <span class="user-avatar"><?= getInitials($user['fio']) ?></span>
                <span class="user-name"><?= htmlspecialchars($user['fio']) ?></span>
            </div>
            <a href="logout.php" class="logout-btn" style="text-decoration: none; margin-left: 15px;">🚪</a>
        </div>
    </header>

    <main class="container">
        <section class="welcome-section">
            <div class="welcome-text">
                <p class="breadcrumbs">ЛИЧНЫЙ КАБИНЕТ / ЗАЯВКИ</p>
                <h1>Учиться. Развиваться. Достигать.</h1>
                <p class="subtitle">Здесь всё о вашем обучении.</p>
            </div>
            <!-- Добавлены явные стили кнопки для обеспечения кликабельности -->
            <a href="new-request.php" class="btn-primary" style="text-decoration: none; display: inline-block; text-align: center; line-height: 1.2;">+ Новая заявка</a>
        </section>

        <div class="main-layout">
            <div class="content-left">
                <div class="section-title-bar">
                    <h2>Ваши заявки — <?= count($user_requests) ?></h2>
                    <span class="sort-text">Сначала новые</span>
                </div>
                
                <?php if (empty($user_requests)): ?>
                    <p style="color: #666; margin-top: 20px;">У вас пока нет поданных заявок.</p>
                <?php else: ?>
                    <?php foreach ($user_requests as $req): ?>
                    <div class="card <?= $req['status'] === 'Новая' ? 'border-new' : ($req['status'] === 'Идет обучение' ? 'border-process' : 'border-done') ?>">
                        <div class="card-header">
                            <div class="card-title-block">
                                <span class="card-icon">🎓</span>
                                <div>
                                    <p class="card-meta">Заявка №<?= $req['id'] ?> • <?= $req['created_at'] ?></p>
                                    <h3 class="card-title"><?= htmlspecialchars($req['course']) ?></h3>
                                </div>
                            </div>
                            <span class="status-badge <?= $req['status'] === 'Новая' ? 'status-new' : ($req['status'] === 'Идет обучение' ? 'status-process' : 'status-done') ?>">
                                <?= htmlspecialchars($req['status']) ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="info-group" style="margin-right: 40px;">
                                <p class="info-label">Желаемая дата начала</p>
                                <p class="info-value"><?= htmlspecialchars($req['date']) ?></p>
                            </div>
                            <div class="info-group">
                                <p class="info-label">Способ оплаты</p>
                                <p class="info-value"><?= htmlspecialchars($req['payment']) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <p class="support-text">❓ Есть вопрос о статусе или дате начала? Напишите в поддержку: <a href="mailto:support@korochki.ru">support@korochki.ru</a></p>
            </div>

            <aside class="content-right">
                <div class="promo-banner">
                    <div class="promo-header">
                        <span class="promo-tag">ВДОХНОВЕНИЕ ДЛЯ РОСТА</span>
                    </div>
                    <div class="promo-image-placeholder"><span class="img-mock">👩‍💻 Изображение баннера</span></div>
                    <h3>Учитесь в своем ритме</h3>
                    <p>Новые навыки — ближе, чем кажется. Начните с небольшого шага и двигайтесь к своей цели.</p>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>