<?php

class admin_country_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_country()
    {
        parent::__construct();
        $type = 0;
        $data = $this->db->prepare("CALL get_country(?)");
        $data->bindParam(1, $type);

        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        // echo "<pre>";
        // print_r($result);
        // die;
        return $result;
    }

    public function add_country()
    {
        if (!empty($_POST["countryName"]) && !empty($_POST["dial_code"]) && !empty($_POST["isoCode"])) {
            parent::__construct();
            $type=1;
            $data = $this->db->prepare("CALL check_country(?,?,?)");
            $data->bindParam(1, $_POST["countryName"]);
            $data->bindParam(2, $_POST["isoCode"]);
            $data->bindParam(3, $_POST["dial_code"]);
            $data->execute();
            $country_data = $data->fetchAll(PDO::FETCH_ASSOC);

            if (sizeof($country_data) > 0) {
                if(array_search(ucwords($_POST["countryName"]), array_column($country_data, "country_name")) != 0) {
                    Session::set("danger", "Same country registered with given country name.");
                    header("location: " . URL . admin_link . "/country");
                    exit;
                }
                if(array_search($_POST["dial_code"], array_column($country_data, "dial_code")) != 0) {
                    Session::set("danger", "Same dial code registered with given country name.");
                    header("location: " . URL . admin_link . "/country");
                    exit;
                }
                if(array_search(strtoupper($_POST["isoCode"]), array_column($country_data, "code")) != 0) {
                    Session::set("danger", "Same ISO code registered with given country name.");
                    header("location: " . URL . admin_link . "/country");
                    exit;
                }
            } else {
                // Add Country details

                parent::__construct();
                $add_country = $this->db->prepare("CALL add_country(?,?,?)");
                $add_country->bindParam(1, ucwords($_POST["countryName"]));
                $add_country->bindParam(2, strtoupper($_POST["isoCode"]));
                $add_country->bindParam(3, $_POST["dial_code"]);
                $add_country_result = $add_country->execute();

                if ($add_country_result) {
                    Session::set('success', "Country successfully added.");
                    header("location: " . URL . admin_link . "/country");
                    exit;
                } else {
                    Session::set('danger', "Add country failed. Try Again! ".$add_country->errorInfo()[2]);
                    header("location: " . URL . admin_link . "/country");
                    exit;
                }
            }
        } else {
            Session::set('danger', "Please provide all the necessary details.");
            header("location: " . URL . admin_link . "/country");
            exit;
        }
    }

    public function edit_country_data()
    {
        $error = [];
        if (!empty($_POST["cid"]) && !empty($_POST["country"]) && !empty($_POST["code"]) && !empty($_POST["iso_code"])) {
            $c_id = parent::decrypt_string($_POST["cid"]);

            parent::__construct();
            $type=1;
            $data = $this->db->prepare("CALL check_country(?,?,?)");
            $data->bindParam(1, $_POST["country"]);
            $data->bindParam(2, $_POST["iso_code"]);
            $data->bindParam(3, $_POST["code"]);
            $data->execute();

            $country_data = $data->fetchAll(PDO::FETCH_ASSOC);

            $filtered_data = array_filter($country_data, function ($ele) use ($c_id) {
                return $ele['id'] != $c_id;
            });

            if (count($filtered_data) > 0) {
                if(array_search(ucwords($_POST["country"]), array_column($country_data, "country_name")) != 0) {
                    array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Same country registered with given country name."]);
                    echo json_encode($error);
                    exit;
                }
                if(array_search($_POST["code"], array_column($country_data, "dial_code")) != 0) {
                    array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Same dial code registered with given country name."]);
                    echo json_encode($error);
                    exit;
                }
                if(array_search(strtoupper($_POST["iso_code"]), array_column($country_data, "code")) != 0) {
                    array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Same ISO code registered with given country name."]);
                    echo json_encode($error);
                    exit;
                }
            } else {
                // Update Country details
                parent::__construct();
                $c_name = ucwords($_POST["country"]);
                $iso_code = strtoupper($_POST["iso_code"]);
                $update_country = $this->db->prepare("CALL update_country(?,?,?,?)");
                $update_country->bindParam(1, $c_id);
                $update_country->bindParam(2, $c_name);
                $update_country->bindParam(3, $iso_code);
                $update_country->bindParam(4, $_POST["code"]);
                $update_country_result = $update_country->execute();

                if ($update_country_result) {
                    array_push($error, ["data"=>"","etype"=>"success", "msg"=>"Country successfully updated."]);
                    echo json_encode($error);
                    exit;
                } else {
                    array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Update country failed. Try Again! ".$update_country->errorInfo()[2]]);
                    echo json_encode($error);
                    exit;
                }
            }
        } else {
            array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function change_country_status()
    {
        if(isset($_POST['msg']) && isset($_POST['type']) && isset($_POST['cname'])) {
            if (!empty($_POST['msg'])) {
                if (strtolower($_POST['msg'])!='yes') {
                    Session::set('danger', 'Please Enter Right Text.');
                    header("Location: " . URL . admin_link . "/country");
                    die;
                }
            } else {
                Session::set('danger', 'Please Type Something.');
                header("Location: " . URL . admin_link . "/country");
                die;
            }

            if(($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['cname'])) {
                parent::__construct();
                $country_name = parent::decrypt_string($_POST['cname']);

                if($_POST['type'] == 1) {
                    $status = 0;
                    $success_msg = 'Country has been successfully activated.';
                    $error_msg = 'Could not activate country.';
                }

                if($_POST['type'] == 2) {
                    $status = 1;
                    $success_msg = 'Country has been successfully deleted.';
                    $error_msg = 'Could not delete country.';
                }

                $data = $this->db->prepare("CALL update_country_status(?,?)");
                $data->bindParam(1, $country_name);
                $data->bindParam(2, $status);

                $result = $data->execute();
                if ($result) {
                    Session::set('success', $success_msg);
                    header("Location: " . URL . admin_link . "/country");
                    die;
                } else {
                    Session::set('danger', $error_msg);
                    header("Location: " . URL . admin_link . "/country");
                    die;
                }
            } else {
                Session::set('danger', 'Data authentication failed.');
                header("Location: " . URL . admin_link . "/country");
                die;
            }
        } else {
            Session::set('danger', 'Data authentication failed.');
            header("Location: " . URL . admin_link . "/country");
            die;
        }
    }
}
