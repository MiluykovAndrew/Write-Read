<?php
    require "connection.php";

    $author_id = $_COOKIE['log'];
    $article_id = $_GET['id'];

    $connection -> query("DELETE FROM `articles` WHERE `id` = '$article_id' ");

    $connection -> query("DELETE FROM `comments` WHERE `article_id` = '$article_id'");

    $connection -> query("DELETE FROM `favourites` WHERE `article_id` = '$article_id'");

    $connection -> query("DELETE FROM `reactions` WHERE `article_id` = '$article_id'");

    header('location: /');