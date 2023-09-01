<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
*
*/
class api_TeamLeader extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $site_token = $_POST['site_token'];

        // parent::check_sitetoken($site_token,1);

    }


    public function login()
    {

        $this->model->login();

    }

    public function get_today_request()
    {
        $this->model->get_today_request();
    }

    public function assing_request()
    {
        $this->model->assing_request();
    }

    public function get_today_request_info()
    {
        $this->model->get_today_request_info();
    }

}
