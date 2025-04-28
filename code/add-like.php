<?php
    require "connection.php";

    $user_id = $_COOKIE['log'];
    $aricle_id = $_GET['id'];

    if (mysqli_num_rows($connection->query("SELECT * FROM `reactions` WHERE `user_id` = '$user_id' and `article_id` = '$aricle_id'")) != 0) {
        $connection->query("UPDATE `reactions`
            SET `like` = 1, `dislike` = 0
            WHERE `user_id` = '$user_id' AND `article_id` = '$aricle_id'");
    } else {
        $connection->query("INSERT INTO `reactions` (`user_id`, `article_id`, `like`, `dislike`) VALUES ('$user_id', '$aricle_id', 1, 0)");
    }

    header('location: /article.php?id=' . $aricle_id);
    exit();
?>
