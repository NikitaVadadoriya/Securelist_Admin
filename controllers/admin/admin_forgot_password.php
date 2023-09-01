<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class admin_forgot_password extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::check_isadmin_logged_in();
        $this->view->head_file = array('admin/forgot_password/css/tag.php');
    }
    public function index()
    {
        $url= array();
        $url[]= 'forgot_password/index';
        $this->view->render('admin', $url, 2);
    }

    public function otp_send()
    {
        $this->model->otp_send();
    }

    public function otp()
    {
        if (Session::get("issetotp")) {
            $url = array();
            $url[] = 'forgot_password/otp';
            $this->view->render('admin', $url, 2);
        } else {
            header("Location: ". URL . admin_link);
            exit;
        }
    }

    public function check_otp()
    {
        if (Session::get("issetotp")) {
            $this->model->check_otp();
        } else {
            header("Location: ". URL . admin_link . '/login');
            exit;
        }
    }

}
