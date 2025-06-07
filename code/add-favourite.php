<?php
require "connection.php";

// Проверка наличия ID пользователя в cookie и ID статьи в GET-запросе
if (!isset($_COOKIE['log']) || !isset($_GET['id'])) {
    die("Ошибка: отсутствуют необходимые параметры.");
}

$user_id = (int)$_COOKIE['log'];  // Преобразуем в integer для безопасности
$article_id = (int)$_GET['id'];  // Преобразуем в integer для безопасности

$stmt = $connection->prepare("INSERT INTO favourites (user_id, article_id) VALUES (?, ?)");

$stmt->bind_param("ii", $user_id, $article_id); 

if ($stmt->execute()) {
    // Если добавление успешно, перенаправляем пользователя на страницу статьи
    header('Location: /article.php?id=' . $article_id);
    exit();  // Завершаем выполнение скрипта после редиректа
} else {
    // Если произошла ошибка при выполнении запроса
    echo "Ошибка при добавлении в избранное: " . $stmt->error;
}

// Закрытие подготовленного запроса
$stmt->close();
?>
