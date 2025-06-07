<?php
    require "connection.php";

    $author_id = (int)$_COOKIE['log'];
    $text = trim($_POST['text']);
    $article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $error = '';

    if (mb_strlen($text) < 3) {
        echo "Комментарий должен содержать хотя бы 3 символа!";
        exit();
    }

    $stmt = $connection->prepare("INSERT INTO comments (author_id, text, article_id) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $author_id, $text, $article_id);

    if ($stmt->execute()) {
        header("Location: /article.php?id=" . $article_id);
        exit();
    } else {
        echo "Ошибка при добавлении комментария: " . $stmt->error;
    } 
