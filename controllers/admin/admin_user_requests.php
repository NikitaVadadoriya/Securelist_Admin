<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_user_requests extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/user_requests/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/user_requests/js/default.js');
    }


    public function index()
    {
        $url = array();
        $url[] = 'user_requests/index';
        $this->view->users = $this->model->get_all_users();
        $this->view->sub_cat_list = $this->model->get_sub_categories();
        $this->view->today_requests = $this->model->get_today_requests();
        // $this->view->user_requests = $this->model->get_all_user_requests();
        $this->view->render('admin', $url);
    }

    public function get_request_data()
    {
        $this->model->get_request_data();
    }

    public function get_request_qa_data()
    {
        $this->model->get_request_qa_data();
    }

    public function get_business_list_data()
    {
        $this->model->get_business_list_data();
    }
}
