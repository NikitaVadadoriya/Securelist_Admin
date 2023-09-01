<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class admin_kyc extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::admin_redirect();
        $this->view->head_file = array('admin/kyc/css/tag.php');
        $this->view->fjs = array();
        $this->view->sjs = array('admin/kyc/js/default.js');
    }


    public function index()
    {
        $url = array();
        $url[] = 'kyc/index';
        $this->view->kyc = $this->model->get_today_all_request();
        $this->view->business_list = $this->model->get_business_list();
        $this->view->render('admin', $url);
    }

    public function pending()
    {
        $url = array();
        $url[] = 'kyc/pending';

        $this->view->kyc = $this->model->get_today_all_request();
        $this->view->business_list = $this->model->get_business_list();
        $this->view->reject_reasons = $this->model->get_reject_reasons();
        $this->view->render('admin', $url);
    }

    public function get_request_data()
    {
        $this->model->get_request_data();
    }

    public function approve_kyc()
    {
        $this->model->approve_kyc();
    }

    public function edit_kyc_data()
    {
        $this->model->edit_kyc_data();
    }

    public function reject_kyc()
    {
        $this->model->reject_kyc();
    }

}
