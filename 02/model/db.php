<?php

Class DB
{
    private $db_connect;
    public function __construct()
    {
        $this->connect();
        if (!is_int($this->db_connect->exec('use link_db'))) //подключение к нужной БД,проверка ее существования. если нет - создать
        {
            $this->setUp();
        }
    }

    public function connect()
    {
        $config = require_once 'db_config.php';
        $this->db_connect = new PDO("mysql:host=" . $config['host'] . ";charset=" . $config['charset'], $config['user'], $config['pass']);
    }

    public function setUp()
    {
        $this->db_connect->exec('CREATE DATABASE IF NOT EXISTS `link_db`; use `link_db');
        $this->db_connect->exec('CREATE TABLE IF NOT EXISTS `users` (
        `login` VARCHAR(20) NOT NULL PRIMARY KEY,
        `password` VARCHAR(20) NOT NULL);');
        $this->db_connect->exec('CREATE TABLE IF NOT EXISTS `links` (
        `long_link` VARCHAR(255) NOT NULL,
        `short_link` VARCHAR(20),
        `time` TIMESTAMP NOT NULL  DEFAULT CURRENT_TIMESTAMP,
        `visits` INT(11),
        `users_login` VARCHAR(20),
         FOREIGN KEY (`users_login`) REFERENCES `users` (`login`));');
        $this->db_connect = NULL;
    }

    public function checkLongLink($long_link)
    {
        $stmt = $this->db_connect->prepare("SELECT `long_link` FROM `links` WHERE `long_link` = (:long_link)");
        $stmt->execute(['long_link' => $long_link]);
        $result = $stmt->fetch();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function addLongLink($long_link, $user_login = NULL)
    {
        $stmt = $this->db_connect->prepare('INSERT INTO `links` (`long_link`, `users_login`) VALUES (:long_link, :user_login)');
        $stmt->execute(['long_link' => $long_link, 'user_login' => $user_login]);
    }

    public function getLongLink($short_link)
    {
        $stmt = $this->db_connect->prepare('SELECT `long_link` FROM `links` WHERE `short_link` = (:short_link)');
        $stmt->execute(['short_link' => $short_link]);
        $result = $stmt->fetch();
        return $result['long_link'];
    }

    public function addShortLink ($short_link, $long_link)
    {
        $stmt = $this->db_connect->prepare('UPDATE `links` SET `short_link` = (:short_link) WHERE `long_link` = (:long_link)');
        $stmt->execute(['short_link' => $short_link, 'long_link' => $long_link]);
    }

    public function getShortLink($long_link)
    {
        $stmt = $this->db_connect->prepare('SELECT `short_link` FROM `links` WHERE `long_link` = (:long_link)');
        $stmt->execute(['long_link' => $long_link]);
        $result = $stmt->fetch();
        return $result['short_link'];
    }

    public function checkUser ($user_login, $user_pass = NULL)
    {
        if ($user_pass != NULL) {
            $stmt = $this->db_connect->prepare('SELECT `login`, `password` FROM `users` WHERE `login` = (:user_login) AND `password` = (:user_pass)');
            $stmt->execute(['user_login' => $user_login, 'user_pass' => $user_pass]);
            $result = $stmt->fetch();
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            $stmt = $this->db_connect->prepare('SELECT `login` FROM `users` WHERE `login` = (:user_login)');
            $stmt->execute(['user_login' => $user_login]);
            $result = $stmt->fetch();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function regUser ($user_login,$user_pass)
    {
        $stmt = $this->db_connect->prepare('INSERT INTO `users` (`login`,`password`) VALUES (:user_login, :user_pass)');
        $stmt->execute(['user_login' => $user_login, 'user_pass' => $user_pass]);
    }

    public function getUserLinks ($user_login)
    {
        $stmt = $this->db_connect->prepare('SELECT * FROM `links` WHERE `users_login` = (:user_login)');
        $stmt->execute(['user_login' => $user_login]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function visitInc ($short_link)
    {
        $stmt = $this->db_connect->prepare('UPDATE `links` SET `visits` = `visits` + 1 WHERE `short_link` = (:short_link) ');
        $stmt->execute(['short_link' => $short_link]);
    }

    public function __destruct()
    {
        $this->db_connect = NULL;
    }
}