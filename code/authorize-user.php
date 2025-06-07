<?php
require "connection.php";

$email = trim($_POST['email']);
$password = $_POST['password'];
$error = '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Некорректный email!";
} elseif (strlen($password) < 8) {
    $error = "Пароль должен быть не менее 8 символов!";
}

if ($error) {
    echo $error;
    exit();
}

$stmt = $connection->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Проверьте корректность введённых данных!";
    exit();
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    echo "Неверный пароль!";
    exit();
}

setcookie("log", $user['id'], time() + 3600, '/');
echo "ready";