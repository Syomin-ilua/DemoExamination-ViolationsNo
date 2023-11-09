<?php

    session_start();
    require_once "connect.php";

    $userLogin = $_POST['login'];
    $userPassword = $_POST['password'];

    if(empty($userLogin) || empty($userPassword)) {
        $_SESSION['message'] = 'Поля не должны быть пустые!';
        header("Location: ../login.php");    
    }

    $query = "SELECT * FROM `users` where userLogin = :userLogin AND userPassword = :userPassword";
    $smtp = $pdo->prepare($query);
    if($smtp->execute([':userLogin' => $userLogin, ':userPassword' => $userPassword])) {
        
        $rows = $smtp->rowCount();

        if($rows > 0) {
            $userInfo = $smtp->fetch(PDO::FETCH_ASSOC);
            // $_SESSION['message'] = "Авторизация прошла успешно!";
            $_SESSION['user'] = [
                "id" => $userInfo['id'],
                "surname" => $userInfo['surname'],
                "name" => $userInfo['userName'],
                "patronymic" => $userInfo['patronymic'],
                "tel" => $userInfo['tel'],
                "email" => $userInfo['email'],
                "userRole" => $userInfo['userRole']
            ];
            header("Location: ../statements.php");
        } else {
            header("Location: ../login.php");
            $_SESSION['message'] = "Такого пользователя не существует!";
        }
    }




?>