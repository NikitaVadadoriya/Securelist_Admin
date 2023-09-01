<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class admin_form extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->head_file = array('admin/form/css/tag.php');
        $this->view->fjs = array('select2/js/select2.full.min.js','moment/moment.min.js','daterangepicker/daterangepicker.js');
        $this->view->sjs = array('admin/form/js/default.js');
        $this->view->onlineCDN = array('');

    }


    public function index()
    {

        $url= array();
        $url[]= 'form/index';

        $this->view->render('admin', $url);
    }

}
