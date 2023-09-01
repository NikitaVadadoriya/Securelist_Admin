<?php

class members_tl_current_status_Model extends Model
{
    public function __construct()
    {
        parent::__construct();

    }

    public function get_cdata()
    {
        $user_id = Session::get('user_id');

        parent::__construct();
        $data = $this->db->prepare("call get_locality_by_TL(?)");
        $data->bindparam(1, $user_id);
        $data->execute();
        $result["all_locality"] = $data->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_POST["user_locality"])) {

            // get data based locality becuase user has selected locality
            if (in_array('0', $_POST["user_locality"])) {
                goto if_selectedall;
            }
            foreach ($_POST["user_locality"] as $selected_locality) {
                parent::__construct();
                $data = $this->db->query("call get_report_data('".$selected_locality."','".$user_id."','".date("Y/m/d")."')");
                $tbl_data = $data->fetchAll(PDO::FETCH_ASSOC);
                $tbl_data[0]['locality'] = $result["all_locality"][$selected_locality]["locality"];
                $result['report_data'][]=$tbl_data[0];
            }
        } else {
            // get All Data If user has not selected any locality
            if_selectedall :
            foreach ($result["all_locality"] as $selected_locality) {
                parent::__construct();
                $data = $this->db->query("call get_report_data('".$selected_locality["id"]."','".$user_id."','".date("Y/m/d")."')");
                $tbl_data = $data->fetchAll(PDO::FETCH_ASSOC);
                $tbl_data[0]['locality'] = $selected_locality["locality"];
                $result['report_data'][]=$tbl_data[0];
            }
        }
        // echo "<pre>";
        // print_r($result);
        // die();
        return $result;

    }
}
