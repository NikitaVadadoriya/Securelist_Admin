<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class index extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->fjs = array();
        $this->view->sjs = array('web/index/js/default.js');
        $this->view->head_file = array('web/index/css/tag.php');


    }


    public function index()
    {

        $url= array();
        $url[]= 'index/index';

        $this->view->render('web', $url);
    }

}
