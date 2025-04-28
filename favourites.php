<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W&R</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <? include_once "./blocks/header.php" ?>
    <? include_once "./code/connection.php" ?>
    <main id="main" class="main_index_in">
    <? include_once "./blocks/aside.php" ?>
        <section class="articles_main">
            <h1  class="title1">Избранное</h1>
            <?php
                $user_id = $_COOKIE['log'];
                $query = $connection->query("SELECT articles.*, articles.id AS article_id, users.name FROM favourites 
                    JOIN articles ON favourites.article_id = articles.id 
                    JOIN users ON articles.author_id = users.id
                    WHERE `user_id` = '$user_id' ORDER BY `pubdate` DESC");                             
                if (mysqli_num_rows($query) == 0):
                    ?>
                        <span class="no_posts">Cтатьи отсутствуют.</span>
                    <?php
                endif;
                while ($res = mysqli_fetch_assoc($query)):
            ?>     
            <? include "./code/reactions.php" ?>  
            <? include "./blocks/article.php" ?>  
            <?php endwhile;?>
        </section>
    </main>
    <? include_once "./blocks/footer.php" ?>
</body>
</html>