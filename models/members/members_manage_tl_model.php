<?php

class members_manage_tl_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function get_all_details()
    {

        $user_type = 4;
        $user_id = Session::get('user_id');

        parent::__construct();
        $data = $this->db->prepare("call get_user_bytype_underuser(?,?)");
        $data->bindparam(1, $user_type);
        $data->bindparam(2, $user_id);
        $data->execute();
        $user_data = $data->fetchAll(PDO::FETCH_ASSOC);

        parent::__construct();
        $data = $this->db->prepare("call get_all_city()");
        $data->execute();
        $city = $data->fetchAll(PDO::FETCH_ASSOC);

        $result["user_data"] = $user_data;
        $result["city"] = $city;


        return $result;
    }

    public function get_zone()
    {


        parent::__construct();
        $data = $this->db->prepare("call get_zone_by_city(?)");
        $data->bindparam(1, $_POST["city_id"]);
        $data->execute();
        $city_data = $data->fetchAll();

        echo json_encode($city_data);
    }

    public function get_manager_and_area_byzone()
    {
        parent::__construct();
        $data = $this->db->prepare("call get_area_byzone(?)");
        $data->bindparam(1, $_POST["zone_id"]);
        $data->execute();
        $result["area"] = $data->fetchAll();

        parent::__construct();
        $data = $this->db->prepare("call get_manager_by_zone(?)");
        $data->bindparam(1, $_POST["zone_id"]);
        $data->execute();
        $result["manager"] = $data->fetchAll();

        echo json_encode($result);
    }

    public function get_supervisor_by_area()
    {
        // print_r($_POST);
        // die();
        parent::__construct();
        $data = $this->db->prepare("call get_supervisor_by_area(?)");
        $data->bindparam(1, $_POST["id"]);
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    }

    public function get_locality_by_area()
    {
        // print_r($_POST);
        // die();
        parent::__construct();
        $data = $this->db->prepare("call get_locality_by_area(?)");
        $data->bindparam(1, $_POST["id"]);
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    }

    public function get_supervisor_by_manager()
    {
        // print_r($_POST);
        // die();
        parent::__construct();
        $data = $this->db->prepare("call get_supervisor_by_manager(?)");
        $data->bindparam(1, $_POST["id"]);
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    }

    public function add_teamleader()
    {

        $user_id = Session::get('user_id');
        $session_user_type = Session::get('type');

        include_once(server_root . '/public/API/pass/PasswordHash.php');
        $t_hasher = new PasswordHash(8, true);

        $user_pass = $this->generateRandomString();
        $uhash = $t_hasher->HashPassword($user_pass);

        if (isset($_POST["user_fname"]) && isset($_POST["user_lname"]) && isset($_POST["user_mail"]) && isset($_POST["user_phone"]) && $_POST["supervisor"] != 0) {

            parent::__construct();
            $data = $this->db->prepare("call check_user_exist(?)");
            $data->bindparam(1, $_POST["user_mail"]);
            $data->execute();
            $check_user = $data->fetchAll();

            if (count($check_user) >0) {
                Session::set('danger', "User with same email address Exist");
                header("location: " . URL . $session_user_type . "/manage_tl");
                exit();
            } else {
                $user_type = 4;
                $user_add = "";
                $user_locality =0;

                parent::__construct();
                $data = $this->db->prepare("call add_user(?,?,?,?,?,?,?,?)");
                $data->bindparam(1, $_POST["user_fname"]);
                $data->bindparam(2, $_POST["user_lname"]);
                $data->bindparam(3, $user_type);
                $data->bindparam(4, $uhash);
                $data->bindparam(5, $_POST["user_mail"]);
                $data->bindparam(6, $_POST["user_phone"]);
                $data->bindparam(7, $user_add);
                $data->bindparam(8, $user_locality);

                $data->execute();
                $result = $data->fetchAll();

                if ($result[0]["user_id"] > 0) {

                    $user_type = $result[0]["user_type_id"];
                    $insert_user_id = $result[0]["user_id"];
                    $assigned_type = 4;


                    if ($_POST["user_locality"] > 0) {

                        parent::__construct();
                        $data = $this->db->prepare("call insert_linkuser(?,?,?,?,?)");
                        $data->bindparam(1, $insert_user_id);
                        $data->bindparam(2, $user_type);
                        $data->bindparam(3, $_POST["supervisor"]);
                        $data->bindparam(4, $_POST["user_area"]);
                        $data->bindparam(5, $assigned_type);

                        $is_inserted = $data->execute();

                        if (!$is_inserted) {
                            $is_send = parent::send_mailtouser($_POST["user_mail"], $pass, "You are added as Manager");
                            // Session::set('danger', $data->errorInfo()[2]);
                            Session::set('danger', "User Zone not set up ! Update Zone Setting By goin to Update User ");
                            header("location: " . URL . "members/manage_tl");
                            exit();
                        } else {
                            parent::send_mailtouser($_POST["user_mail"], $pass, "You are added as Manager");
                            Session::set('success', 'User Addedd Successfully.');
                            header("location: " . URL . $session_user_type . "/manage_tl");
                            exit();
                        }


                    } else {

                        $user_zone=0;
                        parent::__construct();
                        $data = $this->db->prepare("call insert_linkuser(?,?,?,?,?)");
                        $data->bindparam(1, $insert_user_id);
                        $data->bindparam(2, $user_type);
                        $data->bindparam(3, $_POST["supervisor"]);
                        $data->bindparam(4, $user_zone);
                        $data->bindparam(5, $assigned_type);

                        $is_inserted = $data->execute();

                        if (!$is_inserted) {
                            $is_send = parent::send_mailtouser($_POST["user_mail"], $pass, "You are added as Manager");
                            // Session::set('danger', $data->errorInfo()[2]);
                            Session::set('danger', "User Zone not set up ! Update Zone Setting By goin to Update User ");
                            header("location: " . URL . "members/manage_tl");
                            exit();
                        } else {
                            $is_send = parent::send_mailtouser($_POST["user_mail"], $pass, "You are added as Manager");
                            Session::set('success', 'User Addedd Successfully.');
                            header("location: " . URL . $session_user_type . "/manage_tl");
                            exit();
                        }
                    }

                } else {
                    Session::set('danger', "User Not Inserted Successfully! Try Again");
                    header("location: " . URL . $session_user_type . "/manage_tl");
                    exit();
                }
            }
        } else {
            Session::set('danger', "Plese Enter All Reqired Value");
            header("location: " . URL . $session_user_type . "/manage_tl");
            exit();
        }
    }

    public function get_tl_detail($user_mail)
    {

        $user_mail = base64_decode(urldecode($user_mail));


        parent::__construct();
        $data = $this->db->prepare("call get_user_by_email(?)");
        $data->bindparam(1, $user_mail);
        $data->execute();
        $result["tl_data"] = $data->fetchAll();

        parent::__construct();
        $data = $this->db->prepare("call get_all_city()");
        $data->execute();
        $result["city_data"] = $data->fetchAll();

        parent::__construct();
        $data = $this->db->prepare("call get_zone_by_city(?)");
        $data->bindparam(1, $result["supervisor_data"][0]["city_id"]);
        $data->execute();
        $result["zone_info"] = $data->fetchAll();

        parent::__construct();
        $data = $this->db->prepare("call get_area_byzone(?)");
        $data->bindparam(1, $result["zone_info"][0]["id"]);
        $data->execute();
        $result["area_info"] = $data->fetchAll();

        parent::__construct();
        $data = $this->db->prepare("call get_locality_by_area(?)");
        $data->bindparam(1, $result["area_info"][0]["id"]);
        $data->execute();
        $result["locality_info"] = $data->fetchAll();

        parent::__construct();
        $data = $this->db->prepare("call get_manager_by_zone(?)");
        $data->bindparam(1, $result["zone_info"][0]["id"]);
        $data->execute();
        $result["manager"] = $data->fetchAll();

        parent::__construct();
        $data = $this->db->prepare("call get_supervisor_by_area(?)");
        $data->bindparam(1, $result["area_info"][0]["id"]);
        $data->execute();
        $result["supervisor"] = $data->fetchAll();

        return $result;
    }

    public function edit_user()
    {

        $user_id = Session::get('user_id');
        $session_user_type = Session::get('type');

        if (isset($_POST["user_fname"]) && isset($_POST["user_lname"]) && isset($_POST["user_mail"]) && isset($_POST["user_phone"]) && $_POST["manager"] != 0) {

            parent::__construct();
            $data = $this->db->prepare("call update_user(?,?,?,?)");
            $data->bindparam(1, $_POST["user_fname"]);
            $data->bindparam(2, $_POST["user_lname"]);
            $data->bindparam(3, $_POST["user_mail"]);
            $data->bindparam(4, $_POST["user_phone"]);


            $data->execute();
            $result = $data->fetchAll();

            if ($result[0]["user_id"] > 0) {

                $user_type = $result[0]["user_type_id"];
                $insert_user_id = $result[0]["user_id"];
                $assigned_type = 2;


                if ($_POST["user_area"] > 0) {

                    parent::__construct();
                    $data = $this->db->prepare("call update_link_user(?,?,?)");
                    $data->bindparam(1, $insert_user_id);
                    $data->bindparam(2, $_POST["user_area"]);
                    $data->bindparam(3, $_POST["manager"]);

                    $is_inserted = $data->execute();

                    if (!$is_inserted) {

                        Session::set('danger', $data->errorInfo()[2]);
                        // Session::set('danger', "User Zone not set up ! Update Zone Setting By goin to Update User ");
                        header("location: " . URL . "members/manage_tl");
                        exit();
                    } else {

                        Session::set('success', 'User Updated Successfully.');
                        header("location: " . URL . $session_user_type . "/manage_tl");
                        exit();
                    }


                } else {

                    Session::set('success', 'User Updated Successfully..');
                    header("location: " . URL . $session_user_type . "/manage_tl");
                    exit();
                }

            } else {

                Session::set('danger', $data->errorInfo()[2]);
                // Session::set('danger', "User Not Inserted Successfully! Try Again");
                header("location: " . URL . $session_user_type . "/manage_tl");
                exit();
            }
        } else {
            Session::set('danger', "Plese Enter All Reqired Value");
            header("location: " . URL . $session_user_type . "/manage_tl");
            exit();
        }

    }

    //
    public function get_zone_by_manager()
    {
        $user_id = Session::get('user_id');

        parent::__construct();
        $data = $this->db->prepare("call get_zone_by_manager(?)");
        $data->bindparam(1, $user_id);
        $data->execute();
        $city_data = $data->fetchAll(PDO::FETCH_ASSOC);

        return $city_data;
    }
}
