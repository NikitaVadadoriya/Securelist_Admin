<?php

class admin_2fa_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_udata($user_id)
    {
        parent::__construct();
        $username='';
        $data = $this->db->prepare("CALL get_admin_data(?,?)");
        $data->bindParam(1, $user_id);
        $data->bindParam(2, $username);
        $data->execute();
        $result = $data->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_user_data()
    {
        require server_root.'/public/API/Authenticator/vendor/autoload.php';

        $user_id = Session::get('2fa_user');
        if ($user_id != 0) {
            $user_result = $this->get_udata(parent::decrypt_string($user_id));

            $authenticator = new PHPGangsta_GoogleAuthenticator();

            $title = 'Securlists-Admin';
            $user_email = $user_result['email'];
            $qrCodeUrl = $authenticator->getQRCodeGoogleUrl($user_email, $user_result["google_authenticator_key"], $title);
            $user_result["google_code_url"] = $qrCodeUrl;
            $user_result["google_code"] =  $user_result["google_authenticator_key"];

            $user_result["tx_hash"] = md5($user_id."_".$title."_Ql506yJMdh4hddV9sjhv8Lpt70srctAh"."_".$user_result
            ["google_code"]);

            return $user_result;
        } else {
            header("Location: " . URL . admin_link . "/login");
            die;
        }
    }

    public function update_2fa()
    {
        if(isset($_POST['google2fa_code']) && !empty($_POST['google2fa_code']) && isset($_POST['google2fa_secret']) && !empty($_POST['google2fa_secret']) && isset($_POST['tx_hash']) && !empty($_POST['tx_hash'])) {
            require server_root.'/public/API/Authenticator/vendor/autoload.php';
            $user_id = Session::get('2fa_user');
            $user_result = $this->get_udata(parent::decrypt_string($user_id));

            $title= 'Securlists-Admin';

            $tx_hash = md5($user_id."_".$title."_Ql506yJMdh4hddV9sjhv8Lpt70srctAh"."_".$_POST["google2fa_secret"]);
            if ($tx_hash != $_POST['tx_hash']) {
                Session::set('danger', 'Data Verification Failed');
                header("location: " . URL . admin_link . "/2fa");
                die;
            }

            $google2fa_secret = $_POST['google2fa_secret'];

            $authenticator = new PHPGangsta_GoogleAuthenticator();

            $checkResult = $authenticator->verifyCode($google2fa_secret, $_POST['google2fa_code'], 2);

            // Check if the previous code is also valid
            $prevCode = $authenticator->getCode($google2fa_secret, time() - 60);
            $preResult = $authenticator->verifyCode($google2fa_secret, $prevCode, 2);

            if ($checkResult || $preResult) {
                parent::__construct();
                $type = 0;
                $password = '';
                $status = 1;
                $data = $this->db->prepare("CALL update_admin_data(?,?,?,?)");
                $data->bindParam(1, $type);
                $data->bindParam(2, $password);
                $data->bindParam(3, $status);
                $data->bindParam(4, parent::decrypt_string($user_id));
                $result = $data->execute();

                if ($result) {
                    Session::destroy();
                    Session::init();
                    Session::set('success', 'Two factor authentication is successfully done.');
                    header("location: " . URL . admin_link . "/login");
                    die;
                } else {
                    Session::set('danger', 'Something went wrong while two factor authentication.');
                    header("location: " . URL . admin_link . "/2fa");
                    die;
                }
            } else {
                Session::set('danger', "Invalid Verification Code");
                header("location: " . URL . admin_link . "/2fa");
                die;
            }
        } else {
            Session::set('danger', "Please provide all the required details.");
            header("location: " . URL . admin_link . "/2fa");
            die;
        }
    }
}
