<?php
    require "connection.php";

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $query = $connection->query("SELECT * FROM `users` WHERE 
        `email` = '$email' AND 
        `password` = '$password'");
    $error = '';
    if (mysqli_num_rows($query) == 0) {
        $error = "Проверьте корректность введенных данных!";
    }
    
    if ($error) {
        echo $error;
        exit();
    } else {
        $user = mysqli_fetch_assoc($query);
        setcookie("log", $user['id'], time() + 3600, '/');
        echo "ready";
    }
?>
