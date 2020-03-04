<?php
require_once '../model/shorten.php';
$conf = require_once '../model/config.php';
session_start();
$long_link = $_POST['long_link'];
$user_login = $_SESSION['user'];
if (isset($long_link)) {
    $Short = new shorten();
    $DB = new DB();
    if ($DB->checkLongLink($long_link)) {
        $short_link = $DB->getShortLink($long_link);
    } else {
        $DB->addLongLink($long_link, $user_login);
        $short_link = $Short->makeShort($long_link);
    }
    if ($short_link) {
        $DB->addShortLink($short_link, $long_link);
        $_SESSION['feedback'] = "Успех! Ваша ссылка: <a href='" . $conf['domain'] . "/$short_link' target='_blank'>" . $conf['domain'] . "/$short_link</a>";
    } else {
        $_SESSION['feedback'] = "Ошибка! Возможно, введен неправильный URL";
    }
    header('Location: ../index.php');
} else {
    header('Location: ../index.php');
}
$Short = NULL;
$DB = NULL;
