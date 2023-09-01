<?php

class members_index extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::redirect();
    }


    public function index()
    {

        $url = array();
        $url[]='index/index';
        // echo "here in cont";

        $this->view->render('members', $url);


    }

    public function run()
    {


        $this->model->run();
    }







}
