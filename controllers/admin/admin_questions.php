<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_questions extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/questions/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/questions/js/default.js');
    }

    public function index()
    {
        $url = array();
        $url[] = 'questions/index';
        $this->view->questions = $this->model->get_all_questions();
        $this->view->sub_categories = $this->model->get_sub_cat_data();
        $this->view->render('admin', $url);
    }

    public function add_questions()
    {
        $this->model->add_questions();
    }

    public function edit_question_data()
    {
        $this->model->edit_question_data();
    }

    public function change_question_status()
    {
        $this->model->change_question_status();
    }
}
