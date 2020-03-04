<?php
require_once 'model/db.php';
if (isset($_GET['short_link'])) {
    $short_link = $_GET['short_link'];
    $DB = new DB;
    if ($long_link = $DB->getLongLink($short_link)){
        $DB->visitInc($short_link);
        $DB = NULL;
        header("Location: ".$long_link);
        exit();
    }
}
header('Location: index.php');