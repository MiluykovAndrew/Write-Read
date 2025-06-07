<?php
require "connection.php";

$article_id = intval($_POST['id']);
$title = trim($_POST['title']);
$intro = trim($_POST['intro']);
$text = trim(($_POST['text']));
$author_id = $_COOKIE['log'];

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

$filename = "";
if (!empty($_FILES['filename']['name'])) {
    $file = $_FILES['filename'];
    $upload_dir = __DIR__ . "/image/";
    $filename = time() . "_" . basename($file["name"]);
    $file_path = $upload_dir . $filename;
    if (!move_uploaded_file($file["tmp_name"], $file_path)) {
        echo "Ошибка загрузки изображения!";
        exit();
    }
    $stmt = $connection->prepare("UPDATE articles SET title = ?, filename = ?, intro = ?, text = ?, editdate = NOW()  WHERE id = ? AND author_id = ?");
    $stmt->bind_param("ssssis", $title, $filename, $intro, $text, $article_id, $author_id);
} else {
    $stmt = $connection->prepare("UPDATE articles SET title = ?, intro = ?, text = ?, editdate = NOW()  WHERE id = ? AND author_id = ?");
    $stmt->bind_param("sssis", $title, $intro, $text, $article_id, $author_id);
}

if ($stmt->execute()) {
    echo "ready";
} else {
    echo "Ошибка записи в БД: " . $stmt->error;
}

$stmt->close();
$connection->close();
?>
