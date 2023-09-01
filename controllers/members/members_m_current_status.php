<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
*
*/
class members_m_current_status extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::redirect();
        $this->view->head_file = array('members/m_current_status/css/tag.php');
        $this->view->fjs = array('select2/js/select2.full.min.js','datatables/jquery.dataTables.js','datatables-bs4/js/dataTables.bootstrap4.js');
        $this->view->sjs = array('members/m_current_status/js/default.js');
        // $this->view->onlineCDN = array('https://maps.googleapis.com/maps/api/js?key=AIzaSyBHk0MQSQTeMa7NPT2m6y4fgNDQe0tNofU&callback=myMap');


    }


    public function index()
    {

        $url= array();
        $url[]= 'm_current_status/index';
        $this->view->get_cdata = $this->model->get_cdata();
        $this->view->render('members', $url);
    }


    public function mapview()
    {

        $url= array();
        $url[]= 'm_current_status/map_view';
        $this->view->get_cdata = $this->model->get_cdata();
        $this->view->render('members', $url);
    }

    public function get_area()
    {
        $this->model->get_area();
    }

    public function get_locality()
    {
        $this->model->get_locality();
    }

    public function insert_house()
    {
        $this->model->insert_house();
    }



}
