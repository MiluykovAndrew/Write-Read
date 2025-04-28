<?php
    require "connection.php";

    $name = $_COOKIE['log'];
    $article_id = $_GET['article_id'];

    $connection -> query("DELETE FROM `reactions` WHERE `article_id` = '$article_id' AND `user` = '$name'");

    header('location: /article.php?id='.$article_id);