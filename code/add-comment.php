<?php
    require "connection.php";
    $author_id = $_COOKIE['log'];
    $text = $_POST['text'];
    $id = $_GET['id'];
    $connection -> query("INSERT INTO `comments` (`author_id`, `text`, `article_id`) VALUES ('$author_id', '$text', '$id')");
    header('location: /article.php?id='.$id);