<?php

class admin_kyc_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_business_list()
    {

        $type = 0;
        $data = $this->db->prepare("CALL get_business_list(?)");
        $data->bindParam(1, $type);
        $data->execute();

        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function fetch_data($qry_string, $type)
    {
        parent::__construct();
        $data = $this->db->prepare("CALL get_kyc_details(?, ?)");
        $data->bindParam(1, $qry_string);
        $data->bindParam(2, $type);
        $data->execute();
        $data_result = $data->fetchAll(PDO::FETCH_ASSOC);

        if(count($data_result) > 0) {
            for($i=0; $i < count($data_result); $i++) {
                $data_result[$i]['id'] = parent::encrypt_string($data_result[$i]['id']);
                $data_result[$i]['business_id'] = parent::encrypt_string($data_result[$i]['business_id']);
            }
        }
        // echo '<pre>';
        // print_r($data_result);
        // die;
        return $data_result;
    }

    public function get_today_all_request()
    {
        $action = $_GET['url'];
        $url = explode('/', $action);

        // $qry_string = " WHERE DATE(k.updatedAt) = CURDATE()";
        if(isset($url[2]) && $url[2] == 'pending') {
            $type = 1;
            $qry_string = " WHERE DATE(k.updatedAt) = CURDATE() AND k.is_approved=0 ";
            // $qry_string .= " AND k.is_approved=0 ";
        } else {
            $qry_string = " WHERE DATE(k.createdAt) = CURDATE()";
            $type = 0;
        }
        $data_result = $this->fetch_data($qry_string, $type);
        return $data_result;
    }

    public function get_request_data()
    {
        $error = [];
        if((isset($_POST['business_id']) && !empty($_POST['business_id'])) || (isset($_POST['date_range']) && !empty($_POST['date_range']))) {
            $exploded_range = explode('to', $_POST['date_range']);
            $start_date = trim($exploded_range[0]);
            if(sizeof($exploded_range) > 1) {
                $end_date = trim($exploded_range[1]);
            } else {
                $end_date = '';
            }

            if($_POST['business_id'] != 'All' || $start_date) {
                $qry_string = " WHERE";
            } else {
                $qry_string = "";
            }

            if($_POST['business_id'] && !empty($_POST['business_id'])) {
                if($_POST['business_id'] != 'All') {
                    if($start_date) {
                        $qry_string .= " k.business_id='".parent::decrypt_string($_POST['business_id'])."' AND";
                    } else {
                        $qry_string .= " k.business_id='".parent::decrypt_string($_POST['business_id'])."' ";
                    }
                }
            }

            if($start_date && $end_date) {
                if($_POST['is_pending'] == 'true') {
                    $qry_string .= " k.updatedAt BETWEEN '".$start_date."' AND '".$end_date."'";
                } else {
                    $qry_string .= " k.createdAt BETWEEN '".$start_date."' AND '".$end_date."'";
                }
            } elseif ($start_date && !$end_date) {
                if($_POST['is_pending'] == 'true') {
                    $qry_string.= " DATE(k.updatedAt)='".$start_date."'";
                } else {
                    $qry_string.= " DATE(k.createdAt)='".$start_date."'";
                }
            }

            if($_POST['is_pending'] == 'true') {
                $type = 1;
                $qry_string .= " AND k.is_approved=0 ";
            } else {
                $type = 0;
            }

            $data_result = $this->fetch_data($qry_string, $type);

            array_push($error, ["data"=>$data_result, "etype"=>"success", "msg"=>"Data fetched successfully."]);
            echo json_encode($error);
            exit;
        } else {
            array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function get_reject_reasons()
    {
        $type= 1;
        $reason_name='';
        parent::__construct();
        $data = $this->db->prepare("CALL get_reject_reasons(?,?)");
        $data->bindParam(1, $type);
        $data->bindParam(2, $reason_name);
        $data->execute();
        $data_result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $data_result;
    }

    public function approve_kyc()
    {
        if(!empty($_POST['kid']) && !empty($_POST['bid'])) {
            $this->change_kyc_status($_POST['kid'], $_POST['bid'], 1, 0);
        } else {
            Session::set('danger', 'Data authentication failed.');
            header("Location: " . URL . admin_link . "/kyc/pending");
            die;
        }
    }

    public function reject_kyc()
    {
        if(isset($_POST['msg']) && isset($_POST['kyc_id']) && isset($_POST['biz_id']) && isset($_POST['reject_reason'])) {
            if (!empty($_POST['msg'])) {
                if (strtolower($_POST['msg'])!='yes') {
                    Session::set('danger', 'Please Enter Right Text.');
                    header("Location: " . URL . admin_link . "/kyc/pending");
                    die;
                }
            } elseif (!$_POST['reject_reason']) {
                Session::set('danger', 'Please select reject reason.');
                header("Location: " . URL . admin_link . "/kyc/pending");
                die;

            } else {
                Session::set('danger', 'Please Type Something.');
                header("Location: " . URL . admin_link . "/kyc/pending");
                die;
            }

            $this->change_kyc_status($_POST['kyc_id'], $_POST['biz_id'], 2, parent::decrypt_string($_POST['reject_reason']));

        } else {
            Session::set('danger', 'Please provide valid data.');
            header("Location: " . URL . admin_link . "/kyc/pending");
            die;
        }
    }

    public function change_kyc_status($kyc_id, $business_id, $status, $reject_reason)
    {
        $user_id = parent::decrypt_string(parent::decrypt_admin_data("admin_id"));
        $kyc_id = parent::decrypt_string($kyc_id);
        $business_id = parent::decrypt_string($business_id);

        parent::__construct();
        $data = $this->db->prepare("CALL update_kyc_status(?,?,?,?,?)");
        $data->bindParam(1, $kyc_id);
        $data->bindParam(2, $business_id);
        $data->bindParam(3, $status);
        $data->bindParam(4, $user_id);
        $data->bindParam(5, $reject_reason);

        $result = $data->execute();

        if($status == 2) {
            $success = "Kyc Rejected successfully.";
            $error = "Reject kyc failed. Try Again! ".$data->errorInfo()[2];
        }

        if($status == 1) {
            $success = "Kyc approved successfully.";
            $error = "Approve kyc failed. Try Again! ".$data->errorInfo()[2];
        }

        if ($result) {
            Session::set('success', $success);
            header("Location: " . URL . admin_link . "/kyc/pending");
            die;
        } else {
            Session::set('danger', $error);
            header("Location: " . URL . admin_link . "/kyc/pending");
            die;
        }
    }
}
