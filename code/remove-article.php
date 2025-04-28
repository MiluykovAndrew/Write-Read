<?php
    require "connection.php";

    $author_id = $_COOKIE['log'];
    $article_id = $_GET['id'];

    $connection -> query("DELETE FROM `articles` WHERE `id` = '$article_id' AND `author_id` = ' $author_id'");

    $connection -> query("DELETE FROM `comments` WHERE `article_id` = '$article_id' AND `author_id` = '$author_id'");

    $connection -> query("DELETE FROM `favourites` WHERE `article_id` = '$article_id' AND `user_id` = '$author_id'");

    header('location: /');