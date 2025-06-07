<?php
require "code/connection.php";
$user_id=$_COOKIE['log'];

    $query = $connection->query("SELECT `name` FROM `users` WHERE `id` = '$user_id'");
    if ($query && mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);
        $name = $user['name'];
    }
?>
<header class="header">
    <div class="logo">
        <a class="WR" href="/">Write&Read</a>
    </div>
    <form class="form_search" action="/search.php" method="GET">
        <input type="text" name="text" placeholder="Введите запрос..." class="search">
        <button class="search_button">Поиск</button>
    </form>
    <nav class="nav">
        <?php if (empty($_COOKIE['log'])): ?>
            <a class="link" href="/">Главная</a>
            <a class="link" href="/registration.php">Регистрация</a>
            <a class="link" href="/authorization.php">Вход</a>
        <?php else: ?>
            <a class="write" href="/add-article.php">Писать</a>
            <a href="/author.php?author_id=<?=$user_id;?>" style="margin: 0 0.5rem;" class="author">
                <?=$name;?>
            </a>
            <a class="link" href="/code/exit.php">Выход</a>
        <?php endif; ?>
    </nav>
</header>
<script src="js/header.js"></script>
