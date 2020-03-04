<?php
require_once 'db.php';

Class shorten
{
    public function __construct(){

    }
    public function makeShort($long_link){
        return hash('crc32',$long_link); //т.к. не задан алгоритм получения короткой ссылки, выбран хэш-алгоритм crc32
    }
}