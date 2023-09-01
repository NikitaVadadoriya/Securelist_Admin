<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class members_manage_supervisor extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::redirect();
        $this->view->head_file = array('members/manage_supervisor/css/tag.php');
        $this->view->fjs = array('select2/js/select2.full.min.js','datatables/jquery.dataTables.js','datatables-bs4/js/dataTables.bootstrap4.js');
        $this->view->sjs = array('members/manage_supervisor/js/default.js');
        // $this->view->onlineCDN = array('');

    }


    public function index()
    {

        $url= array();
        $url[]= 'manage_supervisor/index';
        $this->view->manager_list = $this->model->get_all_supervisor();

        $this->view->render('members', $url);
    }

    public function get_zone()
    {

        $this->model->get_zone();
    }

    public function get_manager_and_area_byzone()
    {

        $this->model->get_manager_and_area_byzone();
    }

    public function add()
    {
        $this->model->add_supervisor();
    }

    public function edit($user_mail)
    {

        $url= array();
        $url[]= 'manage_supervisor/edit';
        $this->view->supervisor_detail = $this->model->get_supervisor_detail($user_mail);
        $this->view->render('members', $url);
    }

    public function edit_user()
    {
        $this->model->edit_user();
    }

}
