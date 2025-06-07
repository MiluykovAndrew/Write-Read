<?php
    require "connection.php";

    $title = trim($_POST['title']);
    $intro = trim($_POST['intro']);
    $text = trim($_POST['text']);
    $author_id = $_COOKIE['log'] ?? null;
    $error = '';

    if (mb_strlen($title) < 3) {
        echo "Заголовок должен содержать не менее 3 символов!";
        exit();
    }
    if (mb_strlen($intro) < 10) {
        echo "Интро должно содержать не менее 10 символов!";
        exit();
    }
    if (mb_strlen($text) < 50) {
        echo "Текст должен содержать не менее 50 символов!";
        exit();
    }

    $filename = '';
    if (!empty($_FILES['filename']['name'])) {
        $file = $_FILES['filename'];
        $upload_dir = __DIR__ . "/image/";
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array(strtolower($extension), $allowed_extensions)) {
            echo "Допустимы только изображения (jpg, png, gif, webp)";
            exit();
        }

        $filename = time() . "_" . bin2hex(random_bytes(5)) . "." . $extension;
        $file_path = $upload_dir . $filename;

        if (!move_uploaded_file($file["tmp_name"], $file_path)) {
            echo "Ошибка загрузки изображения!";
            exit();
        }
    }

    $stmt = $connection->prepare("INSERT INTO articles (title, filename, intro, text, author_id) 
        VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $filename, $intro, $text, $author_id);

    if ($stmt->execute()) {
        echo "ready";
    } else {
        echo "Ошибка записи в БД: " . $stmt->error;
    }