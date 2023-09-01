<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class members_manage_tl extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::redirect();
        $this->view->head_file = array('members/manage_tl/css/tag.php');
        $this->view->fjs = array('select2/js/select2.full.min.js','datatables/jquery.dataTables.js','datatables-bs4/js/dataTables.bootstrap4.js');
        $this->view->sjs = array('members/manage_tl/js/default.js');
        // $this->view->onlineCDN = array('');

    }


    public function index()
    {

        $url= array();
        $url[]= 'manage_tl/index';
        $this->view->TL_list = $this->model->get_all_details();
        $this->view->zone_list = $this->model->get_zone_by_manager();
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
        /*echo "<pre>";
        print_r($_POST);
        exit();*/
        //$this->model->manage_tl();
        $this->model->add_teamleader();
    }

    public function edit($user_mail)
    {

        $url= array();
        $url[]= 'manage_tl/edit';
        $this->view->tl_detail = $this->model->get_tl_detail($user_mail);
        $this->view->render('members', $url);
    }

    public function edit_user()
    {
        $this->model->edit_user();
    }

    public function get_supervisor_by_area()
    {
        $this->model->get_supervisor_by_area();
    }

    public function get_supervisor_by_manager()
    {
        $this->model->get_supervisor_by_manager();
    }


    public function get_locality_by_area()
    {
        $this->model->get_locality_by_area();
    }

}
