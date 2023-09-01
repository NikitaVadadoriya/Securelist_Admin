<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class Controller
{
    public function __construct()
    {

        Session::init();
        $this->view = new View();
    }

    public function loadModel($url0, $url1, $cont)
    {


        if ($cont != 0) {

            try {
                $path = 'models/' . $url0 . '/' . $url0 . '_' . $url1 . '_model.php';
                // echo $path;

                if (file_exists($path)) {

                    $gen_path = 'models/' . $url0 . '/' . $url0 . '_general_model.php';
                    if (file_exists($gen_path)) {


                        require 'models/' . $url0 . '/' . $url0 . '_general_model.php';
                        $modelgenName = $url0 . '_general_Model';

                        $this->genmodel = new $modelgenName();
                    }

                    require 'models/' . $url0 . '/' . $url0 . '_' . $url1 . '_model.php';
                    $modelName = $url0 . '_' . $url1 . '_Model';
                    // echo $modelName;

                    $this->model = new $modelName();
                }
            } catch (Exception $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";
            }
        } else {

            try {
                $path = 'models/web/' . $url0 . '.php';

                if (file_exists($path)) {

                    $gen_path = 'models/web/' . $url0 . '_general_model.php';
                    if (file_exists($gen_path)) {


                        require 'models/web/' . $url0 . '_general_model.php';
                        $modelgenName = $url0 . '_general_Model';

                        $this->genmodel = new $modelgenName();
                    }

                    require 'models/web/' . $url0 . '.php';
                    $modelName = $url0 . '_Model';
                    // echo $modelName;

                    $this->model = new $modelName();
                }
            } catch (Exception $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";
            }
        }
    }

    public function redirect()
    {

        $user = Session::get('user');
        $user_id = Session::get('user_id');
        $stype = Session::get('type');
        $home_url = Session::get('home_url');
        if ($user == false) {

            Session::destroy();
            header("location: " . URL . "login");
            exit;
        } else {
            // echo "<br>".$user;
            // echo "<br>".$user_id;
            // echo "<br>".$stype;
            // echo "<br>".$home_url;
            // die();

            $this->view->user_name = $user;
            $this->view->userid = $user_id;
            $this->view->utype = $stype;
            $this->view->home_url = $home_url;
        }
        // session_destroy();
    }

    public function admin_redirect()
    {

        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 7200)) {
            Session::destroy();
            header("location: " . URL .admin_link. "/login");
            exit;
        } else {
            Session::set('LAST_ACTIVITY', time());
        }

        $auser = Session::get('admin_data');
        if ($auser == false) {
            Session::destroy();
            header("location: " . URL . admin_link . "/login");
            die;
        } else {
            $this->model = new Model();
            // $email = $this->model->decrypt_admin_data('admin_email');
            $user_name = $this->model->decrypt_admin_data('admin_user_name');
            $aupass = $this->model->decrypt_admin_data('admin_pass');

            $this->db = new Database();

            $data = $this->db->prepare("CALL session_acheck(?,?)");
            $data->bindParam(1, $user_name);
            // $data->bindParam(1, $email);
            $data->bindParam(2, $aupass);
            $data->execute();

            $data_result = $data->fetch(PDO::FETCH_ASSOC);

            if ($data_result == null) {
                Session::destroy();
                header("location: " . URL . admin_link . "/login");
                die;
            } else {
                // $this->view->admin_email = $email;
                $this->view->admin_user_name = $user_name;
                $this->view->admin_id = $this->model->decrypt_admin_data('admin_id');
                $this->view->user_2fa = $this->model->decrypt_admin_data('user_2fa');
            }
        }

        // $auser = Session::get('admin_user');
        // $auser_id = Session::get('admin_id');
        // $aupass = Session::get('admin_pass');
        // $auphone = Session::get('admin_phone');

        // if ($auser == false) {
        //     Session::destroy();
        //     header("location: " . URL . admin_link . "/login");
        //     exit;
        // } else {
        //     if ($auser == false) {
        //     } else {
        //         include_once(server_root . '/public/API/pass/PasswordHash.php');

        //         $t_hasher = new PasswordHash(8, true);

        //         $this->db = new Database();

        //         $data = $this->db->prepare("CALL session_acheck(?,?)");
        //         $data->bindParam(1, $auser);
        //         $data->bindParam(2, $aupass);
        //         $data->execute();
        //         $result = $data->fetch();
        //         $existCount = $data->rowCount(); // count the row nums

        //         if ($existCount == 0) {
        //             Session::destroy();
        //             header("location: " . URL . admin_link . "/login");
        //             exit;
        //         }
        //     }

        //     $this->view->userid = $auser_id;
        //     $this->view->user = $auser;
        //     $this->view->userphone = $auphone;
        // }
        // // session_destroy();
    }

    public function check_isadmin_logged_in()
    {
        if (Session::get("admin_data") != 0) {
            header('Location: ' . URL . admin_link . '/');
            exit();
        }
    }

    public function check_sitetoken($token, $request_from)
    {
        if (isset($token) && isset($request_from)) {

            if ($request_from == 1) {
                if ($token != 'truss') {

                    $error = array("status" => "0", "response" => "", "error_desc" => "Wrong Site Token Provided For IOS");

                    echo json_encode($error);

                    die();
                }
            } elseif($token != "androidtruss") {
                $error = array("status" => "0", "response" => "", "error_desc" => "Wrong Site Token Provided For Android");

                echo json_encode($error);

                die();
            }
        } else {


            $error = array("status" => "0", "response" => "", "error_desc" => "Site Token Not Set");

            echo json_encode($error);

            die();
        }
    }
}
