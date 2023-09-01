<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_sub_categories extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/sub_categories/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/sub_categories/js/default.js');
    }

    public function index()
    {
        $url = array();
        $url[] = 'sub_categories/index';
        $this->view->sub_categories = $this->model->get_all_sub_categories();
        $this->view->render('admin', $url);
    }

    public function add_sub_category()
    {
        $this->model->add_sub_category();
    }

    public function edit_sub_cat_data()
    {
        $this->model->edit_sub_cat_data();
    }

    public function change_sub_cat_status()
    {
        $this->model->change_sub_cat_status();
    }

}
