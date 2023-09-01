<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class api_customer extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $site_token = $_POST['site_token'];

        // parent::check_sitetoken($site_token,1);

    }


    public function create_request()
    {

        $this->model->create_request();

    }

    public function get_my_request()
    {
        $this->model->get_my_request();
    }

    public function scan_house()
    {
        $this->model->scan_house();
    }

}
