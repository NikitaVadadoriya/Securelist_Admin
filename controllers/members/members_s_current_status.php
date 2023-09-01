<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class members_s_current_status extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::redirect();
        $this->view->head_file = array('members/s_current_status/css/tag.php');
        $this->view->fjs = array('select2/js/select2.full.min.js','datatables/jquery.dataTables.js','datatables-bs4/js/dataTables.bootstrap4.js');
        $this->view->sjs = array('members/s_current_status/js/default.js');
        $this->view->onlineCDN = array('');


    }


    public function index()
    {

        $url= array();
        $url[]= 's_current_status/index';
        $this->view->get_cdata = $this->model->get_cdata();
        $this->view->render('members', $url);
    }

    public function get_locality()
    {

        $this->model->get_locality();
    }

}
