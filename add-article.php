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
    <main id="main" class="main_index_in">
        <? include_once "./blocks/aside.php" ?>
        <section class="articles_main">
            <h1 class="title1">Добавление статьи</h1>
            <div class = "flex">
                <form class="form" action="add-article.php" method="POST" enctype="multipart/form-data" style="margin-top:0">
                    <input type="text" name="title" id="title" placeholder="Введите заголовок" class="input" required>
                    <input type="text" name="intro" id="intro" placeholder="Введите описание" class="input" required>
                    <textarea name="text" id="text" placeholder="Введите текст" class="input" required></textarea>
                    <div class="file-upload-wrapper">
                        <input type="file" id="filename" name="filename" class="input-file">
                        <label for="filename" class="label-file">Выбрать файл</label>
                        <span id="file-name" class="file-name">Файл не выбран</span>
                    </div>
                    <button class="add_button" type="submit" id="addBtn" name="publish">Опубликовать</button>
                </form>
            </div>
            <div class="error">
                <span id="errorSpan"></span>
            </div>
        </section>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $("#addBtn").click(function (e) {
            e.preventDefault(); // Предотвращаем стандартную отправку формы
            let formData = new FormData();
            formData.append("title", $('#title').val());
            formData.append("intro", $('#intro').val());
            formData.append("text", $('#text').val());
            formData.append("filename", $('#filename')[0].files[0]); // Получаем файл
            $.ajax({
                url: '/code/add-article.php',
                type: 'POST',
                data: formData,
                contentType: false, // Отключаем кодировку данных
                processData: false, // Отключаем обработку данных jQuery
                success: function (data) {
                    if (data == 'ready') {
                        $('#errorSpan').hide();
                        location.href = '/';
                    } else {
                        $('#errorSpan').show();
                        $('#errorSpan').text(data);
                    }
                }
            });
        });
        document.getElementById("filename").addEventListener("change", function() {
            let fileName = this.files[0] ? this.files[0].name : "Файл не выбран";
            document.getElementById("file-name").textContent = fileName;
        });
    </script>
    <? include_once "./blocks/footer.php" ?>
</body>
</html>