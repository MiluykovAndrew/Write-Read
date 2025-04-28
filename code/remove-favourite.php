<?php
    require "connection.php";

    $user_id = $_COOKIE['log'];
    $article_id = $_GET['article_id'];

    $connection -> query("DELETE FROM `favourites` WHERE `article_id` = '$article_id' AND `user_id` = '$user_id'");
    
    header('location: /article.php?id='.$article_id);
