<?php

class admin_business_Model extends Model
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

        // echo '<pre>';
        // print_r($result);
        // exit;

        return $result;
    }

    public function fetch_data($qry_string = '')
    {
        parent::__construct();
        $data = $this->db->prepare("CALL get_business_data(?)");
        $data->bindParam(1, $qry_string);

        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) > 0) {
            for($i = 0; $i < count($result); $i++) {
                $result[$i]['id'] = parent::encrypt_string($result[$i]['id']);
            }
        }

        // echo '<pre>';
        // print_r($result);
        // exit;

        return $result;
    }

    public function get_today_data()
    {
        $qry_string = " WHERE DATE(b.createdAt) = CURDATE()";

        $data_result = $this->fetch_data($qry_string);
        return $data_result;
    }

    public function get_data()
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
                        $qry_string .= " b.id='".parent::decrypt_string($_POST['business_id'])."' AND";
                    } else {
                        $qry_string .= " b.id='".parent::decrypt_string($_POST['business_id'])."' ";
                    }
                }
            }

            if($start_date && $end_date) {
                $qry_string .= " b.createdAt BETWEEN '".$start_date."' AND '".$end_date."'";
            } elseif ($start_date && !$end_date) {
                $qry_string.= " DATE(b.createdAt)='".$start_date."'";
            }

            $biz_data_result = $this->fetch_data($qry_string);
            // $biz_data_result['query'] = $qry_string;
            array_push($error, ["data"=>$biz_data_result, "etype"=>"success", "msg"=>"Data fetched successfully."]);
            echo json_encode($error, JSON_PARTIAL_OUTPUT_ON_ERROR);
            exit;

        } else {
            array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }


    public function change_user_status()
    {
        if(isset($_POST['msg']) && isset($_POST['type']) && isset($_POST['id'])) {
            if (!empty($_POST['msg'])) {
                if (strtolower($_POST['msg'])!='yes') {
                    Session::set('danger', 'Please Enter Right Text.');
                    header("Location: " . URL . admin_link . "/business");
                    die;
                }
            } else {
                Session::set('danger', 'Please Type Something.');
                header("Location: " . URL . admin_link . "/business");
                die;
            }

            if(($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['id'])) {
                parent::__construct();
                $user_id = parent::decrypt_string($_POST['id']);
                $type = 2; // 1 = user_info; 2 = business_info
                if($_POST['type'] == 1) {
                    $status = 0;
                    $success_msg = 'User has been successfully activated.';
                    $error_msg = 'Could not activate user.';
                }

                if($_POST['type'] == 2) {
                    $status = 1;
                    $success_msg = 'User has been successfully blocked.';
                    $error_msg = 'Could not block user.';
                }

                $data = $this->db->prepare("CALL update_user_status(?,?,?)");
                $data->bindParam(1, $type);
                $data->bindParam(2, $status);
                $data->bindParam(3, $user_id);

                $result = $data->execute();
                if ($result) {
                    Session::set('success', $success_msg);
                    header("Location: " . URL . admin_link . "/business");
                    die;
                } else {
                    Session::set('danger', $error_msg);
                    header("Location: " . URL . admin_link . "/business");
                    die;
                }
            } else {
                Session::set('danger', 'Data authentication failed.');
                header("Location: " . URL . admin_link . "/business");
                die;
            }
        } else {
            Session::set('danger', 'Data authentication failed.');
            header("Location: " . URL . admin_link . "/business");
            die;
        }
    }
}
