<?php
    require "connection.php";

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $error = '';

    if (strlen($name) < 1) {
        $error = "Имя не может быть пустым!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Некорректный формат email!";
    } elseif (strlen($password) < 8) {
        $error = "Пароль должен содержать не менее 8 символов!";
    } elseif ($password !== $password2) {
        $error = "Пароли не совпадают!";
    } else {
        $stmt = $connection->prepare("SELECT id FROM users WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Пользователь c таким именем уже существует!";
        }
        $stmt->close();

        if (!$error) {
            $stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $error = "Пользователь c такой почтой уже существует!";
            }
            $stmt->close();
        }
    }

    if ($error) {
        echo $error;
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $connection->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    $stmt->execute();
    $stmt->close();

    echo "Вы успешно зарегистрировались!";
