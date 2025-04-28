<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W&R</title>
    <link rel="stylesheet" href="styles/style.css">
    <style> textarea { resize: vertical} </style>
</head>
<body>
    <? include_once "./blocks/header.php" ?>
    <? require "./code/connection.php" ?>
    <main class="main_index_in">
        <? include_once "./blocks/aside.php" ?>
        <section class="articles_main">
            <h1 class="title1">Редактирование статьи</h1>
            <?php
                $article_id = $_GET['id'];
                $author_id = $_COOKIE['log'];
                $query = $connection -> query("SELECT * FROM articles WHERE id = '$article_id' AND author_id = '$author_id'");
                if (mysqli_num_rows($query) == 0):
            ?><script>location.href = '/'</script><?php
                endif;
                while ($res = mysqli_fetch_assoc($query)):
            ?>
            <div class = "flex">
                <form class="form" style="margin-top:0">
                    <input type="text" name="title" id="title" placeholder="Введите заголовок" class="input" required value="<?=$res['title'];?>">
                    <input type="text" name="intro" id="intro" placeholder="Введите интро" class="input" required value="<?=$res['intro'];?>">
                    <textarea name="text" id="text" placeholder="Введите текст" class="input" required><?=$res['text'];?></textarea>
                    <div class="file-upload-wrapper">
                        <input type="file" id="filename" name="filename" class="input-file" required>
                        <label for="filename" class="label-file">Выбрать файл</label>
                        <span id="file-name"><?php echo htmlspecialchars($res['filename']); ?></span> <!-- Выводим имя файла из базы данных -->
                    </div>
                    <button class="add_button" type="button" id="editBtn">Сохранить</button>
                </form>
            </div>
            <?php
                endwhile;
            ?>
            <div class="error">
                <span id="errorSpan"></span>
            </div>
        </section>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $("#editBtn").click(function (e) {
            e.preventDefault(); // Предотвращаем стандартную отправку формы

            let formData = new FormData();
            formData.append("id", new URLSearchParams(window.location.search).get('id')); // Получаем id статьи из URL
            formData.append("title", $('#title').val());
            formData.append("intro", $('#intro').val());
            formData.append("text", $('#text').val());

            if ($('#filename')[0].files.length > 0) { // Проверяем, выбран ли файл
                formData.append("filename", $('#filename')[0].files[0]);
            }

            $.ajax({
                url: '/code/edit-article.php',
                type: 'POST',
                data: formData,
                contentType: false, // Отключаем кодировку данных
                processData: false, // Отключаем обработку данных jQuery
                success: function (data) {
                    if (data.trim() === 'ready') {
                        $('#errorSpan').hide();
                        location.href = '/';
                    } else {
                        $('#errorSpan').show();
                        $('#errorSpan').text(data);
                    }
                }
            });
        });

        function updateFileName() {
            var fileInput = document.getElementById('filename');
            var fileName = fileInput.files[0] ? fileInput.files[0].name : 'Нет файла';
            document.getElementById('file-name').textContent = fileName;
        }

        document.getElementById('filename').addEventListener('change', updateFileName);

    </script>
    <? include_once "./blocks/footer.php" ?>
</body>
</html>