<aside class="aside">
    <a class="link_author" href="/">
        <img src="img/main.png" class="img">Главная
    </a>
    <a class="link_author" href="/author.php?author_id=<?=$_COOKIE['log'];?>">
        <img src="img/articles.png" class="img">Мои статьи
    </a>
    <a class="link_author" href="subs.php">
        <img src="img/subs.png" class="img">Подписки
    </a>
    <a class="link_author" href="/favourites.php" >
        <img src="img/heart.png" class="img">Избранное
    </a>
    <a class="link_author" href="/trends.php" style="margin-bottom:0">
        <img src="img/trends.png" class="img">В тренде
    </a>
    <hr>
    <h4 style="margin: 0.5rem 0 0.5rem  0 ">Подписки</h4>
    <?php
        $user_id = $_COOKIE['log'];
        $query = $connection->query("    
            SELECT users.name, users.id AS author_id 
            FROM subscriptions 
            JOIN users ON subscriptions.author_id = users.id 
            WHERE subscriptions.user_id = '$user_id' 
            GROUP BY subscriptions.author_id
        ");
        if (!$query) {
            // Если запрос не удался, выводим ошибку
            echo "<span class='error'>Ошибка выполнения запроса: " . mysqli_error($connection) . "</span>";
        } elseif (mysqli_num_rows($query) == 0) {
            // Если нет подписок
            echo "<span class='no_posts'>Подписки отсутствуют.</span>";
        } else {
            // Если подписки есть
            while ($res = mysqli_fetch_assoc($query)) {   
                echo '<div style="padding-bottom: 0.5rem">
                    <a href="/author.php?author_id=' . ($res['author_id']) . '" class="author">' . htmlspecialchars($res['name']) . '</a>
                </div>';
            }
        }
    ?>
</aside>
