<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class login extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->head_file = array('web/login/css/test.php');


    }


    public function index()
    {

        $url= array();
        $url[]= 'login/index';
        $this->view->render('web', $url, 2);
    }

    public function check()
    {
        $this->model->check();
    }



}
