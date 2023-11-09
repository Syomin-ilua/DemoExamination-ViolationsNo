<?php

session_start();

if ($_SESSION['user']['userRole'] == "admin") {
    header("Location: ./admin.php");
}

if ($_SESSION['user']['userRole'] == "user") {
    header("Location: ./statements.php");
}

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/login-style.css">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Авторизация</title>
    <style>
        .message__wrapper {
            width: 280px;
            min-height: 70px;
            height: 100%;
            border: 7px solid rgb(255, 79, 79);
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            margin-top: 25px;
        }
        .message {
            font-size: 14px;
            font-family: sans-serif;
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>

<body>


    <header class="header">
        <div class="container header__container">
            <a href="./registration.php">
                <div class="logo">
                    <h1 class="logo__title">Нарушениям.Нет!</h1>
                </div>
            </a>
        </div>
    </header>


    <main class="main">
        <div class="container">
            <div class="auth__wrapper">
                <form action="./core/signIn.php" method="POST" class="form__auth">
                    <h1 class="auth__title">АВТОРИЗАЦИЯ</h1>
                    <div class="inputs__wrapper">
                        <div class="autch__inputs_wrapper">
                            <label class="input__label_wrapper" for="login">
                                <div class="input__wrapper">
                                    <p class="placeholder__text placeholder__text_login">Логин: </p>
                                    <input class="autch__input" id="login" name="login" type="text">
                                </div>
                                <p id="input-login-invalid" class="input__invalid"></p>
                            </label>
                            <label class="input__label_wrapper" for="password">
                                <div class="input__wrapper">
                                    <p class="placeholder__text placeholder__text_password">Пароль: </p>
                                    <input class="autch__input" id="password" name="password" type="text">
                                </div>
                                <p id="input-password-invalid" class="input__invalid"></p>
                            </label>
                        </div>
                    </div>
                    <div class="btn__autch_wrapper">
                        <button type="submit" class="btn__autch">Авторизоваться</button>
                    </div>
                </form>
            </div>
            <?
            if ($_SESSION['message']) {
                echo
                "
                        <div class='message__wrapper'>
                            <p class='message'>" . $_SESSION['message'] . "</p>
                        </div>
                    ";
            }
            unset($_SESSION['message']);
            echo $_SESSION['user'];
            ?>
        </div>
    </main>


    <footer class="footer">
        <div class="container">
            <p class="footer__text">© 2023 Все права защищены</p>
        </div>
    </footer>


    <script src="./scripts/login.js"></script>

</body>

</html>