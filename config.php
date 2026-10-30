<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'annasm26' => [
            'password' => 'password123',
            'fio' => 'Смирнова Анна Сергеевна',
            'phone' => '8(916)123-45-67',
            'email' => 'anna.smirnova@mail.ru',
            'role' => 'user'
        ],
        'admin' => [
            'password' => 'admin123',
            'fio' => 'Главный Администратор',
            'phone' => '8(800)555-35-35',
            'email' => 'admin@korochki.ru',
            'role' => 'admin'
        ]
    ];
}

if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [
        [
            'id' => 1046,
            'user_login' => 'annasm26',
            'fio' => 'Смирнова Анна Сергеевна',
            'phone' => '8(916)123-45-67',
            'email' => 'anna.smirnova@mail.ru',
            'course' => 'Основы алгоритмизации и программирования',
            'date' => '02.11.2026',
            'payment' => 'Переводом по номеру телефона',
            'status' => 'Новая',
            'created_at' => '16.10.2026'
        ],
        [
            'id' => 1045,
            'user_login' => 'annasm26',
            'fio' => 'Смирнова Анна Сергеевна',
            'phone' => '8(916)123-45-67',
            'email' => 'anna.smirnova@mail.ru',
            'course' => 'Основы веб-дизайна',
            'date' => '05.10.2026',
            'payment' => 'Наличными',
            'status' => 'Идет обучение',
            'created_at' => '28.09.2026'
        ]
    ];
}

function getInitials($fullName) {
    $parts = explode(' ', $fullName);
    $initials = '';
    if (isset($parts[0])) $initials .= mb_substr($parts[0], 0, 1);
    if (isset($parts[1])) $initials .= mb_substr($parts[1], 0, 1);
    return mb_strtoupper($initials);
}
?>
