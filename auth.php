<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W&R</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <? include_once "./blocks/header.php" ?>
    <? include_once "./code/connection.php" ?>
    <? if ($_COOKIE['log'] != ''): ?><script>location.href = '/'</script><? endif; ?>
    <main class="main">
        <h1 class="title">Авторизация</h1>
        <div class="flex">
            <form class="form">
                <input type="email" name="email" id="email" placeholder="Почта" class="input">
                <input type="password" name="password" id="password" placeholder="Пароль" class="input">
                <button class="auth_button" type="button" id="authBtn">Войти</button>
                <h5>Впервые здесь? Тогда <a href="/reg.php" class="reg">зарегистрируйтесь</a>.</h5>
            </form>
        </div>
        <div class="error">
            <span id="errorSpan"></span>
        </div>
    </main>

    <?php
            $id = $_GET['id'];
            $query = $connection -> query("SELECT * FROM `articles` WHERE `id` = '$id'");
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $("#authBtn").click(function () {
            const email = $('#email').val() 
            const password = $('#password').val()

            $.ajax({
                url: '/code/auth.php',
                type: 'POST',
                cache: false,
                data: {
                    email, 
                    password},
                dataType: 'html',
                success: function (data) {
                    if (data == 'ready') {
                        $('#errorSpan').hide()
                        location.href = '/'
                    } else {
                        $('#errorSpan').show()
                        $('#errorSpan').text(data)
                    }
                }
            })
        })
    </script>
    <? include_once "./blocks/footer.php" ?>
</body>
</html>