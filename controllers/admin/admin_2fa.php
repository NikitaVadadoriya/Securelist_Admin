<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class admin_2fa extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->view->head_file = array('admin/2fa/css/tag.php');
    }

    public function index()
    {
        $url= array();
        $url[]= '2fa/index';
        $this->view->user_data = $this->model->get_user_data();
        $this->view->render('admin', $url, 2);
    }

    public function update_2fa()
    {
        $this->model->update_2fa();
    }
}
