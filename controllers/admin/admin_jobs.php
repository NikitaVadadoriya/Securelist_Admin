<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */

class admin_jobs extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/jobs/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/jobs/js/default.js');
    }

    public function index()
    {
        $url = [];
        $url[] = 'jobs/index';
        $this->view->business_list  = $this->model->get_business_list();
        $this->view->sub_cat_list = $this->model->get_sub_categories();
        $this->view->today_jobs = $this->model->get_today_job_data();

        $this->view->render('admin', $url);
    }

    public function get_job_data()
    {
        $this->model->get_job_data();
    }

    public function get_user_list_data()
    {
        $this->model->get_user_list_data();
    }
}
