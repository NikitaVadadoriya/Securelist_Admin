<?php

class members_login_Model extends Model
{
    public function __construct()
    {
        parent::__construct();




    }

    public function check()
    {


        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $token = bin2hex(openssl_random_pseudo_bytes(4));

        if(isset($_POST['user_mail']) && isset($_POST['user_pass'])) {

            include(server_root . '/public/API/pass/PasswordHash.php');
            $t_hasher = new PasswordHash(8, true);

            // check Users Exist Or Not

            $user_type = 1;
            $data = $this->db->prepare("CALL login_check(?)");
            $data->bindParam(1, $_POST["user_mail"]);

            $data->execute();
            $result = $data->fetch();
            $existCount = $data->rowCount();

            if ($existCount > 0) {

                if ($result["status"] == 0 or $result["status"] == 2) {
                    Session::set('danger', 'Your Are Block By Admin. Contact Admin!');
                    header("location: " . URL . "members/login");
                    exit();
                }

                $upass = $result["user_pass"];

                $check = $t_hasher->CheckPassword($_POST["user_pass"], $upass);



                if ($check == 1) {

                    // Enable this if you want set 2Fa Function
                    // $otp = $this->generateRandomString();
                    // $msg = "Your One time OTP for ADMIN Login is " . $otp;
                    // parent::send_otp($_POST["user_phone"], $msg);

                    Session::set('user_id', $result["id"]);
                    Session::set('user', $_POST["user_mail"]);
                    Session::set('type', $result["type"]);
                    Session::set('user_phone', $result["user_contact"]);
                    Session::set('LAST_ACTIVITY', time());
                    Session::set('token', $token);
                    Session::set('start_session', time());
                    Session::set('expire_session', time()+(30*60));

                    parent::get_login_details($_POST['user_mail'], $result["user_type_id"], '0', $token);

                    header("location: " . URL . "members/".$result["home_url"]);
                    exit;


                } else {

                    Session::destroy();
                    Session::init();
                    parent::get_login_details($_POST['user_mail'], $user_type, '0', $token);

                    Session::set('danger', 'Please Enter Correct Password.');
                    header("location: " . URL . "members/login");
                    exit();
                }
            } else {
                Session::set('danger', $data->errorinfo()[2]);
                // Session::set('danger', 'Enter Correct User Email');
                header("location: " . URL . "members/login");
                exit();
            }
        }

    }
}
