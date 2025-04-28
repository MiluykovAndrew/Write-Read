<?php
    require "connection.php";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $error = '';
    if (strlen($name) < 1) 
        $error = "Имя не может быть пустым!";
    else if (strlen($email) < 5) 
        $error = "Почта должна содержать не менее 5 символов!";
    else if (strlen($password) < 8) 
        $error = "Пароль должен содержать не менее 8 символов!";
    else if (mysqli_num_rows($connection -> query("SELECT * FROM `users` WHERE `name` = '$name'")) != 0) 
        $error = "Пользователь с таким именем уже существует!";
    else if (mysqli_num_rows($connection -> query("SELECT * FROM `users` WHERE `email` = '$email'")) != 0) 
        $error = "Пользователь с такой почтой уже существует!";
    else if ($password != $password2) 
        $error = "Пароли не совпадают";

    if ($error) {
        echo $error;
        exit();
    }

    $password = md5($password);

    $connection -> query("INSERT INTO `users` (
        `name`, 
        `email`, 
        `password`) VALUES (
        '$name', 
        '$email', 
        '$password')");
        
    echo "Вы успешно зарегистрировались!";