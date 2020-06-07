<?php

Class DB
{
    private $db_connect, $xml;
    public $names, $names_db, $updTime;

    public function __construct()
    {
        if (!$this->xml) {
            $this->xml = @simplexml_load_file('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
            // "@" не дает выводить Warning-и, связанные с данным объектом. Решение крайне смелое, но в случае,
            // когда ты уверен, что страшного ничего не произойдет, можно применять
        }
        $this->connect();
        if (!is_int($this->db_connect->exec('use currency'))) //подключение к нужной БД,проверка ее существования. если нет - создать и забить значениями из стороннего xml
        {
            $this->setUp();
        }
    }

    public function connect()
    {
        $config = require_once 'db_config.php';
        $this->db_connect = new PDO("mysql:host=" . $config['host'] . ";charset=" . $config['charset'], $config['user'], $config['pass']);
    }

    public function selectCurr($curr_name = NULL)
    {
        $stmt = $this->db_connect->prepare('SELECT `coeff` FROM `eur_currency` WHERE `name`=:name');
        $stmt->execute(['name' => $curr_name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['coeff'];
    }

    public function setUp()
    {
        $this->db_connect->exec('CREATE DATABASE IF NOT EXISTS `currency`');
        $this->db_connect->exec('use `currency`');
        $this->db_connect->exec('CREATE TABLE IF NOT EXISTS `eur_currency` (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(3) NOT NULL,
        coeff FLOAT NOT NULL,
        time TIMESTAMP NOT NULL  DEFAULT CURRENT_TIMESTAMP);
        INSERT INTO `eur_currency` (`name`, `coeff`) VALUES ("EUR",1)');
        if ($this->xml) {
            for ($i = 0; $i < count($this->xml->Cube->Cube->Cube); $i++) {
                $stmt = $this->db_connect->prepare('INSERT INTO `eur_currency`(`name`,`coeff`) VALUES (:name,:coeff)');
                $xml = $this->xml->Cube->Cube->Cube[$i]->attributes();
                $rates[$i] = $xml->rate;
                $this->names[$i] = $xml->currency;

                $stmt->execute(['name' => $this->names[$i], 'coeff' => $rates[$i]]);
            }
        }
        else {
            echo 'Беда, нет подключения к сервису. Проверьте ваше подключение, пишите жалобы Европейскому Центральному банку';
        }
        $this->db_connect = NULL;
    }

    public function update()
    {
        if ($this->xml) {
            for ($i = 0; $i < count($this->xml->Cube->Cube->Cube); $i++) {
                $stmt = $this->db_connect->prepare('UPDATE `eur_currency` SET `name` = (:name), `coeff` = (:coeff), `time` = NOW() WHERE `name` = (:name)');
                $xml = $this->xml->Cube->Cube->Cube[$i]->attributes();
                $rates[$i] = $xml->rate;
                $this->names[$i] = $xml->currency;
                $stmt->execute(['name' => $this->names[$i], 'coeff' => $rates[$i]]);
            }
        } else {
        }
        $stmt = $this->updTime = $this->db_connect->query('SELECT `time` FROM `eur_currency` WHERE `name`= "USD"');
        $this->updTime = $stmt->fetch()['time'];
    }

    public function getNames()
    {
        $stmt = $this->db_connect->query('SELECT `name` FROM `eur_currency`');
        $i = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->names_db[$i] = $row['name'];
            $i++;
        }
        return $this->names_db;
    }

    public function __destruct()
    {
        $this->db_connect = NULL;
    }
}