<?php

session_start();

if($_SESSION['user']['userRole'] == "admin") {
    header("Location: ./admin.php");
}

if($_SESSION['user']['userRole'] == "user") {
    header("Location: ./statements.php");
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/registration-style.css">
    <title>Регистрация</title>
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
            <div class="registration__wrapper">
                <form action="/core/signUp.php" method="POST" class="form__registration">
                    <h1 class="registr__title">РЕГИСТРАЦИЯ</h1>
                    <div class="inputs__wrapper">
                        <b class="inputs__header">Основные данные: </b>
                        <div class="main__inputs_wrapper">
                            <label class="input__wrapper" for="surname">
                                <p class="placeholder__text">Фамилия:</p>    
                                <input class="main__input" id="surname" name="surname" required type="text">
                                <p id="input-surname-invalid" class="input__invalid"></p>
                            </label>
                            <label class="input__wrapper" for="name">
                                <p class="placeholder__text">Имя: </p>
                                <input class="main__input" id="name" name="name" required type="text">
                                <p id="input-name-invalid" class="input__invalid"></p>
                            </label>
                            <label class="input__wrapper" for="patronymic">
                                <p class="placeholder__text">Отчество:</p>
                                <input class="main__input" id="patronymic" name="patronymic" required type="text">
                                <p id="input-patronymic-invalid" class="input__invalid"></p>
                            </label>
                        </div>
                    </div>

                    <div class="inputs__wrapper">
                        <b class="inputs__header">Контакты:</b>
                        <div class="contacts__inputs_wrapper">
                            <label class="input__wrapper" for="phone">
                                <p id="placeholder-text-tel" class="placeholder__text">Телефон: </p>    
                                <input class="contact__input" id="phone" name="tel" type="tel">
                                <p id="input-tel-invalid" class="input__invalid"></p>
                            </label>
                            <label class="input__wrapper" for="email">  
                                <p id="placeholder-text-email" class="placeholder__text">Эл. почта:</p>
                                <input class="contact__input" id="email" name="email" type="email">
                                <p id="input-email-invalid" class="input__invalid"></p>
                            </label>
                        </div>
                    </div>

                    <div class="inputs__wrapper">
                        <b class="inputs__header">Данные для авторизации:</b>
                        <div class="autch__inputs_wrapper">
                            <label class="input__wrapper" for="login">
                                <p class="placeholder__text">Логин: </p>    
                                <input class="autch__input" id="login" name="login" required type="text">
                                <p id="input-login-invalid" class="input__invalid"></p>
                            </label>
                            <label class="input__wrapper" for="password">
                                <p class="placeholder__text">Пароль</p>    
                                <input class="autch__input" id="password" name="password" required type="text">
                                <p id="input-password-invalid" class="input__invalid"></p>
                            </label>
                        </div>
                    </div>
                    <div class="btn__registration_wrapper">
                        <button type="submit" class="btn__registration">Зарегистрироваться</button>
                    </div>
                </form>


                <?
                    if($_SESSION['message']) {
                        echo 
                        "<div class='message__wrapper'>
                            <p class='message'>" 
                                . $_SESSION['message'] . 
                            "</p>
                        </div>";
                    }
                    unset($_SESSION['message']);
                ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p class="footer__text">© 2023 Все права защищены</p>
        </div>
    </footer>
    

    <script src="./scripts/register.js"></script>
</body>
</html>