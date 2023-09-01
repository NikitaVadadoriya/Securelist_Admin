<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */

class admin_change_password extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();

        $this->view->head_file = array('admin/change_password/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/change_password/js/default.js');

    }

    public function index()
    {
        $url = [];
        $url[] = 'change_password/index';

        $this->view->render('admin', $url);
    }

    public function change_pass()
    {
        $this->model->change_pass();
    }
}
