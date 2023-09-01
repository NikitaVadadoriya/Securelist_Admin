<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */

class admin_state extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/state/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/state/js/default.js');
    }

    public function index()
    {
        $url = array();
        $url[] = 'state/index';

        $this->view->country = $this->model->get_all_country();
        $this->view->render('admin', $url);
    }

    public function get_state()
    {
        $this->model->get_state();
    }

    public function add_state()
    {
        $this->model->add_state();
    }

    public function edit_state_data()
    {
        $this->model->edit_state_data();
    }

    public function change_state_status()
    {
        $this->model->change_state_status();
    }
}
