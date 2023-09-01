<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_country extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/country/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/country/js/default.js');
    }


    public function index()
    {
        $url = array();
        $url[] = 'country/index';
        $this->view->country = $this->model->get_all_country();
        $this->view->render('admin', $url);
    }

    public function add_country()
    {
        $this->model->add_country();
    }

    public function edit_country_data()
    {
        $this->model->edit_country_data();
    }

    public function change_country_status()
    {
        $this->model->change_country_status();
    }

}
