<?php

class admin_logout extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        Session::destroy();
        header("Location: ". URL . admin_link . '/login');
        exit;
    }
}
