<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class admin_table extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->head_file = array('admin/table/css/tag.php');
    }

    public function index()
    {
        $url= array();
        $url[]= 'table/index';

        $this->view->render('admin', $url);
    }

}
