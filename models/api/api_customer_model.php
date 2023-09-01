<?php

class api_customer_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_request()
    {

        if (isset($_POST["house_id"])) {
            if (isset($_POST["date_array"])) {



                $house_id = $_POST["house_id"];
                $date_array = json_decode($_POST["date_array"], true);

                $tmpcnt = count($date_array["date_range"]);
                // echo date("H:i", strtotime("7 pm"));

                foreach ($date_array["date_range"] as $each_date) {

                    $from_time =date("H:i", strtotime($each_date['start_time']));
                    $to_time = date("H:i", strtotime($each_date['end_time']));

                    $data = $this->db->prepare("CALL add_request(?,?,?,?,?)");
                    $data->bindParam(1, $house_id);
                    $data->bindParam(2, $house_id);
                    $data->bindParam(3, $each_date["pickup_date"]);
                    $data->bindParam(4, $from_time);
                    $data->bindParam(5, $to_time);
                    $data->execute();
                    $result = $data->fetch(PDO::FETCH_ASSOC);
                    if ($data) {
                        $tmpcnt --;
                    } else {
                        echo $data->errorInfo()[2];
                        parent::api_resp(0, "", "Request After  ".$each_date["pickup_date"] ." not created Try Adding Request After This Date");
                    }
                }

                if ($tmpcnt == 0) {
                    parent::api_resp(1, "Request Created Successfully.", "");
                }
                die();

            } else {
                parent::api_resp(0, "danger", "Please Provide Date");
            }
        } else {
            parent::api_resp(0, "danger", "Please Provide House Information");
        }
    }

    public function get_my_request()
    {
        if ($_POST["house_id"]) {
            $data = $this->db->prepare("CALL get_request_by_house_id(?)");
            $data->bindParam(1, $_POST["house_id"]);
            $data->execute();
            $result = $data->fetch(PDO::FETCH_ASSOC);
            $existCount = $data->rowCount();

            if ($existCount > 0) {

                parent::api_resp(1, $result, "");

            } else {
                parent::api_resp(1, "No Data Avilable", "");
            }
        } else {

        }
    }

    public function scan_house()
    {
        if ($_POST["house_id"]) {
            $data = $this->db->prepare("CALL get_house_info(?)");
            $data->bindParam(1, $_POST["house_id"]);
            $data->execute();
            $result = $data->fetch(PDO::FETCH_ASSOC);
            $existCount = $data->rowCount();

            if ($existCount > 0) {
                parent::api_resp(1, $result, "");

            } else {
                parent::api_resp(1, "No Data Avilable", "");
            }
        } else {

        }
    }

}
