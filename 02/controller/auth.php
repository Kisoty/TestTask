<?php
require_once '../model/db.php';
session_start();
if (isset($_POST['user_login']) || isset($_POST['user_pass'])) {
    $user_login = trim(strip_tags($_POST['user_login']));
    $user_pass = trim(strip_tags($_POST['user_pass']));
    $DB = new DB();
    if($DB->checkUser($user_login,$user_pass)){
        $DB = NULL;
        $_SESSION['user'] = $user_login;
        header('Location: ../index.php');
    } else {
        $DB = NULL;
        $_SESSION['feedback'] = 'Неверно введен логин или пароль';
        header('Location: ../view/auth.php');
    }
}
if (isset($_GET['quit']) ){
    if ($_GET['quit'] = 1) {
        unset($_SESSION['user']);
        header('Location: ../index.php');
    }
}
