<?php
include_once "model/db.php";
$DBobj = new DB();
$DBobj->update();
// Тут нужно вызывать $DBojb->update() раз в день, например, но кроме как с помощью crone не нашел, как это сделать, а так как у меня нет
//linux виртуалки, то я не могу тестить, а делать черт знает что я не хочу. Посему пытаться апдейтиться он будет при каждом запуске страницы
// Если вы решите меня взять на работу, обещаю поставить все нужные ОСи :)
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="app.css">
    <title>Конвертер валют</title>
</head>
<body>
<h1>Поражающий воображение UI</h1>
<div id="input" style="float: left;border-right: 1px solid;padding: 10px; border-color: #0a0a0a">
    <form name="curr_form" action="controller/exchange.php" method="post">
        <label for="prev_curr">Выберите исходную валюту</label><br>
        <select name="prev_curr" required>
            <option value="" style="display:none"></option>
                <?php
                foreach ($DBobj->getNames() as $value) {
                if ($value==$_GET['prev_curr']){
                    echo "<option selected='selected'>$value</option>";
                } else {
                    echo "<option>$value</option>>";
                }
            }; ?>
        </select><br>
        <label for="end_curr">Выберите целевую валюту</label><br>
        <select name="end_curr" required>
            <option value="" style="display:none"></option>
            <?php foreach ($DBobj->getNames() as $value) {
                if ($value==$_GET['end_curr']){
                    echo "<option selected='selected'>$value</option>";
                } else {
                    echo "<option>$value</option>>";
                }
            };?>
        </select><br>
        <label for="amount">Введите сумму денег</label><br>
        <input type="number" name="amount" required value="<?=$_GET['amount']?>">
        <input type="submit" value="Рассчитать">
    </form>
</div>
<div id="output" style="position: relative;float: bottom;left:  2%">
    <?php if (isset($_GET['ans'])) {echo "Результат: ".$_GET['amount'].' '.$_GET['prev_curr'].' = '.$_GET['ans'].' '.$_GET['end_curr'];}?>
</div>
<img src="assets/s1200.webp" style="position:relative;height: 10%;width: 15%;left: 1%">
<p>Данные о курсе валют обновлены <?=$DBobj->updTime; $DBobj = null;?></p>
</body>
</html>
