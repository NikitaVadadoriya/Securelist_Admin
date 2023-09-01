<?php

class admin_user_requests_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_users($qry_string = '')
    {
        parent::__construct();
        $data = $this->db->prepare("CALL get_users_data(?)");
        $data->bindParam(1, $qry_string);
        $data->execute();

        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) > 0) {
            for($i=0; $i < count($result); $i++) {
                $result[$i]['id'] = parent::encrypt_string($result[$i]['id']);
            }
        }

        return $result;
    }

    public function get_sub_categories()
    {
        $type=0;
        $sub_cat_name='';
        parent::__construct();
        $data = $this->db->prepare("Call get_sub_categories(?,?)");
        $data->bindParam(1, $type);
        $data->bindParam(2, $sub_cat_name);
        $data->execute();

        $data_result = $data->fetchALL(PDO::FETCH_ASSOC);

        return $data_result;
    }

    public function fetch_data($qry_string = '')
    {
        parent::__construct();
        $data = $this->db->prepare("CALL get_user_requests(?)");
        $data->bindParam(1, $qry_string);

        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        for($i = 0; $i < count($result); $i++) {
            $result[$i]['id'] = parent::encrypt_string($result[$i]['id']);
        }

        // echo "<pre>";
        // print_r($result);
        // die;
        return $result;
    }

    public function get_today_requests()
    {
        $qry_string = " WHERE DATE(ur.updatedAt) = CURDATE()";

        $data_result = $this->fetch_data($qry_string);
        return $data_result;
    }

    public function get_request_data()
    {
        $error = [];

        if((isset($_POST['user_id']) && !empty($_POST['user_id'])) || (isset($_POST['sub_cat_id']) && !empty($_POST['sub_cat_id'])) || (isset($_POST['date_range']) && !empty($_POST['date_range']))) {
            $exploded_range = explode('to', $_POST['date_range']);
            $start_date = trim($exploded_range[0]);
            if(sizeof($exploded_range) > 1) {
                $end_date = trim($exploded_range[1]);
            } else {
                $end_date = '';
            }

            if(($_POST['user_id'] != 'All' && !empty($_POST['user_id'])) || ($_POST['sub_cat_id'] != 'All' && !empty($_POST['sub_cat_id'])) || $start_date) {
                $qry_string = " WHERE";
            } else {
                $qry_string = "";
            }

            if($_POST['user_id'] && !empty($_POST['user_id'])) {
                if($_POST['user_id'] != 'All') {
                    if($start_date) {
                        $qry_string .= " ur.user_id='".parent::decrypt_string($_POST['user_id'])."' AND";
                    } else {
                        if(!empty($_POST['sub_cat_id']) && $_POST['sub_cat_id'] != 'All') {
                            $qry_string .= " ur.user_id='".parent::decrypt_string($_POST['user_id'])."' AND";
                        } else {
                            $qry_string .= " ur.user_id='".parent::decrypt_string($_POST['user_id'])."' ";
                        }
                    }
                }
            }

            if($_POST['sub_cat_id'] && !empty($_POST['sub_cat_id'])) {
                if($_POST['sub_cat_id'] != 'All') {
                    if($start_date) {
                        $qry_string .= " ur.business_type_id='".parent::decrypt_string($_POST['sub_cat_id'])."' AND";
                    } else {
                        $qry_string .= " ur.business_type_id='".parent::decrypt_string($_POST['sub_cat_id'])."' ";
                    }
                }
            }

            if($start_date && $end_date) {
                $qry_string .= " ur.createdAt BETWEEN '".$start_date."' AND '".$end_date."'";
            } elseif ($start_date && !$end_date) {
                $qry_string.= " DATE(ur.createdAt)='".$start_date."'";
            }

            $data_result = $this->fetch_data($qry_string);

            array_push($error, ["data"=>$data_result, "etype"=>"success", "msg"=>"Data fetched successfully."]);
            echo json_encode($error);
            exit;
        } else {
            array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function get_business_list_data()
    {
        $error = [];
        if(isset($_POST['request_id']) && !empty($_POST['request_id']) && isset($_POST['status']) && ($_POST['status'] == 1 || $_POST['status'] == 2)) {
            $request_id = parent::decrypt_string($_POST['request_id']);
            parent::__construct();
            $data = $this->db->prepare("CALL get_business_list_by_request(?,?)");
            $data->bindParam(1, $request_id);
            $data->bindParam(2, $_POST['status']);

            $result = $data->execute();

            if($result) {
                array_push($error, ["data"=>$data->fetchAll(PDO::FETCH_ASSOC),"etype"=>"success", "msg"=>"Data fetched successfully."]);
                echo json_encode($error);
                exit;
            } else {
                array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Something went wrong. Try Again! ".$data->errorInfo()[2]]);
                echo json_encode($error);
                exit;
            }
            return $result;
        } else {
            array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function get_request_qa_data()
    {
        $error = [];
        if(isset($_POST['request_id']) && !empty($_POST['request_id'])) {
            $request_id = parent::decrypt_string($_POST['request_id']);
            parent::__construct();
            $data = $this->db->prepare("CALL get_request_question_ans(?)");
            $data->bindParam(1, $request_id);
            $result = $data->execute();

            if($result) {
                array_push($error, ["data"=>$data->fetchAll(PDO::FETCH_ASSOC),"etype"=>"success", "msg"=>"Data fetched successfully."]);
                echo json_encode($error);
                exit;
            } else {
                array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Something went wrong. Try Again! ".$data->errorInfo()[2]]);
                echo json_encode($error);
                exit;
            }
            return $result;
        } else {
            array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }
}
