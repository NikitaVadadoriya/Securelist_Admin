<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_city extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/city/css/tag.php');
        $this->view->fjs = array( );
        $this->view->sjs = array('admin/city/js/default.js');
    }


    public function index()
    {
        $url = array();
        $url[] = 'city/index';

        $this->view->country = $this->model->get_all_country();
        $this->view->render('admin', $url);
    }

    public function get_city()
    {
        $this->model->get_city();
    }

    public function get_state_data()
    {
        $this->model->get_state_data();
    }

    public function add_city()
    {
        $this->model->add_city();
    }

    public function edit_city_data()
    {
        $this->model->edit_city_data();
    }

    public function change_city_status()
    {
        $this->model->change_city_status();
    }

}
