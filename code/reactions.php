<?php
    $article_id = $res['id'];

    $like_query = $connection->prepare("SELECT COUNT(*) AS like_count FROM `reactions` WHERE `article_id` = ? AND `like` = 1");
    $like_query->bind_param("i", $article_id);
    $like_query->execute();
    $like_result = $like_query->get_result();
    $like_row = $like_result->fetch_assoc();
    $like_query->close();
    $like_count = $like_row['like_count'] ?? 0;
    
    $dislike_query = $connection->prepare("SELECT COUNT(*) AS dislike_count FROM `reactions` WHERE `article_id` = ? AND `dislike` = 1");
    $dislike_query->bind_param("i", $article_id);
    $dislike_query->execute();
    $dislike_result = $dislike_query->get_result();
    $dislike_row = $dislike_result->fetch_assoc();
    $dislike_query->close();
    $dislike_count = $dislike_row['dislike_count'] ?? 0;
?>