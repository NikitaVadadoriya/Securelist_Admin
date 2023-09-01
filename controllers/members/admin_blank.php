<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class admin_blank extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->head_file = array('admin/blank/css/tag.php');
        $this->view->fjs = array('');
        $this->view->sjs = array('admin/blank/js/default.js');
        $this->view->onlineCDN = array('');

    }


    public function index()
    {

        $url= array();
        $url[]= 'blank/index';

        $this->view->render('admin', $url);
    }

}
