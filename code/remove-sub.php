<?php
    require "connection.php"; 

    $user_id = $_COOKIE['log'];
    $author_id = $_POST['author_id'];

    $connection -> query("DELETE FROM `subscriptions` WHERE `user_id` = '$user_id' AND `author_id` = '$author_id'");
    
    header("Location: /author.php?author_id=" . $author_id);