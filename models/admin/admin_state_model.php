<?php

class admin_state_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_country()
    {
        parent::__construct();
        $type = 1;
        $data = $this->db->prepare("CALL get_country(?)");
        $data->bindParam(1, $type);

        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_state()
    {
        $error = [];

        if ($_POST['country_name']) {
            parent::__construct();

            $type = 3;
            $country_name = $_POST['country_name'];
            $state_name = '';
            $data = $this->db->prepare("CALL get_states(?,?,?)");
            $data->bindParam(1, $type);
            $data->bindParam(2, $country_name);
            $data->bindParam(3, $state_name);

            $data->execute();
            $result = $data->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $result[$i]['id'] = parent::encrypt_string($result[$i]['id']);
                    $sname = parent::encrypt_string($result[$i]['state_name']);
                    $result[$i]['sname'] = $sname;
                }
            }

            array_push($error, ["data" => $result, "etype" => "success", "msg" => "Data fetched successfully."]);
            echo json_encode($error);
            exit;
        } else {
            array_push($error, ["data" => "", "etype" => "danger", "msg" => "Please select country first."]);
            echo json_encode($error);
            exit;
        }

    }

    public function add_state()
    {
        $error = [];
        if (!empty($_POST["countryName"]) && !empty($_POST["stateName"])) {
            parent::__construct();
            $type = 1;
            $data = $this->db->prepare("CALL check_state(?,?)");
            $data->bindParam(1, $_POST["stateName"]);
            $data->bindParam(2, $_POST["countryName"]);
            $data->execute();
            $state_data = $data->fetch(PDO::FETCH_ASSOC);

            if ($state_data) {
                array_push($error, ["data" => "", "etype" => "danger", "msg" => "Same state registered with given state name."]);
                echo json_encode($error);
                exit;
            } else {
                // Add Country details
                parent::__construct();
                $add_state = $this->db->prepare("CALL add_state(?,?)");

                $countryName = ucwords($_POST["countryName"]);
                $stateName = ucwords($_POST["stateName"]);

                $add_state->bindParam(1, $stateName);
                $add_state->bindParam(2, $countryName);
                $add_state_result = $add_state->execute();

                if ($add_state_result) {
                    array_push($error, ["data" => "", "etype" => "success", "msg" => "State successfully added."]);
                    echo json_encode($error);
                    exit;
                } else {
                    array_push($error, ["data" => "", "etype" => "danger", "msg" => "Add state failed. Try Again! " ] . $add_state->errorInfo()[2]);
                    echo json_encode($error);
                    exit;
                }
            }
        } else {
            array_push($error, ["data" => "", "etype" => "danger", "msg" => "Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function edit_state_data()
    {
        $error = [];
        if (!empty($_POST["sid"]) && !empty($_POST["country"]) && !empty($_POST["state"])) {
            $s_id = parent::decrypt_string($_POST["sid"]);

            parent::__construct();
            $type = 1;
            $data = $this->db->prepare("CALL check_state(?,?)");
            $data->bindParam(1, $_POST["state"]);
            $data->bindParam(2, $_POST["country"]);
            $data->execute();

            $state_data = $data->fetch(PDO::FETCH_ASSOC);

            if (isset($state_data['id']) && $state_data['id'] != $s_id) {
                array_push($error, ["data" => "", "etype" => "danger", "msg" => "Same state registered with given state name."]);
                echo json_encode($error);
                exit;
            } else {
                // Update Country details
                parent::__construct();
                $s_name = ucwords($_POST["state"]);

                $update_state = $this->db->prepare("CALL update_state(?,?)");
                $update_state->bindParam(1, $s_id);
                $update_state->bindParam(2, $s_name);

                $update_state_result = $update_state->execute();

                if ($update_state_result) {
                    array_push($error, ["data" => "", "etype" => "success", "msg" => "State name successfully updated."]);
                    echo json_encode($error);
                    exit;
                } else {
                    array_push($error, ["data" => "", "etype" => "danger", "msg" => "Update state name failed. Try Again! " . $update_state->errorInfo()[2]]);
                    echo json_encode($error);
                    exit;
                }
            }
        } else {
            array_push($error, ["data" => "", "etype" => "danger", "msg" => "Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function change_state_status()
    {
        $error = [];
        if (isset($_POST['msg']) && isset($_POST['type']) && isset($_POST['sname'])) {
            if (!empty($_POST['msg'])) {
                if (strtolower($_POST['msg']) != 'yes') {
                    array_push($error, ["data" => "", "etype" => "danger", "msg" => "Please Enter Right Text."]);
                    echo json_encode($error);
                    exit;
                }
            } else {
                array_push($error, ["data" => "", "etype" => "danger", "msg" => "Please Type Something."]);
                echo json_encode($error);
                exit;
            }

            if (($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['sname'])) {

                parent::__construct();
                $state_name = parent::decrypt_string($_POST["sname"]);

                if ($_POST['type'] == 1) {
                    $status = 0;
                    $success_msg = 'State has been successfully activated.';
                    $error_msg = 'Could not activate state.';
                }

                if ($_POST['type'] == 2) {
                    $status = 1;
                    $success_msg = 'State has been successfully deleted.';
                    $error_msg = 'Could not delete state.';
                }

                $data = $this->db->prepare("CALL update_state_status(?,?)");
                $data->bindParam(1, $state_name);
                $data->bindParam(2, $status);

                $result = $data->execute();
                if ($result) {
                    array_push($error, ["data" => "", "etype" => "success", "msg" => $success_msg]);
                    echo json_encode($error);
                    exit;
                } else {
                    array_push($error, ["data" => "", "etype" => "danger", "msg" => $error_msg]);
                    echo json_encode($error);
                    exit;
                }
            } else {
                array_push($error, ["data" => "", "etype" => "danger", "msg" => "Data authentication failed."]);
                echo json_encode($error);
                exit;
            }
        } else {
            array_push($error, ["data" => "", "etype" => "danger", "msg" => "Data authentication failed."]);
            echo json_encode($error);
            exit;
        }
    }
}
