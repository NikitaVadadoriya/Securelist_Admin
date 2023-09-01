<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class members_grid_report extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->head_file = array('members/grid_report/css/tag.php');
        $this->view->fjs = array('datatables/jquery.dataTables.js','datatables-bs4/js/dataTables.bootstrap4.js');
        $this->view->sjs = array('members/grid_report/js/default.js');
        $this->view->onlineCDN = array('');


    }
    public function index()
    {

        $url= array();
        $url[]= 'grid_report/index';

        $this->view->render('members', $url);
    }
}
