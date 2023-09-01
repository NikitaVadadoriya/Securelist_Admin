<?php

class api_TeamLeader_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        if (isset($_POST["user_mail"])) {
            if (isset($_POST["user_pass"])) {
                $user_type = 1;
                $data = $this->db->prepare("CALL app_check_login(?)");
                $data->bindParam(1, $_POST["user_mail"]);
                $data->execute();
                $result = $data->fetch(PDO::FETCH_ASSOC);
                $existCount = $data->rowCount();

                if ($existCount > 0) {
                    $upass = $result["user_pass"];

                    include(server_root . '/public/API/pass/PasswordHash.php');
                    $t_hasher = new PasswordHash(8, true);
                    $check = $t_hasher->CheckPassword($_POST["user_pass"], $upass);

                    if ($check == 1) {
                        $data = $this->db->prepare("CALL app_get_user_data(?)");
                        $data->bindParam(1, $result["id"]);
                        $data->execute();
                        $result = $data->fetch(PDO::FETCH_ASSOC);

                        parent::api_resp(1, $result, "");
                    } else {
                        parent::api_resp(0, "danger", "Password Not Correct");
                    }
                } else {
                    parent::api_resp(0, "danger", "Please Provide Correct Email Address");
                }
            } else {
                parent::api_resp(0, "danger", "Please Provide User Pass");
            }
        } else {
            parent::api_resp(0, "danger", "Please Provide User Email Address");
        }
    }

    public function get_today_request()
    {
        if (isset($_POST["user_token"])) {
            if (isset($_POST["locality"]) && isset($_POST["user_type"])) {

                $data = $this->db->prepare("CALL get_today_request(?,?,?)");
                $data->bindParam(1, $_POST["user_token"]);
                $data->bindParam(2, $_POST["locality"]);
                $data->bindParam(3, $_POST["user_type"]);
                $data->execute();
                $result = $data->fetch(PDO::FETCH_ASSOC);
                $existCount = $data->rowCount();

                if ($existCount > 0) {

                    parent::api_resp(1, $result, "");

                } else {
                    parent::api_resp(1, "No Data Avilable", "");
                }
            } else {
                parent::api_resp(0, "danger", "Please Provide All Data");
            }
        } else {
            parent::api_resp(0, "danger", "Please Provide User Token");
        }
    }

    public function assing_request()
    {
        if (isset($_POST["user_token"])) {
            if (isset($_POST["Assinged_to"]) && isset($_POST["request_id"])) {

                $data = $this->db->prepare("CALL assign_request(?,?,?)");
                $data->bindParam(1, $_POST["user_token"]);
                $data->bindParam(2, $_POST["Assinged_to"]);
                $data->bindParam(3, $_POST["request_id"]);
                $data->execute();
                $result = $data->fetch(PDO::FETCH_ASSOC);
                $existCount = $data->rowCount();

                if ($data) {

                    parent::api_resp(1, $result, "");

                } else {
                    parent::api_resp(1, "Something Went Wrong Try Again", "");
                }
            } else {
                parent::api_resp(0, "danger", "Please Provide All Data");
            }
        } else {
            parent::api_resp(0, "danger", "Please Provide User Token");
        }
    }

    public function get_today_request_info()
    {
        if (isset($_POST["user_token"])) {
            if (isset($_POST["locality"]) && isset($_POST["user_type"])) {

                $data = $this->db->prepare("CALL get_today_request(?,?,?)");
                $data->bindParam(1, $_POST["user_token"]);
                $data->bindParam(2, $_POST["locality"]);
                $data->bindParam(3, $_POST["user_type"]);
                $data->execute();
                $result = $data->fetch(PDO::FETCH_ASSOC);
                $existCount = $data->rowCount();

                if ($existCount > 0) {

                    parent::api_resp(1, $result, "");

                } else {
                    parent::api_resp(1, "No Data Avilable", "");
                }
            } else {
                parent::api_resp(0, "danger", "Please Provide All Data");
            }
        } else {
            parent::api_resp(0, "danger", "Please Provide User Token");
        }
    }
}
