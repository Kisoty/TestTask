<?php

require_once '../model/db.php';
session_start();
if (isset($_POST['user_login']) || isset($_POST['user_pass'])) {
    $user_login = trim(strip_tags($_POST['user_login']));
    $user_pass = trim(strip_tags($_POST['user_pass']));
    $DB = new DB();
    if ($DB->checkUser($user_login)) {
        $_SESSION['feedback'] = 'Пользователь с таким логином уже зарегистрирован, выберите другой';
        header('Location: ../view/reg.php');
    } else {
        $DB->regUser($user_login, $user_pass);
        $_SESSION['feedback'] = 'Регистрация прошла успешно';
        header('Location: ../index.php');
    }
    $DB = NULL;
}
