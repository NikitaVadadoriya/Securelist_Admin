<?php

class logout_Model extends Model
{
    public function __construct()
    {
        parent::__construct();


    }

    public function logout()
    {

        $user = Session::get('user');
        if($user!="") {
            Session::destroy();
            header("Location: ".URL."login");
        } else {
            header("Location: ".URL."login");
        }

    }
}
