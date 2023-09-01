<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_reject_reason extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/reject_reason/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/reject_reason/js/default.js');
    }

    public function index()
    {
        $url = array();
        $url[] = 'reject_reason/index';
        $this->view->reject_reasons = $this->model->get_all_reject_reason();
        $this->view->render('admin', $url);
    }

    public function add_reject_reason()
    {
        $this->model->add_reject_reason();
    }

    public function edit_reject_reason()
    {
        $this->model->edit_reject_reason();
    }

    public function change_reject_reason_status()
    {
        $this->model->change_reject_reason_status();
    }

}
