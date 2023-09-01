<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class members_s_current_status_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_cdata()
    {
        $user_id = Session::get('user_id');

        parent::__construct();
        $data = $this->db->prepare("call get_area_by_supervisor(?)");
        $data->bindparam(1, $user_id);
        $data->execute();
        $result["all_area"] = $data->fetchAll(PDO::FETCH_ASSOC);

        $locality_list  = array();

        // get data based locality becuase user has selected locality
        if (in_array('0', $_POST["user_area"]) && in_array('0', $_POST["user_locality"])) {

            // if user has selected All Area , All Locality, All Tl
            // goto if_selected;
            foreach ($result["all_area"] as $area_list) {
                // $locality_list[] = $this->get_locality_by_area($area_list["id"]);
                parent::__construct();
                $data = $this->db->query("call get_locality_by_area('".$area_list["id"]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $locality_list[]=$result_array;

                parent::__construct();
                $data = $this->db->query("call get_report_data('".$result_array[0]["id"]."','".$user_id."','".date("Y/m/d")."')");
                $tbl_data = $data->fetchAll(PDO::FETCH_ASSOC);
                $tbl_data[0]['locality'] = $result_array[0]["locality"];
                $result['report_data'][]=$tbl_data[0];
            }

        } else {
            // if user selected specific area
            if (!in_array('0', $_POST["user_locality"])) {

                foreach ($_POST["user_locality"] as $locality_list) {

                    parent::__construct();
                    $data = $this->db->query("call get_report_data('".$locality_list["id"]."','".$user_id."','".date("Y/m/d")."')");
                    $tbl_data = $data->fetchAll(PDO::FETCH_ASSOC);
                    $tbl_data[0]['locality'] = $locality_list["id"];
                    $result['report_data'][]=$tbl_data[0];
                }
            }

        }




        // get All Data If user has not selected any locality locality =0
        if_selected :

        // check if user has selected all locality
        // echo "<pre>";
        // print_r($result);
     //    die();


        return $result;

    }

    public function get_locality_by_area($area_id)
    {
        parent::__construct();
        $data = $this->db->query("call get_locality_by_area('".$area_id."')");
        $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
        // $result_array = $result_array[0];
        return $result_array;
    }

    public function get_locality()
    {
        // print_r($_POST);
        $result = array();
        if ($_POST["id"] == 0) {

            $user_id = Session::get('user_id');

            parent::__construct();
            $data = $this->db->prepare("call get_area_by_supervisor(?)");
            $data->bindparam(1, $user_id);
            $data->execute();
            $area_data["all_area"] = $data->fetchAll(PDO::FETCH_ASSOC);

            foreach ($area_data["all_area"] as $area_list) {
                parent::__construct();
                $data = $this->db->query("call get_locality_by_area('".$area_list["id"]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result[]=$result_array;
            }
            parent::__construct();
            $data = $this->db->query("call get_locality_by_area('2')");
            $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
            $result[]=$result_array;

        } else {
            $selected_area = explode(',', $_POST["id"]);
            for ($i=0; $i < count($selected_area); $i++) {
                // echo $selected_area[$i];
                parent::__construct();
                $data = $this->db->query("call get_locality_by_area('".$selected_area[$i]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result[]=$result_array;
            }
        }

        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);

    }

    public function get_tl()
    {
        $result = array();
        if ($_POST["id"] == 0) {

            $user_id = Session::get('user_id');

            parent::__construct();
            $data = $this->db->prepare("call get_area_by_supervisor(?)");
            $data->bindparam(1, $user_id);
            $data->execute();
            $area_data["all_area"] = $data->fetchAll(PDO::FETCH_ASSOC);

            foreach ($area_data["all_area"] as $area_list) {
                parent::__construct();
                $data = $this->db->query("call get_locality_by_area('".$area_list["id"]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result[]=$result_array;
            }
            parent::__construct();
            $data = $this->db->query("call get_locality_by_area('2')");
            $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
            $result[]=$result_array;

        } else {
            $selected_area = explode(',', $_POST["id"]);
            for ($i=0; $i < count($selected_area); $i++) {
                // echo $selected_area[$i];
                parent::__construct();
                $data = $this->db->query("call get_locality_by_area('".$selected_area[$i]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result[]=$result_array;
            }
        }

        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    }
}
