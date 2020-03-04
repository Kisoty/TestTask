<?php
require_once '../controller/user.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>Личный кабинет</title>
</head>
<body>
<div class="stats">
    <table class="simple-little-table">
        <tr>
            <td>Длинная ссылка</td>
            <td>Короткая ссылка</td>
            <td>Дата</td>
            <td>Кол-во посещений</td>
        </tr>
        <?
        for ($i=0;$i<count($userInfo);$i++){
            echo "<tr>
                      <td>".$userInfo[$i]['long_link']."</td>
                      <td>".$userInfo[$i]['short_link']."</td>
                      <td>".$userInfo[$i]['time']."</td>
                      <td>".$userInfo[$i]['visits']." </td>
                  </tr>";
        }
        ?>
    </table>
    <a href="../index.php">На главную</a>
</div>
</body>
</html>