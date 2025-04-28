<article onclick="location.href='/article.php?id=<?=$res['article_id'];?>'" class="article">
        <a href="/author.php?author_id=<?=$res['author_id'];?>" class="author"><?=$res['name'];?></a>
    <div style="display:flex; margin-top: 15px">
        <?php if (!empty($res['filename'])): ?>
            <img src="code/image/<?=$res['filename'];?>" alt="Изображение статьи" class="article-img">
        <?php endif; ?>
        <div style="width: 100%">
            <h3 ><?=$res['title'];?></h3>
            <hr>
            <p><?=$res['intro'];?></p>
        </div>
    </div>
    <em>Дата публикации: <?= date("d.m.Y H:i", strtotime($res['pubdate'])); ?></em><br>
    <?php if (!is_null($res['editdate'])): ?>
        <em>Дата редактирования: <?= date("d.m.Y H:i", strtotime($res['editdate'])); ?></em><br>
    <?php endif; ?>
    <em>Просмотры: <?=$res['views'];?></em><br>
    <div style="display: flex; justify-content: space-between;">
        <button onclick="location.href='/article.php?id=<?=$res['id'];?>'" class="btn">Читать</button>
        <div style="display: flex; margin-top: auto;">                                    
            <div>
                <button class="add_favourites_button">
                    <img src="img/like.png" class="img">
                </button>
            </div>
            <div class="like_count" style="margin-right: 1rem;">
                <?=$like_count;?>
            </div>

            <div>
                <button class="add_favourites_button">
                    <img src="img/dislike.png" class="img">
                </button>
            </div>
            <div class="like_count">
                <?=$dislike_count;?>
            </div>

        </div>
    </div>
</article>
