<?php
require_once '../model/user.php';
require_once '../model/db.php';
session_start();
$user = new user($_SESSION['user']);
$userInfo = $user->getStatistics();
$DB = NULL;

