<?php
    // Вставляем код подключения к базе данных
    require "./code/connection.php";

    // Получаем ID статьи из URL
    $article_id = $_GET['id'];

    // Выполняем запрос на подсчет лайков для данной статьи
    $query = $connection->prepare("SELECT COUNT(*) AS like_count FROM `reactions` WHERE `article_id` = ? AND `like` = 1");
    $query->bind_param("i", $article_id);  // Привязываем параметр для защиты от SQL-инъекций
    $query->execute();

    // Получаем результат
    $result = $query->get_result();
    $row = $result->fetch_assoc();

    // Закрываем запрос
    $query->close();

    // Получаем количество лайков
    $like_count = isset($row['like_count']) ? $row['like_count'] : 0;  // если нет лайков, то показываем 0

    // Подсчет количества дизлайков
    $dislike_query = $connection->prepare("SELECT COUNT(*) AS dislike_count FROM `reactions` WHERE `article_id` = ? AND `dislike` = 1");
    $dislike_query->bind_param("i", $article_id);
    $dislike_query->execute();
    $dislike_result = $dislike_query->get_result();
    $dislike_row = $dislike_result->fetch_assoc();
    $dislike_query->close();
    $dislike_count = isset($dislike_row['dislike_count']) ? $dislike_row['dislike_count'] : 0;
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>W&R</title>
        <link rel="stylesheet" href="styles/style.css">
        <style> textarea { resize: vertical;} </style>
    </head>
    <body>
        <? include_once "./blocks/header.php" ?>
        <? include_once "./code/connection.php" ?>
        <? if ($_COOKIE['log'] == ''): ?>
            <main id="main" class="main_index_out">
                <section class="articles">
                    <?php
                        $id = intval($_GET['id']);       
                        $query = $connection -> query("SELECT articles.*, articles.id AS article_id, users.name FROM articles
                        JOIN users ON articles.author_id = users.id WHERE articles.id = '$id'");
                        $connection -> query("UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = '$id'");
                        if (mysqli_num_rows($query) == 0) echo "<span class='no_posts'>Не удалось найти статью.</span>";
                        while ($res = mysqli_fetch_assoc($query)):
                    ?>
                        <h1 class="title1">Страница статьи</h1>   
                        <article class="article_page">
                            <h3><?=$res['title'];?></h3>
                            <hr>
                            <p><?= nl2br(htmlspecialchars($res['text'])) ?></p>
                            <hr>  
                            <em>Дата публикации: <?= date("d.m.Y H:i", strtotime($res['pubdate'])); ?></em><br>
                            <?php if (!is_null($res['editdate'])): ?>
                                <em>Дата редактирования: <?= date("d.m.Y H:i", strtotime($res['editdate'])); ?></em><br>
                            <?php endif; ?>
                            <em>Автор: <a href="/author.php?author_id=<?=$res['author_id'];?>" class="author"><?=$res['name'];?></a></em><br>
                            <em>Просмотры: <?=$res['views'] + 1;?></em><br>
                            <? if ($_COOKIE['log'] == $res['author']): ?>
                            <? endif; ?>
                        </article>                       
                        <article style="margin-bottom: 2rem;">
                                Чтобы оставлять комментарии и добавлять в избранное, <a href="/authorization.php" class="enter">авторизуйтесь</a>.
                        </article>
                        <?php
                            $comment_id = $res['id'];
                            $comment_query = $connection -> query("SELECT comments.*, users.name as name FROM comments JOIN users ON comments.author_id = users.id WHERE article_id = '$comment_id' ORDER BY pubdate DESC");
                            while ($comment = mysqli_fetch_assoc($comment_query)):
                        ?>
                        <article class="comment_page">
                            <a href="/author.php?author_id=<?=$comment['author_id'];?>" class="author"><?=$comment['name'];?></a>
                            <p><?=$comment['text'];?></p>
                            <div style="display: flex; justify-content: space-between;">
                                <em>Дата публикации: <?=$comment['pubdate'];?></em>
                                <? if ($_COOKIE['log'] == $comment['author_id']): ?>
                                    <button onclick="location.href='/code/remove-comment.php?id=<?=$comment['id'];?>&article_id=<?=$res['id'];?>'" class="delete">Удалить</button>
                                <? endif; ?>
                            </div>
                        </article>
                        <?php endwhile;?>                      
                    <?php endwhile;?>
                </section>
            </main>
        <? else: ?>         
            <main id="main" class="main_index_in">
                <? include_once "./blocks/aside.php" ?>
                <section class="articles_main">
                    <?php
                        $id = intval($_GET['id']);                
                        $query = $connection -> query("SELECT articles.*, articles.id AS article_id, users.name FROM articles
                        JOIN users ON articles.author_id = users.id WHERE articles.id = '$id'");
                        $connection -> query("UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = '$id'");
                        if (!$query) {
                            die("Ошибка в запросе: " . $connection->error);
                        }
                        while ($res = mysqli_fetch_assoc($query)):
                    ?>
                    <h1 class="title1">Страница статьи</h1>   
                    <article class="article_page">
                        <h3><?=$res['title'];?></h3>
                        <hr>
                        <p><?= nl2br(htmlspecialchars($res['text'])) ?></p>
                        <hr>  
                        <div style="display: flex; justify-content: space-between;" >    
                            <div>
                                <em>Дата публикации: <?= date("d.m.Y H:i", strtotime($res['pubdate'])); ?></em><br>
                                <?php if (!is_null($res['editdate'])): ?>
                                    <em>Дата редактирования: <?= date("d.m.Y H:i", strtotime($res['editdate'])); ?></em><br>
                                <?php endif; ?>
                                <em>Автор: <a href="/author.php?author_id=<?=$res['author_id'];?>" class="author"><?=$res['name'];?></a></em><br>
                                <em>Просмотры: <?=$res['views'] + 1;?></em><br>
                                <?
                                    $user_id = $_COOKIE['log'];
                                    $id = $_GET['id'];
                                    if (mysqli_num_rows($connection -> query("SELECT * FROM `favourites` WHERE `user_id` = '$user_id' and `article_id` = '$id'"  )) != 0):
                                ?>        
                                    <form method="POST" action="/code/remove-favourite.php?id=&article_id=<?=$res['article_id'];?>">
                                        <button class="remove_favourites_button">
                                            <img src="img/heart.png" class="img">Удалить из избранного
                                        </button>
                                    </form>
                                <? else: ?>       
                                    <form method="POST" action="/code/add-favourite.php?id=<?=$res['article_id'];?>">
                                        <button class="add_favourites_button">
                                            <img src="img/no_heart.png" class="img">Добавить в избранное
                                        </button>
                                    </form>
                                <? endif; ?>
                                <div style="display: flex;">
                                    <div>
                                        <?php
                                            if (mysqli_num_rows($connection->query("SELECT * FROM `reactions` WHERE `user_id` = '$user_id' 
                                            and `article_id` = '$id' and `like` = 1")) != 0):
                                        ?>
                                        <form method="POST" action="/code/remove-reaction.php?id=&article_id=<?=$res['article_id'];?>" >
                                            <button class="add_favourites_button">
                                                <img src="img/like-copy.png" class="img">
                                            </button>
                                        </form>
                                        <?php else: ?>
                                            <form method="POST" action="/code/add-like.php?id=<?=$res['article_id'];?>" >
                                                <button class="add_favourites_button">
                                                    <img src="img/like.png" class="img">
                                                </button>
                                            </form>
                                        <?php endif; ?>                    
                                    </div>
                                        <div class="like_count" style="margin-right: 1rem;">
                                            <?=$like_count;?>
                                        </div>
                                    <div>
                                        <?php
                                            if (mysqli_num_rows($connection->query("SELECT * FROM `reactions` WHERE `user_id` = '$user_id' 
                                            and `article_id` = '$id' and `dislike` = 1")) != 0):
                                        ?>
                                        <form method="POST" action="/code/remove-reaction.php?id=&article_id=<?=$res['article_id'];?>" class="favourites">
                                            <button class="add_favourites_button">
                                                <img src="img/dislike-copy.png" class="img">
                                            </button>
                                        </form>
                                        <?php else: ?>
                                            <form method="POST" action="/code/add-dislike.php?id=<?=$res['article_id'];?>" class="favourites">
                                                <button class="add_favourites_button">
                                                    <img src="img/dislike.png" class="img">
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    <div class="like_count" >
                                        <?=$dislike_count;?> 
                                    </div>
                                </div>
                            </div>                
                            <div style="display: flex;flex-direction: column;align-items: flex-end; justify-content: flex-end;">
                                <? if ($_COOKIE['log'] == $res['author_id']): ?>
                                    <button class="remove_button" onclick="location.href='/code/remove-article.php?id=<?=$res['id'];?>'"  >
                                        <img src="img/remove.png" class="img">Удалить
                                    </button>
                                    <button class="edit_button" onclick="location.href='/edit-article.php?id=<?=$res['id'];?>'" >
                                        <img src="img/edit.png" class="img">Редактировать 
                                    </button>
                                <? endif; ?>  
                            </div>
                        </div>
                    </article>        
                        <h4>Есть чем поделиться с читателями? Тогда оставьте комментарий!</h4>
                        <form method="POST" action="/code/add-comment.php?id=<?=$res['id'];?>" class="comment">
                            <div style="display: flex;">
                                <textarea type="text" class="input" name="text" placeholder="Введите текст комментария"></textarea>
                                <button class="comment_button">Оставить комментарий</button>
                            </div>
                        </form>        
                        <?php
                            $comment_id = $res['id'];
                            $comment_query = $connection -> query("SELECT comments.*, users.name as name FROM comments JOIN users ON comments.author_id = users.id WHERE article_id = '$comment_id' ORDER BY pubdate DESC");
                            while ($comment = mysqli_fetch_assoc($comment_query)):
                        ?>
                            <article class="comment_page">
                                <a href="/author.php?author_id=<?=$comment['author_id'];?>" class="author"><?=$comment['name'];?></a>
                                <p><?=$comment['text'];?></p>
                                <div style="display: flex; justify-content: space-between;">
                                    <em>Дата публикации: <?=$comment['pubdate'];?></em>
                                    <? if ($_COOKIE['log'] == $comment['author_id']): ?>
                                        <button onclick="location.href='/code/remove-comment.php?id=<?=$comment['id'];?>&article_id=<?=$res['id'];?>'" class="delete">Удалить</button>
                                    <? endif; ?>
                                </div>
                            </article>
                        <?php endwhile;?>
                    <?php endwhile;?>
                </section>
            </main>
        <? endif; ?>
        <? include_once "./blocks/footer.php" ?>
    </body>
</html>