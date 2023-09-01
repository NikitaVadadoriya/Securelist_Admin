<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_business extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/business/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/business/js/default.js');
    }

    public function index()
    {
        $url = array();
        $url[] = 'business/index';

        $this->view->business_list = $this->model->get_business_list();
        $this->view->today_registered = $this->model->get_today_data();

        $this->view->render('admin', $url);
    }

    public function change_user_status()
    {
        $this->model->change_user_status();
    }

    public function get_data()
    {
        $this->model->get_data();
    }
}
