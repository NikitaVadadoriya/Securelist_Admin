<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class members_login extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->head_file = array('members/login/css/tag.php');


    }


    public function index()
    {

        $url= array();
        $url[]= 'login/index';

        $this->view->render('members', $url, 2);
    }

    public function check()
    {


        $url= array();
        $url[]= 'login/index';
        $this->model->check();
        $this->view->render('members', $url, 2);
    }

}
