<?php

class admin_users_Model extends Model
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

    public function get_today_all_request()
    {
        $qry_string = " WHERE DATE(u.createdAt) = CURDATE()";

        $data_result = $this->get_all_users($qry_string);
        return $data_result;
    }

    public function get_users_data()
    {
        $error = [];
        if((isset($_POST['user_id']) && !empty($_POST['user_id'])) || (isset($_POST['date_range']) && !empty($_POST['date_range']))) {
            $exploded_range = explode('to', $_POST['date_range']);
            $start_date = trim($exploded_range[0]);
            if(sizeof($exploded_range) > 1) {
                $end_date = trim($exploded_range[1]);
            } else {
                $end_date = '';
            }

            if($_POST['user_id'] != 'All' || $start_date) {
                $qry_string = " WHERE";
            } else {
                $qry_string = "";
            }

            if($_POST['user_id'] && !empty($_POST['user_id'])) {
                if($_POST['user_id'] != 'All') {
                    if($start_date) {
                        $qry_string .= " u.id='".parent::decrypt_string($_POST['user_id'])."' AND";
                    } else {
                        $qry_string .= " u.id='".parent::decrypt_string($_POST['user_id'])."' ";
                    }
                }
            }

            if($start_date && $end_date) {
                $qry_string .= " u.createdAt BETWEEN '".$start_date."' AND '".$end_date."'";
            } elseif ($start_date && !$end_date) {
                $qry_string.= " DATE(u.createdAt) = '".$start_date."'";
            }

            $data_result = $this->get_all_users($qry_string);

            array_push($error, ["data"=>$data_result, "etype"=>"success", "msg"=>"Data fetched successfully."]);
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
                    header("Location: " . URL . admin_link . "/users");
                    die;
                }
            } else {
                Session::set('danger', 'Please Type Something.');
                header("Location: " . URL . admin_link . "/users");
                die;
            }

            if(($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['id'])) {
                parent::__construct();
                $user_id = parent::decrypt_string($_POST['id']);
                $type = 1; // 1 = user_info; 2 = business_info
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
                    header("Location: " . URL . admin_link . "/users");
                    die;
                } else {
                    Session::set('danger', $error_msg);
                    header("Location: " . URL . admin_link . "/users");
                    die;
                }
            } else {
                Session::set('danger', 'Data authentication failed.');
                header("Location: " . URL . admin_link . "/users");
                die;
            }
        } else {
            Session::set('danger', 'Data authentication failed.');
            header("Location: " . URL . admin_link . "/users");
            die;
        }
    }
}
