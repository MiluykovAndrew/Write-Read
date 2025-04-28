<?php
    require "connection.php";

    $title = trim($_POST['title']);
    $intro = trim($_POST['intro']);
    $text = trim(($_POST['text']));
    $author_id = $_COOKIE['log'];
    $error = '';

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

    $filename = '';
    if (!empty($_FILES['filename']['name'])) {
        $file = $_FILES['filename'];
        $upload_dir = __DIR__ . "/image/";
        $filename = time() . "_" . basename($file["name"]); // Генерация уникального имени файла
        $file_path = $upload_dir . $filename;

        if (!move_uploaded_file($file["tmp_name"], $file_path)) {
            echo "Ошибка загрузки изображения!";
            exit();
        }
    }

    $stmt = $connection->prepare("INSERT INTO articles (title, filename, intro, text, author_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $filename, $intro, $text, $author_id);

    if ($stmt->execute()) {
        echo "ready"; 
    } else {
        echo "Ошибка записи в БД: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
?>
