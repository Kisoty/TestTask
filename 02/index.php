<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сокращатель URL</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1 class="title">Сокращатель URL</h1>
    <form action="controller/shorten.php" method="post">
        <input type="url" name="long_link" required placeholder="Введите URL" autocomplete="off">
        <input type="submit" value="Сократить">
    </form>
    <?
    if (isset($_SESSION['feedback'])) {
        echo "<p>" . $_SESSION['feedback'] . "</p>";
        unset($_SESSION['feedback']);
    }
    ?>
</div>


<?
     if (isset($_SESSION['user'])) {
         echo "<div class=\"user\">
                    <p>Вы вошли как ".$_SESSION['user']."</p>
                    <a href='view/user.php'>Ваши ссылки</a>
                    <br>
                    <a href=\"controller/auth.php?quit=1\">Выйти</a>
               </div>";
     } else {
        echo "<div class=\"auth\">
                 <h2>Войти в учетную запись</h2>
                 <a href=\"view/reg.php\">Регистрация</a>
                 <a href=\"view/auth.php\">Авторизация</a>
              </div>";
     }
?>

</body>
</html>
