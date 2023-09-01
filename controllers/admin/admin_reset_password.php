<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class admin_reset_password extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::check_isadmin_logged_in();
        $this->view->head_file = array('admin/reset_password/css/tag.php');
    }

    public function index()
    {
        if (Session::get("admin_reset_pass_userid")) {
            $url= array();
            $url[]= 'reset_password/index';
            $this->view->render('admin', $url, 2);
        } else {
            header("Location: ". URL . admin_link . '/login');
            exit;
        }
    }

    public function change_password()
    {
        if (Session::get("admin_reset_pass_userid")) {
            $this->model->change_password();
        } else {
            header("Location: ". URL . admin_link . '/login');
            exit;
        }
    }

}
