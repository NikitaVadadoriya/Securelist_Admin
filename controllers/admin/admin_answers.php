<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_answers extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/answers/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/answers/js/default.js');
    }

    public function index()
    {
        $url = array();
        $url[] = 'answers/index';
        // $this->view->questions = $this->model->get_all_questions();
        $this->view->sub_categories = $this->model->get_sub_cat_data();
        $this->view->render('admin', $url);
    }

    public function get_all_questions()
    {
        $this->model->get_all_questions();
    }

    public function get_all_answers()
    {
        $this->model->get_all_answers();
    }

    public function add_answers()
    {
        $this->model->add_answers();
    }

    public function edit_answer_data()
    {
        $this->model->edit_answer_data();
    }

    public function change_answer_status()
    {
        $this->model->change_answer_status();
    }

}
