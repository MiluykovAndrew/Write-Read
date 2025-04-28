<?php
    require "connection.php";

    $user_id = $_COOKIE['log'];
    $article_id = $_GET['id'];

    $connection -> query("INSERT INTO `favourites` (`user_id`, `article_id`) VALUES ('$user_id', '$article_id')"); 
    
    header('location: /article.php?id='.$article_id);