<?php

session_start()



?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/newStatements-style.css">
    <title>Формирование заявления</title>
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


    <main>
        <div class="container">
            <div class="btn__exit_wrapper">
                <div class="link__newStatements_wrapper">
                    <a href="./statements.php" class="link__newStatements">&larr; Назад</a>
                </div>

                <form class="form__exit_ak" action="./core/signOut.php" method="POST">
                    <input type="hidden" name="userID" value="<? echo $_SESSION['user']['id'] ?>">
                    <button type="submit" class="btn__exit">Выйти из профиля</button>
                </form>
            </div>
            <div class="statement__form_add-wrapper">
                <div class="new__statement_title_wrapper">
                    <h1 class="new__statement_title">Добавить новое заявление</h1>
                </div>
                <form class="statement__form_add" action="./core/addStatement.php" method="POST">
                    <input type="hidden" name="userId" value="<? echo $_SESSION['user']['id'] ?>">
                    <input type="hidden" name="userSurname" value="<? echo $_SESSION['user']['surname'] ?>">
                    <input type="hidden" name="userName" value="<? echo $_SESSION['user']['name'] ?>">
                    <input type="hidden" name="userPatronymic" value="<? echo $_SESSION['user']['patronymic'] ?>">
                    <label class="input__wrapper" for="numberAuto">
                        <p>Регистрационный номер автомобиля:</p>
                        <input class="input input__numberAuto" name="numberAuto" id="numberAuto" required type="text">
                    </label>
                    <label class="input__wrapper" for="descriptionViolation">
                        <p>Описание нарушения:</p>
                        <textarea class="input__descriptionViolation" name="descriptionViolation" rows="3" required id="descriptionViolation" name="descriptionViolation" type="text"></textarea>
                    </label>
                    <div class="btn__addStatement">
                        <button class="btn__add_statement" type="submit">Добавить нарушение</button>
                    </div>
                </form>
            </div>
        </div>
    </main>


    <footer class="footer">
        <div class="container">
            <p class="footer__text">© 2023 Все права защищены</p>
        </div>
    </footer>

</body>

</html>