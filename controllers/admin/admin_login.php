<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class admin_login extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::check_isadmin_logged_in();
        $this->view->head_file = array('admin/login/css/tag.php');
        $this->view->sjs = array('admin/login/js/default.js');
    }

    public function index()
    {
        $url= array();
        $url[]= 'login/index';
        // $this->model->get_2fa_code();
        $this->view->render('admin', $url, 2);
    }

    public function verify()
    {
        $username = Session::get('temp_username');
        if (!empty($username)) {
            $url= array();
            $url[]= 'login/verify';
            $this->view->render('admin', $url, 2);
        } else {
            header('Location: ' . URL . admin_link . '/login');
            die;
        }
    }

    public function user_login()
    {
        $this->model->user_login();
    }
}
