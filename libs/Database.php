<?php

class Database extends PDO
{
    public function __construct()
    {
        parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME.';charset='.CHAR_SET, DB_USER, DB_PASS);
    }


}
