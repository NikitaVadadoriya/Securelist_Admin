<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_job_fee_packages extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/job_fee_packages/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/job_fee_packages/js/default.js');
    }


    public function index()
    {
        $url = array();
        $url[] = 'job_fee_packages/index';
        $this->view->job_fee_packages = $this->model->get_all_job_fee_packages();
        $this->view->render('admin', $url);
    }

    public function add_job_fee_packages()
    {
        $this->model->add_job_fee_packages();
    }

    public function edit_job_fee_packages_data()
    {
        $this->model->edit_job_fee_packages_data();
    }

    public function change_job_fee_packages_status()
    {
        $this->model->change_job_fee_packages_status();
    }

}
