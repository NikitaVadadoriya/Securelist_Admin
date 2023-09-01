<?php

class admin_login_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function user_login()
    {
        if (isset($_POST['user_2fa_code'])) {
            $id = 0;
            $username = Session::get('temp_username');
            if (!empty($username)) {
                if (!empty($_POST['user_2fa_code'])) {
                    require server_root.'/public/API/Authenticator/vendor/autoload.php';
                    parent::__construct();
                    $data = $this->db->prepare("CALL get_admin_data(?,?)");
                    $data->bindParam(1, $id);
                    $data->bindParam(2, $username);
                    $data->execute();
                    $result = $data->fetch(PDO::FETCH_ASSOC);

                    $authenticator = new PHPGangsta_GoogleAuthenticator();
                    $oneCode = $authenticator->getCode($result['google_authenticator_key']);
                    $google2fa_secret = $result['google_authenticator_key'];

                    $checkResult = $authenticator->verifyCode($google2fa_secret, $_POST['user_2fa_code'], 2);

                    // Check if the previous code is also valid
                    $prevCode = $authenticator->getCode($google2fa_secret, time() - 60);
                    $preResult = $authenticator->verifyCode($google2fa_secret, $prevCode, 2);

                    if ($checkResult || $preResult) {
                        Session::destroy();
                        Session::init();
                        // Session::set('admin_data', parent::encrypt_string("admin_id=".parent::encrypt_string($result["id"]).",admin_email=".$result["email"].",admin_pass=".$result['password'].",user_2fa=".$result["is_2fa_done"]));
                        Session::set('admin_data', parent::encrypt_string("admin_id=".parent::encrypt_string($result["id"]).",admin_user_name=".$result["user_name"].",admin_pass=".$result['password'].",user_2fa=".$result["is_2fa_done"]));

                        header('Location: ' . URL . admin_link);
                        die;
                    } else {
                        Session::set('danger', 'Invalid Authentication Code');
                        header('Location: ' . URL . admin_link . '/login/verify');
                        die;
                    }
                } else {
                    Session::set('danger', 'Please enter authentication code.');
                    header('Location: ' . URL . admin_link . '/login/verify');
                    die;
                }
            } else {
                header('Location: ' . URL . admin_link . '/login');
                die;
            }
        }


        if (!empty($_POST['user_name']) && !empty($_POST['password'])) {
            $id = 0;
            $data = $this->db->prepare("CALL get_admin_data(?,?)");
            $data->bindParam(1, $id);
            $data->bindParam(2, $_POST['user_name']);
            $data->execute();
            $result = $data->fetch(PDO::FETCH_ASSOC);

            if ($result != null) {
                $upass = $result["password"];
                $check = password_verify($_POST["password"], $result['password']);

                if ($check == 1) {
                    if ($result['is_2fa_done'] == 0) {
                        Session::set('2fa_user', parent::encrypt_string($result["id"]));
                        header("location: " . URL . admin_link . "/2fa");
                        die;
                    } else {
                        Session::set('temp_username', $result["user_name"]);
                        header("location: " . URL . admin_link . "/login/verify");
                        die;
                    }
                } else {
                    Session::set('danger', 'Please Enter Correct Password.');
                    header("location: " . URL . admin_link . "/login");
                    die;
                }
            } else {
                Session::set('danger', 'Enter Correct Username.');
                header("location: " . URL . admin_link . "/login");
                die;
            }
        } else {
            Session::set('danger', 'Please provide all the details.');
            header('Location: '.URL.admin_link.'/login');
            die;
        }
    }
}
