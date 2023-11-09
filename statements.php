<?php


session_start();
require_once "./core/connect.php";

if ($_SESSION['user']['userRole'] == "admin") {
    header("Location: ./admin.php");
}

$statements = [];
$newStatements = [];
$statementsConfirm = [];
$statementsReject = [];

$query = "SELECT * FROM `statements` where idUser = :id";
$smtp = $pdo->prepare($query);

if ($smtp->execute([
    ':id' => $_SESSION['user']['id']
])) {

    $rows = $smtp->rowCount();

    if ($rows > 0) {
        $statements = $smtp->fetchAll(PDO::FETCH_ASSOC);

        $newStatements = array_filter($statements, function ($item) {
            return $item["statusStatement"] === "новое";
        });
        $statementsConfirm = array_filter($statements, function ($item) {
            return $item["statusStatement"] === "подтверждено";
        });
        $statementsReject = array_filter($statements, function ($item) {
            return $item["statusStatement"] === "отклонено";
        });

    } else {
        $statements = [
            "message" => "У вас пока нет своих заявлений!"
        ];
    }
} else {
    $statements = [
        "message" => "Произошла ошибка получения данных о ваших заявлениях! Попробуйте позже!"
    ];
}

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/statements.css">
    <title>Страница заявлений</title>
    <style>

        .user__info_wrapper {
            display: flex;
            flex-direction: column;
            padding: 10px;
            border: 2px solid #333;
            border-radius: 5px;
        }

        .user__info {
            display: flex;
            flex-direction: column;
            row-gap: 15px;
        }

        .user__header_title {
            font-weight: 700;
            font-size: 21px;
            font-family: sans-serif;
            margin-bottom: 20px;
        }

        .user__info_column {
            display: flex;
        }

        .user__info_column b {
            font-size: 14px;
            font-weight: 600;
            font-family: sans-serif;
            margin-right: 10px;
        }

        .user__info_column p {
            font-size: 14px;
            font-weight: 400;
            font-family: sans-serif;
        }

        .user__info_row {
            display: flex;
            flex-direction: column;
            row-gap: 10px;
        }

        .user__info_role {}

        .user__info_contacts {}

        .btn__exit_wrapper {}

        .btn__exit {}
        
        .statement__title_wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 50px;
            margin-bottom: 40px;
        }

        .statement__title {
            font-size: 21px;
            font-family: sans-serif;
            font-weight: 600;
        }

        .statements {
            max-width: 100%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: start;
        }
        
        .link__newStatements {
            font-size: 14px;
            font-weight: 400;
            font-family: sans-serif;
            color: black;
            transition: all 0.2s;
        }

        .link__newStatements:hover {
            color: gray;
            transition: all 0.2s;
        }

        .statements__wrapper {
            display: flex;
            flex-direction: column;
            row-gap: 15px;
        }

        .statement {
            border: 3px solid #333;
            border-radius: 5px;
            padding: 10px;
        }

        .statement__padding {
            display: flex;
            flex-direction: column;
            row-gap: 10px;
        }

        .statement__number {
            font-size: 18px;
            font-family: sans-serif;
            font-weight: 600;
            display: flex;
            justify-content: center;
            border-bottom: 2px solid #333;
            
        }
        
        .statement__number b {
            padding-bottom: 4px;
        }

        .statement__info {
            display: flex;
            flex-direction: column;
            row-gap: 7px;
        }

        .statement__info_row {
            display: flex;
            column-gap: 10px;
        }

        .statement__info_row b {
            font-family: sans-serif;
            font-size: 16px;
            font-weight: 600;
        }

        .statement__info_row p {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }

        .statements__empty_title {
            font-size: 14px;
            font-weight: 400;
            font-family: sans-serif;
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

    <main>
        <div class="container statements__container">
            <div class="user__info_wrapper">
                <h1 class="user__header_title">Данные о пользователе: </h1>

                <div class="user__info">
                    <?
                    echo
                    "
                            <div class='user__info_row user__info_fio'>
                                <div class='user__info_column'>
                                    <b>Фамилия: </b>
                                    <p>" . $_SESSION["user"]["surname"] . "</p>
                                </div>
                                <div class='user__info_column'>
                                    <b>Имя: </b>
                                    <p>" . $_SESSION["user"]["name"] . "</p>
                                </div>
                                <div class='user__info_column'>
                                    <b>Отчество: </b>
                                    <p>" . $_SESSION["user"]["patronymic"] . "</p>
                                </div>
                            </div>
                            <div class='user__info_row user__info_role'>
                                <div class='user__info_column'>
                                    <b>Роль: </b>
                                    <p>" . $_SESSION["user"]["userRole"] . "</p>
                                </div>
                            </div>
                            <div class='user__info_row user__info_contacts'>
                                <div class='user__info_column'>
                                    <b>Эл. почта: </b>
                                    <p>" . $_SESSION["user"]["email"] . "</p>
                                </div>
                                <div class='user__info_column'>
                                    <b>Телефон: </b>
                                    <p>" . $_SESSION["user"]["tel"] . "</p>
                                </div>
                            </div>
                        ";

                    ?>
                </div>

                <div class="btn__exit_wrapper">
                    <form action="./core/signOut.php" method="POST">
                        <input type="hidden" name="userID" value="<? echo $_SESSION['user']['id'] ?>">
                        <button type="submit" class="btn__exit">Выйти из аккаунта</button>
                    </form>
                </div>
            </div>

            <div class="statement__title_wrapper">
                <b class="statement__title">Ваши заявления</b>
                <div class="link__newStatements_wrapper">
                    <a href="./newStatements.php" class="link__newStatements">Новое заявление</a>
                </div>
            </div>
            <div class="statements">
                <div class="new__statements">
                    <h1 class="statements__header_title">Новые заявления</h1>
                    <?
                    if(count($newStatements) == 0) {
                        echo "<div>
                                <h1 class='statements__empty_title'>Новых заявлений нет</h1>
                              </div>";
                    } else {
                        foreach ($newStatements as $row) {
                            echo "<div class='statement'>"
                                . "<div class='statement__padding'>"
                                . "<div class='statement__number'>"
                                . "<b>Заявление №" . $row["id"] . "</b>"
                                . "</div>"
                                . "<div class='statement__info'>"
                                . "<div class='statement__info_row'>"
                                . "<b>Гос. номер машины: </b>" . "<p>" . $row["numberAuto"] .  "</p>"
                                . "</div>"
    
                                . "<div class='statement__info_row'>"
                                . "<b>Описание нарушения: </b>" . "<p>" . $row["descriptionViolation"] .  "</p>"
                                . "</div>"
    
                                . "<div class='statement__info_row'>"
                                . "<b>Статус заявления: </b>" . "<p>" . $row["statusStatement"] .  "</p>"
                                . "</div>"
                                . "</div>"
                                . "</div>"
                                . "</div>";
                        }
                    }
                    ?>
                </div>
                <div class="confirm__statements">
                    <h1 class="statements__header_title">Подтверждённые заявления</h1>
                    <?
                    if(count($statementsConfirm) == 0) {
                        echo "<div>
                                <h1 class='statements__empty_title'>Подтвердённых заявлений нет</h1>
                             </div>";
                    } else {
                        foreach ($statementsConfirm as $row) {
                            echo "<div class='statement'>"
                                . "<div class='statement__padding'>"
                                . "<div class='statement__number'>"
                                . "<b>Заявление №" . $row["id"] . "</b>"
                                . "</div>"
                                . "<div class='statement__info'>"
                                . "<div class='statement__info_row'>"
                                . "<b>Гос. номер машины: </b>" . "<p>" . $row["numberAuto"] .  "</p>"
                                . "</div>"
    
                                . "<div class='statement__info_row'>"
                                . "<b>Описание нарушения: </b>" . "<p>" . $row["descriptionViolation"] .  "</p>"
                                . "</div>"
    
                                . "<div class='statement__info_row'>"
                                . "<b>Статус заявления: </b>" . "<p>" . $row["statusStatement"] .  "</p>"
                                . "</div>"
                                . "</div>"
                                . "</div>"
                                . "</div>";
                        }
                    }
                    ?>
                </div>
                <div class="reject__statements">
                    <h1 class="statements__header_title">Отклонённые заявления</h1>
                    <?
                    if(count($statementsReject) == 0) {
                        echo "<div>
                                <h1 class='statements__empty_title'>Отклонённых заявлений нет</h1>
                              </div>";
                    } else {
                        foreach ($statementsReject as $row) {
                            echo "<div class='statement'>"
                                . "<div class='statement__padding'>"
                                . "<div class='statement__number'>"
                                . "<b>Заявление №" . $row["id"] . "</b>"
                                . "</div>"
                                . "<div class='statement__info'>"
                                . "<div class='statement__info_row'>"
                                . "<b>Гос. номер машины: </b>" . "<p>" . $row["numberAuto"] .  "</p>"
                                . "</div>"
    
                                . "<div class='statement__info_row'>"
                                . "<b>Описание нарушения: </b>" . "<p>" . $row["descriptionViolation"] .  "</p>"
                                . "</div>"
    
                                . "<div class='statement__info_row'>"
                                . "<b>Статус заявления: </b>" . "<p>" . $row["statusStatement"] .  "</p>"
                                . "</div>"
                                . "</div>"
                                . "</div>"
                                . "</div>";
                        }
                    }
                    ?>
                </div>
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