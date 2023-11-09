<?php

session_start();
require_once "./core/connect.php";

if ($_SESSION['user']['userRole'] !== "admin") {
    header("Location: ./statements.php");
}

if (!$_SESSION['user']) {
    $_SESSION['message'] = 'Авторизуйтесь, либо если нету аккаунта зарегистрируйтесь';
    header("Location: ./login.php");
}

$statements = [];
$newStatements = [];
$statementsConfirm = [];
$statementsReject = [];

$query = "SELECT * FROM `statements`";
$smtp = $pdo->prepare($query);

if ($smtp->execute()) {

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
    <link rel="stylesheet" href="./styles/admin-style.css">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Панель администратора</title>
    <style>
        .btn__exit_wrapper h1 {
            font-size: 21px;
            font-family: sans-serif;
            font-weight: 600;
        }

        .statements {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            row-gap: 10px;
        }

        .statement {
            padding: 10px;
            border: 2px solid #333;
            border-radius: 3px;
        }

        .statement__number {
            display: flex;
            flex-direction: column;
            row-gap: 5px;
            margin-bottom: 10px;
            border-bottom: 1px solid #333;
        }

        .statement__userInfo {
            display: flex;
            column-gap: 5px;
        }

        .statement__userInfo span {
            font-size: 14px;
            font-family: sans-serif;
            font-weight: 600;
        }

        .statement__userInfo p {
            font-size: 14px;
            font-family: sans-serif;
            font-weight: 400;
        }

        .statement__number b {
            font-size: 18px;
            font-family: sans-serif;
            font-weight: 600;
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
            font-size: 14px;
            font-weight: 600;
        }

        .statement__info_row p {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }

        .statement__padding {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form__change_status {
            display: flex;
            flex-direction: column;
            row-gap: 10px;
        }

        .btn__confirm {
            width: 120px;
            height: 30px;
            background-color: green;
            transition: all 0.3s;
            color: #fff;
            font-family: sans-serif;
            font-weight: 600;
            font-size: 14px;
        }

        .btn__confirm:active {
            transform: scale(0.95);
            transition: all 0.3s;
        }

        .btn__reject {
            width: 120px;
            height: 30px;
            background-color: red;
            transition: all 0.3s;
            color: #fff;
            font-family: sans-serif;
            font-weight: 600;
            font-size: 14px;
        }

        .btn__reject:active {
            width: 200px;
            height: 30px;
            background-color: red;
            transition: all 0.3s;
        }

        .statements__empty_text {
            font-size: 16px;
            font-weight: 400;
            font-family: sans-serif;
        }
        .new__statements {
            display: flex;
            flex-direction: column;
            row-gap: 20px;
            margin-bottom: 40px;
        }
        .confirm__statements {
            display: flex;
            flex-direction: column;
            row-gap: 20px;
            margin-bottom: 40px;
        }
        .reject__statements {
            display: flex;
            flex-direction: column;
            row-gap: 20px;
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
        <div class="container">
            <div class="btn__exit_wrapper">
                <h1>Панель администратора</h1>

                <form class="form__exit" action="./core/signOut.php" method="POST">
                    <input type="hidden" name="userID" value="<? echo $_SESSION['user']['id'] ?>">
                    <button type="submit" class="btn__exit">Выйти</button>
                </form>
            </div>

            <div class="statements">
                <div class="new__statements">
                    <h1 class="statements__header_title">Новые заявления</h1>
                    <?
                    if (count($newStatements) == 0) {
                        echo "<div>
                                <p class='statements__empty_title'>Новых заявлений нет</p>
                            </div>";
                    } else {
                        foreach ($newStatements as $row) {
                            echo "<div class='statement'>"
                                . "<div class='statement__padding'>"
                                . "<div class='statement__information'>"
                                . "<div class='statement__number'>"
                                . "<b>Заявление №" . $row["id"] . "</b>"
                                . "<div class='statement__userInfo'>"
                                . "<span>Пользователь создавший заявление: </span>" . "<p>" . $row["surname"] . "<span> </span>" . $row["userName"] . "<span> </span>" . $row["patronymic"] . "<p>"
                                . "</div>"
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
                    ?>
                    <?
                            echo "<form action='./core/changeStatusStatement.php' method='POST' class='form__change_status statement__info_row'>"
                                . "<input name='statementID' type='hidden' value=" . $row["id"] . " " . " />";
                            if ($row["statusStatement"] == "новое") {
                                echo "<button class='btn__confirm' name='status'  value='подтвердить' type='submit'>Подтвердить</button>"
                                    . "<button class='btn__reject' name='status' value='отклонить' type='submit'>Отклонить</button>";
                            }

                            echo "</form>"
                                . "</div>"
                                . "</div>";
                        }
                    }
                    ?>
                </div>
                <div class="confirm__statements">
                    <h1 class="statements__header_title">Подтверждённые заявления</h1>
                    <?
                    if (count($statementsConfirm) == 0) {
                        echo "<div>
                                <h1 class='statements__empty_title'>Подтвердённых заявлений нет</h1>
                              </div>";
                    } else {

                        foreach ($statementsConfirm as $row) {
                            echo "<div class='statement'>"
                                        . "<div class='statement__information'>"
                                            . "<div class='statement__number'>"
                                                . "<b>Заявление №" . $row["id"] . "</b>"
                                                . "<div class='statement__userInfo'>"
                                                    . "<span>Пользователь создавший заявление: </span>" . "<p>" . $row["surname"] . "<span> </span>" . $row["userName"] . "<span> </span>" . $row["patronymic"] . "<p>"
                                                . "</div>"
                                            . "</div>"
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

                                . "</div>";
                        }
                    }

                    ?>
                </div>
                <div class="reject__statements">
                    <h1 class="statements__header_title">Отклонённые заявления</h1>
                    <?
                    if (count($statementsReject) == 0) {
                        echo "<div>
                        <p class='statements__empty_title'>Отклонённых заявлений нет</p>
                      </div>";
                    } else {
    
                        foreach ($statementsReject as $row) {
                            echo "<div class='statement'>"
                                    . "<div class='statement__information'>"
                                        . "<div class='statement__number'>"
                                            . "<b>Заявление №" . $row["id"] . "</b>"
                                            . "<div class='statement__userInfo'>"
                                                . "<span>Пользователь создавший заявление: </span>" . "<p>" . $row["surname"] . "<span> </span>" . $row["userName"] . "<span> </span>" . $row["patronymic"] . "<p>"
                                            . "</div>"
                                        . "</div>"
                                        ."</div>"
    
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
                                    ."</div>";
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