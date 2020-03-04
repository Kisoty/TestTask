<?php


class user
{
    public $user_login;

    public function __construct($user_login)
    {
        $this->user_login = $user_login;
    }
    public function getStatistics (){
        $DB = new DB();
        return $DB->getUserLinks($this->user_login);
    }
}