<?php
    require "connection.php";

    $author_id = $_COOKIE['log'];
    $article_id = $_GET['article_id'];

    $connection -> query("DELETE FROM `reactions` WHERE `article_id` = '$article_id' AND `user_id` = '$author_id'");

    header('location: /article.php?id='.$article_id);