<?php
    require "connection.php";

    $id = $_GET['id'];
    $author_id = $_COOKIE['log'];
    $article_id = $_GET['article_id'];

    $connection -> query("DELETE FROM `comments` WHERE `id` = '$id' AND `author_id` = '$author_id'");
    
    header('location: /article.php?id='.$article_id);