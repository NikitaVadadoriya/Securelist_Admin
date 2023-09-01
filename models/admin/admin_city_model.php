<?php

class admin_city_Model extends Model
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

        // echo "<pre>";
        // print_r($result);
        // die;
        return $result;
    }

    public function get_state_data()
    {
        $error = [];
        if ($_POST['country_name']) {

            parent::__construct();

            $type = 2;
            $state_name = '';
            $data = $this->db->prepare("CALL get_states(?,?,?)");
            $data->bindParam(1, $type);
            $data->bindParam(2, $_POST['country_name']);
            $data->bindParam(3, $state_name);

            $data->execute();
            $result = $data->fetchAll(PDO::FETCH_ASSOC);

            // echo "<pre>";
            // print_r($result);
            // die;

            array_push($error, ["data" => $result, "etype" => "success", "msg" => "Data fetched successfully."]);
            echo json_encode($error);
            exit;
        } else {
            array_push($error, ["data" => "", "etype" => "danger", "msg" => "Please select country first."]);
            echo json_encode($error);
            exit;
        }
    }

    public function get_city()
    {
        $error = [];

        if ($_POST['state_name']) {
            parent::__construct();

            $type = 2;
            $city_name = '';
            $state_name = $_POST['state_name'];
            $data = $this->db->prepare("CALL get_cities(?,?,?)");
            $data->bindParam(1, $type);
            $data->bindParam(2, $city_name);
            $data->bindParam(3, $state_name);

            $data->execute();
            $result = $data->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $result[$i]['id'] = parent::encrypt_string($result[$i]['id']);
                    $cname = parent::encrypt_string($result[$i]['city_name']);
                    $result[$i]['cname'] = $cname;
                }
            }

            array_push($error, ["data" => $result, "etype" => "success", "msg" => "Data fetched successfully."]);
            echo json_encode($error);
            exit;
        } else {
            array_push($error, ["data" => "", "etype" => "danger", "msg" => "Please select state first."]);
            echo json_encode($error);
            exit;
        }
    }

    public function add_city()
    {
        $error = [];
        // echo "<pre>";
        // print_r(json_encode($_POST["countryName"]));
        // die;
        if (!empty($_POST["countryName"]) && !empty($_POST["stateName"]) && !empty($_POST["cityName"])) {
            parent::__construct();
            $type = 1;
            $data = $this->db->prepare("CALL check_city(?,?)");
            $data->bindParam(1, $_POST["stateName"]);
            $data->bindParam(2, $_POST["cityName"]);
            $data->execute();
            $city_data = $data->fetch(PDO::FETCH_ASSOC);

            if ($city_data) {
                array_push($error, ["data" => "", "etype" => "danger", "msg" => "Same city registered with given city name."]);
                echo json_encode($error);
                exit;
            } else {
                // Add Country details
                parent::__construct();
                $add_city = $this->db->prepare("CALL add_city(?,?)");

                $cityName = ucwords($_POST["cityName"]);
                $stateName = ucwords($_POST["stateName"]);

                $add_city->bindParam(1, $cityName);
                $add_city->bindParam(2, $stateName);
                $add_city_result = $add_city->execute();

                if ($add_city_result) {

                    array_push($error, ["data" => "", "etype" => "success", "msg" => "City successfully added."]);
                    echo json_encode($error);
                    exit;
                } else {
                    array_push($error, ["data" => "", "etype" => "danger", "msg" => "Add city failed. Try Again!" . $add_city->errorInfo()[2]]);
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

    public function edit_city_data()
    {
        $error = [];
        if (!empty($_POST["cid"]) && !empty($_POST["state"]) && !empty($_POST["city"])) {
            $c_id = parent::decrypt_string($_POST["cid"]);

            parent::__construct();
            $type = 1;
            $data = $this->db->prepare("CALL check_city(?,?)");
            $data->bindParam(1, $_POST["state"]);
            $data->bindParam(2, $_POST["city"]);
            $data->execute();

            $city_data = $data->fetch(PDO::FETCH_ASSOC);

            if (isset($city_data['id']) && $city_data['id'] != $c_id) {
                array_push($error, ["data" => "", "etype" => "danger", "msg" => "Same city registered with given city name."]);
                echo json_encode($error);
                exit;
            } else {
                // Update Country details
                parent::__construct();
                $c_name = ucwords($_POST["city"]);

                $update_city = $this->db->prepare("CALL update_city(?,?)");
                $update_city->bindParam(1, $c_id);
                $update_city->bindParam(2, $c_name);

                $update_city_result = $update_city->execute();

                if ($update_city_result) {
                    array_push($error, ["data" => "", "etype" => "success", "msg" => "City name successfully updated."]);
                    echo json_encode($error);
                    exit;
                } else {
                    array_push($error, ["data" => "", "etype" => "danger", "msg" => "Update city name failed. Try Again! " . $update_city->errorInfo()[2]]);
                    echo json_encode($error);
                    exit;
                }
            }
        } else {
            array_push($error, ["data" => "", "icon" => "slash-circle", "shout" => "Error!", "etype" => "danger", "msg" => "Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function change_city_status()
    {
        $error = [];
        if (isset($_POST['msg']) && isset($_POST['type']) && isset($_POST['cname'])) {
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

            if (($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['cname'])) {
                parent::__construct();
                $city_name = parent::decrypt_string($_POST["cname"]);

                if ($_POST['type'] == 1) {
                    $status = 0;
                    $success_msg = 'City has been successfully activated.';
                    $error_msg = 'Could not activate city.';
                }

                if ($_POST['type'] == 2) {
                    $status = 1;
                    $success_msg = 'City has been successfully deleted.';
                    $error_msg = 'Could not delete city.';
                }

                $data = $this->db->prepare("CALL update_city_status(?,?)");
                $data->bindParam(1, $city_name);
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
