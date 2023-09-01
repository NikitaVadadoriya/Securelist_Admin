<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class admin_index extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/index/css/tag.php');
    }


    public function index()
    {
        $url= array();
        $url[]= 'index/index';

        $this->view->render('admin', $url);
    }

}
