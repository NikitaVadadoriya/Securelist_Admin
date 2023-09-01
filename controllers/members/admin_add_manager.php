<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class admin_add_manager extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->head_file = array('admin/add_manager/css/tag.php');
        $this->view->fjs = array('select2/js/select2.full.min.js','datatables/jquery.dataTables.js','datatables-bs4/js/dataTables.bootstrap4.js');
        $this->view->sjs = array('admin/add_manager/js/default.js');
        // $this->view->onlineCDN = array('');

    }


    public function index()
    {

        $url= array();
        $url[]= 'add_manager/index';
        $this->view->manager_list = $this->model->get_all_manager();

        $this->view->render('admin', $url);
    }

    public function get_zone()
    {

        $this->model->get_zone();
    }

    public function add()
    {
        $this->model->add_manager();
    }

    public function edit($user_mail)
    {

        $url= array();
        $url[]= 'add_manager/edit';
        $this->view->manage_detail = $this->model->get_manage_detail($user_mail);
        $this->view->render('admin', $url);
    }

    public function edit_user()
    {
        $this->model->edit_user();
    }

}
