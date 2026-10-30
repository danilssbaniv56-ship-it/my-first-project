<?php
require_once 'config.php';
if (!isset($_SESSION['current_user']) || $_SESSION['current_user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$updated_id = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    $req_id = (int)$_POST['request_id'];
    $target_status = $_POST['status-change'];
    foreach ($_SESSION['requests'] as &$request) {
        if ($request['id'] === $req_id) {
            $request['status'] = $target_status;
            $updated_id = $req_id;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора | Корочки.есть</title>
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
        <nav class="header-nav" style="display: flex; gap: 30px;">
            <a href="admin.php" class="nav-link active">Управление обучением</a>
        </nav>
        <div class="header-right">
            <div class="user-profile">
                <span class="user-avatar">АД</span>
                <span class="user-name">Администратор</span>
            </div>
            <a href="logout.php" class="logout-btn" style="text-decoration: none; margin-left: 15px;">🚪</a>
        </div>
    </header>

    <main class="container container-admin" style="margin-top:30px;">
        <section class="admin-title-section">
            <p class="breadcrumbs">АДМИНИСТРИРОВАНИЕ / ЗАЯВКИ</p>
            <h1>Обучение начинается здесь</h1>
            <p class="subtitle">Все заявки, контакты слушателей и статусы обучения — в одном месте.</p>
        </section>

        <?php if ($updated_id): ?>
            <div class="alert-success">
                <span class="alert-text">✨ Статус заявки №<?= $updated_id ?> успешно обновлен!</span>
            </div>
        <?php endif; ?>

        <section class="table-container" style="margin-top:20px;">
            <table class="admin-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>Слушатель и контакты</th>
                        <th>Курс / Заявка</th>
                        <th>Дата начала</th>
                        <th>Статус</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['requests'] as $req): ?>
                    <tr>
                        <td>
                            <p class="user-fio"><?= htmlspecialchars($req['fio']) ?></p>
                            <p class="user-phone"><?= htmlspecialchars($req['phone']) ?></p>
                            <p class="user-email"><?= htmlspecialchars($req['email']) ?></p>
                        </td>
                        <td>
                            <p class="request-id">№<?= $req['id'] ?></p>
                            <p class="course-name"><?= htmlspecialchars($req['course']) ?></p>
                        </td>
                        <td><?= htmlspecialchars($req['date']) ?></td>
                        <td>
                            <span class="status-dot <?= $req['status'] === 'Новая' ? 'dot-new' : ($req['status'] === 'Идет обучение' ? 'dot-process' : 'dot-done') ?>"></span>
                            <?= htmlspecialchars($req['status']) ?>
                        </td>
                        <td>
                            <form method="POST" action="admin.php" style="display: flex; gap: 8px; align-items: center;">
                                <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                                <select name="status-change" style="padding: 8px; border-radius: 6px; border: 1px solid #ccc; background: #fff; font-size: 13px; outline: none;">
                                    <option value="Новая" <?= $req['status'] === 'Новая' ? 'selected' : '' ?>>Новая</option>
                                    <option value="Идет обучение" <?= $req['status'] === 'Идет обучение' ? 'selected' : '' ?>>Идет обучение</option>
                                    <option value="Обучение завершено" <?= $req['status'] === 'Обучение завершено' ? 'selected' : '' ?>>Обучение завершено</option>
                                </select>
                                <button type="submit" class="btn-save-status" style="padding: 8px 16px; background: #5d3ebe; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;">ОК</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>

