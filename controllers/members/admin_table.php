<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class admin_table extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->head_file = array('admin/table/css/tag.php');
        $this->view->fjs = array('datatables/jquery.dataTables.js','datatables-bs4/js/dataTables.bootstrap4.js');
        $this->view->sjs = array('admin/table/js/default.js');
        $this->view->onlineCDN = array('');


    }


    public function index()
    {

        $url= array();
        $url[]= 'table/index';

        $this->view->render('admin', $url);
    }

}
