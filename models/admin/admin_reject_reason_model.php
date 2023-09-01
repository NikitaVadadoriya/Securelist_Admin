<?php

class admin_reject_reason_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_reject_reason()
    {
        $type=0;
        $reject_reason_name='';
        parent::__construct();
        $data = $this->db->prepare("Call get_reject_reasons(?,?)");
        $data->bindParam(1, $type);
        $data->bindParam(2, $reject_reason_name);
        $data->execute();

        $data_result = $data->fetchALL(PDO::FETCH_ASSOC);
        // echo "<pre>";
        // print_r($data_result);
        // die;
        return $data_result;
    }

    public function add_reject_reason()
    {
        if(isset($_POST['rejectReason']) && !empty($_POST['rejectReason'])) {
            if(preg_match("/^[a-zA-Z(),\s\/-]+$/", $_POST['rejectReason'])) {
                $type=2;
                parent::__construct();
                $data = $this->db->prepare("Call get_reject_reasons(?,?)");
                $data->bindParam(1, $type);
                $data->bindParam(2, $_POST['rejectReason']);
                $data->execute();

                $data_result = $data->fetch(PDO::FETCH_ASSOC);

                if($data_result) {
                    Session::set('danger', 'Reject reason already exists.');
                    header("Location: " . URL . admin_link . "/reject_reason");
                    die;
                } else {
                    parent::__construct();
                    $add_sub_cat = $this->db->prepare("Call add_reject_reason(?)");
                    $add_sub_cat->bindParam(1, $_POST['rejectReason']);
                    $add_sub_cat->execute();

                    if ($add_sub_cat) {
                        Session::set("success", "Reject reason successfully added.");
                        header("location: " . URL . admin_link . "/reject_reason");
                        exit;
                    } else {
                        Session::set('danger', "Add reject reason failed. Try Again! ".$add_sub_cat->errorInfo()[2]);
                        header("location: " . URL . admin_link . "/reject_reason");
                        exit;
                    }
                }
            } else {
                Session::set('danger', 'Please enter valid reject reason.');
                header("Location: " . URL . admin_link . "/reject_reason");
                die;
            }
        } else {
            Session::set('danger', 'Reject reason must not be empty.');
            header("Location: " . URL . admin_link . "/reject_reason");
            die;
        }
    }

    public function edit_reject_reason()
    {
        $error = [];
        if (!empty($_POST["id"]) && !empty($_POST["reject_reason"])) {
            if(preg_match("/^[a-zA-Z(),\s\/-]+$/", $_POST['reject_reason'])) {
                $id = parent::decrypt_string($_POST["id"]);

                $type=2;
                parent::__construct();
                $data = $this->db->prepare("Call get_reject_reasons(?,?)");
                $data->bindParam(1, $type);
                $data->bindParam(2, $_POST['reject_reason']);
                $data->execute();

                $reject_reason_data = $data->fetch(PDO::FETCH_ASSOC);

                if(isset($reject_reason_data['id']) && $reject_reason_data['id'] != $id) {
                    array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Reject reason already exists."]);
                    echo json_encode($error);
                    exit;
                } else {
                    parent::__construct();
                    $type = 1;
                    $reject_reason = trim($_POST["reject_reason"]);
                    $status = 0;

                    $update_reject_reason = $this->db->prepare("CALL update_reject_reason(?,?,?,?)");
                    $update_reject_reason->bindParam(1, $type);
                    $update_reject_reason->bindParam(2, $id);
                    $update_reject_reason->bindParam(3, $reject_reason);
                    $update_reject_reason->bindParam(4, $status);

                    $update_reject_reason_result = $update_reject_reason->execute();

                    if ($update_reject_reason_result) {
                        array_push($error, ["data"=>"","etype"=>"success", "msg"=>"Reject reason successfully updated."]);
                        echo json_encode($error);
                        exit;
                    } else {
                        array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Update reject reason failed. Try Again! ".$update_reject_reason->errorInfo()[2]]);
                        echo json_encode($error);
                        exit;
                    }
                }
            } else {
                Session::set('danger', 'Please enter valid reject reason.');
                header("Location: " . URL . admin_link . "/reject_reason");
                die;
            }
        } else {
            array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Reject reason must not be empty."]);
            echo json_encode($error);
            exit;
        }
    }

    public function change_reject_reason_status()
    {
        if(isset($_POST['msg']) && isset($_POST['type']) && isset($_POST['id'])) {
            if (!empty($_POST['msg'])) {
                if (strtolower($_POST['msg']) != 'yes') {
                    Session::set('danger', 'Please Enter Right Text.');
                    header("Location: " . URL . admin_link . "/reject_reason");
                    die;
                }
            } else {
                Session::set('danger', 'Please Type Something.');
                header("Location: " . URL . admin_link . "/reject_reason");
                die;
            }

            if(($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['id'])) {
                if($_POST['type'] == 1) {
                    $status = 0;
                    $success_msg = 'Reject reason has been successfully activated.';
                    $error_msg = 'Could not activate reject reason.';
                }

                if($_POST['type'] == 2) {
                    $status = 1;
                    $success_msg = 'Reject reason has been successfully deleted.';
                    $error_msg = 'Could not delete reject reason.';
                }

                $type = 0;
                $id = parent::decrypt_string($_POST['id']);
                $reject_reason_name = '';
                parent::__construct();
                $data = $this->db->prepare("CALL update_reject_reason(?,?,?,?)");
                $data->bindParam(1, $type);
                $data->bindParam(2, $id);
                $data->bindParam(3, $reject_reason_name);
                $data->bindParam(4, $status);

                $result = $data->execute();
                if ($result) {
                    Session::set('success', $success_msg);
                    header("Location: " . URL . admin_link . "/reject_reason");
                    die;
                } else {
                    Session::set('danger', $error_msg);
                    header("Location: " . URL . admin_link . "/reject_reason");
                    die;
                }
            } else {
                Session::set('danger', 'Data authentication failed.');
                header("Location: " . URL . admin_link . "/reject_reason");
                die;
            }
        } else {
            Session::set('danger', 'Data authentication failed.');
            header("Location: " . URL . admin_link . "/reject_reason");
            die;
        }
    }
}
