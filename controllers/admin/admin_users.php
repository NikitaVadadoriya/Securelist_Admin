<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_users extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/users/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/users/js/default.js');
    }

    public function index()
    {
        $url = array();
        $url[] = 'users/index';
        $this->view->users = $this->model->get_all_users();
        $this->view->today_data = $this->model->get_today_all_request();
        $this->view->render('admin', $url);
    }

    public function get_users_data()
    {
        $this->model->get_users_data();
    }

    public function change_user_status()
    {
        $this->model->change_user_status();
    }
}
