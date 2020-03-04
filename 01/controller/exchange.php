<?php
require_once "../model/exchange.php";


$amount = htmlspecialchars($_POST['amount']);
$prev_curr = $_POST['prev_curr'];
$end_curr = $_POST['end_curr'];
$Changer = new exchange($prev_curr,$end_curr,$amount);
$ans = $Changer->transform();
$Changer = NULL;
header("Location: ../index.php?ans=$ans&prev_curr=$prev_curr&end_curr=$end_curr&amount=$amount");