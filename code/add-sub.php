<?php
    require "connection.php";

    $user_id = $_COOKIE['log'];
    $author_id = $_POST['author_id'];

    $connection -> query("INSERT INTO `subscriptions` (`user_id`, `author_id`) VALUES ('$user_id', '$author_id')");

    header("Location: /author.php?author_id=" .$author_id);






