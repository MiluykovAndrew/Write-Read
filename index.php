
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
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
    <? if ($_COOKIE['log'] == ''): ?>
        <main id="main" class="main_index_out">
            <section class="articles">
                <h1  class="title1">Все статьи</h1>
                <?php
                    $query = $connection -> query("SELECT articles.*, articles.id AS article_id, users.name FROM articles JOIN users ON articles.author_id = users.id
                        ORDER BY articles.pubdate DESC");
                    if (mysqli_num_rows($query) == 0):
                ?>
                    <span class="no_posts">Статьи отсутствуют.</span>
                <?php
                    endif;
                    while ($res = mysqli_fetch_assoc($query)):
                ?>
                    <? include "./code/reactions.php" ?>  
                    <? include "./blocks/article.php" ?>  
                <?php
                    endwhile;
                ?>
            </section>
        </main>

    <? else: ?>
        <main id="main" class="main_index_in">
        <? include_once "./blocks/aside.php" ?>
            <section class="articles_main">
                <h1  class="title1">Все статьи</h1>
                <?php
                    $query = $connection -> query("SELECT articles.*, articles.id AS article_id, users.name FROM articles JOIN users ON articles.author_id = users.id
                    ORDER BY articles.pubdate DESC");
                if (mysqli_num_rows($query) == 0):
                ?>
                    <span class="no_posts">Статьи отсутствуют.</span>
                <?php
                    endif;
                    while ($res = mysqli_fetch_assoc($query)):
                ?>
                    <? include "./code/reactions.php" ?>  
                    <? include "./blocks/article.php" ?>  
                <?php
                    endwhile;
                ?>
            </section>
        </main>
    <? endif; ?>
    <script src="js/slogan.js"></script>
    <script src="js/index.js"></script>
    <? include_once "./blocks/footer.php" ?>
</body>
</html>