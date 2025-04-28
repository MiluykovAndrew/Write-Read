<?php
require "connection.php"; // Подключение к БД

// Проверяем, пришли ли данные
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo "Ошибка: ID статьи не указан!";
    exit();
}

// Получение данных из формы
$article_id = intval($_POST['id']); // Приводим к числу для безопасности
$title = trim($_POST['title']);
$intro = trim($_POST['intro']);
$text = trim(($_POST['text']));
$author_id = $_COOKIE['log'];

// --- ВАЛИДАЦИЯ ДАННЫХ ---
if (strlen($title) < 3) {
    echo "Заголовок должен содержать не менее 3 символов!";
    exit();
}
if (strlen($intro) < 10) {
    echo "Интро должен содержать не менее 10 символов!";
    exit();
}
if (strlen($text) < 50) {
    echo "Текст должен содержать не менее 50 символов!";
    exit();
}

// --- ОБРАБОТКА ИЗОБРАЖЕНИЯ ---
$filename = "";
if (!empty($_FILES['filename']['name'])) {
    $file = $_FILES['filename'];
    $upload_dir = __DIR__ . "/image/";
    $filename = time() . "_" . basename($file["name"]); // Генерация уникального имени файла
    $file_path = $upload_dir . $filename;

    if (!move_uploaded_file($file["tmp_name"], $file_path)) {
        echo "Ошибка загрузки изображения!";
        exit();
    }

    // Если загружено новое изображение, обновляем и его
    $stmt = $connection->prepare("UPDATE articles SET title = ?, filename = ?, intro = ?, text = ?, editdate = NOW()  WHERE id = ? AND author_id = ?");
    $stmt->bind_param("ssssis", $title, $filename, $intro, $text, $article_id, $author_id);
} else {
    // Если изображение не загружено, обновляем только текстовые данные
    $stmt = $connection->prepare("UPDATE articles SET title = ?, intro = ?, text = ?, editdate = NOW()  WHERE id = ? AND author_id = ?");
    $stmt->bind_param("sssis", $title, $intro, $text, $article_id, $author_id);
}

if ($stmt->execute()) {
    echo "ready"; // Сообщение для AJAX, чтобы перенаправить на главную
} else {
    echo "Ошибка записи в БД: " . $stmt->error;
}

$stmt->close();
$connection->close();
?>
