<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
</head>
<body>
<div class="container">
    <h1>Регистрация</h1>
    <form action="../controller/reg.php" method="post">
        <input type="text" name="user_login" required placeholder="Введите логин">
        <input type="password" name="user_pass" required placeholder="Введите пароль">
        <button type="submit">Отправить</button>
    </form>
    <?
    echo "<p>" . $_SESSION['feedback'] . "</p>";
    unset($_SESSION['feedback']);
    ?>
    <a href="../index.php">На главную</a>
</div>
</body>
</html>