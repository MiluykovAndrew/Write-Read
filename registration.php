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
    <? if ($_COOKIE['log'] != ''): ?><script>location.href = '/'</script><? endif; ?>
    <main class="main">
            <h1 class="title">Регистрация</h1>
        <div class="flex">
            <form class="form">
                <input type="text" name="name" id="name" placeholder="Имя" class="input">
                <input type="email" name="email" id="email" placeholder="Почта" class="input">
                <input type="password" name="password" id="password" placeholder="Пароль" class="input">
                <input type="password" name="password2" id="password2" placeholder="Пароль ещё раз" class="input">
                <button class="reg_button" id="regBtn" type="button">Создать аккаунт</button>
                <h5>Уже есть аккаунт? Тогда <a href="/authorization.php" class="enter">войдите</a>.</h5>
            </form>
        </div>
        <div class="error">
            <span id="errorSpan"></span>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $("#regBtn").click(function () {
            const name = $('#name').val()
            const email = $('#email').val()
            const password = $('#password').val()
            const password2 = $('#password2').val()
            $.ajax({
                url: '/code/register-user.php',
                type: 'POST',
                cache: false,
                data: {name, 
                    email, 
                    password,
                    password2},
                dataType: 'html',
                success: function (data) {
                    $('#errorSpan').show().text(data);

                    if (data.includes("успешно")) {
                        $('#errorSpan').removeClass('error').addClass('success'); 
                    } else {
                        $('#errorSpan').removeClass('success').addClass('error');
                    }
                }
            })
        })
    </script>
    <? include_once "./blocks/footer.php" ?>
</body>
</html>