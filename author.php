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
    <?
    $author_id = intval($_GET['author_id']);

    $query = $connection->query("
        SELECT articles.*, articles.id AS article_id, users.name
        FROM users
        LEFT JOIN articles ON articles.author_id = users.id
        WHERE users.id = '$author_id'
        ORDER BY pubdate DESC
    ");
    
    // Сохраняем первую строку, чтобы взять имя
    $first_row = mysqli_fetch_assoc($query);
    $author_name = htmlspecialchars($first_row['name']);
    ?>
    
    <?php if ($_COOKIE['log'] == ''): ?>
        <main id="main" class="main_index_out">
            <section class="articles">
                <h1 class="title1">Статьи пользователя "<?= $author_name ?>"</h1>
    
                <?php if ($first_row['article_id'] === null): ?>
                    <span class="no_posts">Статьи отсутствуют.</span>
                <?php else: ?>
                    <?php
                        // Делаем новый запрос, чтобы начать цикл с начала
                        $query = $connection->query("
                            SELECT articles.*, articles.id AS article_id, users.name
                            FROM users
                            LEFT JOIN articles ON articles.author_id = users.id
                            WHERE users.id = '$author_id'
                            ORDER BY pubdate DESC
                        ");
    
                        while ($res = mysqli_fetch_assoc($query)):
                            include "./code/reactions.php";
                            include "./blocks/article.php";
                        endwhile;
                    ?>
                <?php endif; ?>
            </section>
        </main>
    
    <?php else: ?>
        <main id="main" class="main_index_in">
            <?php include_once "./blocks/aside.php"; ?>  
            <section class="articles_main">
                <div class="title1" style="display: flex; justify-content: center; align-items: center;">
                    <h1 style="font-size: 2rem;">Статьи пользователя "<?= $author_name ?>"</h1>
    
                    <?php
                        $user_id = $_COOKIE['log'];
                        $sub_query = $connection->query("
                            SELECT * FROM `subscriptions` 
                            WHERE `user_id` = '$user_id' AND `author_id` = '$author_id'
                        ");
    
                        if ($user_id != $author_id):
                            if (mysqli_num_rows($sub_query) != 0):
                    ?>   
                                <form method="POST" action="/code/remove-sub.php" style="display: flex; align-items: center; margin-left: 1rem">
                                    <input type="hidden" name="author_id" value="<?= $_GET['author_id'] ?>">
                                    <button class="btn_unsub">Отписаться</button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="/code/add-sub.php" style="display: flex; align-items: center; margin-left: 1rem">
                                    <input type="hidden" name="author_id" value="<?= $_GET['author_id'] ?>">
                                    <button class="btn_sub">Подписаться</button>
                                </form>
                            <?php endif; ?>
                    <?php endif; ?>
                </div>
    
                <?php if ($first_row['article_id'] === null): ?>
                    <span class="no_posts">Статьи отсутствуют.</span>
                <?php else: ?>
                    <?php
                        // Снова делаем запрос, чтобы не пропустить первую статью
                        $query = $connection->query("
                            SELECT articles.*, articles.id AS article_id, users.name
                            FROM users
                            LEFT JOIN articles ON articles.author_id = users.id
                            WHERE users.id = '$author_id'
                            ORDER BY pubdate DESC
                        ");
    
                        while ($res = mysqli_fetch_assoc($query)):
                            include "./code/reactions.php";
                            include "./blocks/article.php";
                        endwhile;
                    ?>
                <?php endif; ?>
            </section>
        </main>
    <?php endif; ?>
    
    <?php include_once "./blocks/footer.php"; ?>
</body>
</html>