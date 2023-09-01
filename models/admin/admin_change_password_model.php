<?php


class admin_change_password_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function change_pass()
    {
        if(!empty($_POST['curr_pass']) && !empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])) {
            $curr_pass = parent::decrypt_admin_data('admin_pass');
            $check = password_verify($_POST["curr_pass"], $curr_pass);
            if ($check == 1) {
                if($_POST['new_pass'] != $_POST['curr_pass']) {
                    if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$/', $_POST['new_pass'])) {
                        if(strcmp($_POST['new_pass'], $_POST['confirm_pass']) === 0) {
                            $admin_id = parent::decrypt_string(parent::decrypt_admin_data('admin_id'));
                            $password_hash = password_hash($_POST['new_pass'], PASSWORD_BCRYPT, ['cost' => 12]);

                            $data = $this->db->prepare('CALL update_password(?,?)');
                            $data->bindParam(1, $admin_id);
                            $data->bindParam(2, $password_hash);
                            $result = $data->execute();

                            if($result) {
                                Session::set('admin_data', parent::encrypt_string("admin_id=".parent::encrypt_string($admin_id).",admin_user_name=".parent::decrypt_admin_data('admin_user_name').",admin_pass=".$password_hash.",user_2fa=".parent::decrypt_admin_data('user_2fa')));

                                Session::set('success', 'Password has been updated successfully.');
                                header("location: " . URL . admin_link . "/change_password");
                                die;
                            } else {
                                Session::set('danger', $data->errorInfo()[2]);
                                header("location: " . URL . admin_link . "/change_password");
                                die;
                            }
                        } else {
                            Session::set('danger', 'Confirm password does not match with the new password.');
                            header("location: " . URL . admin_link . "/change_password");
                            die;
                        }
                    } else {
                        Session::set('danger', 'The password must be between eight to twelve characters long, and include at least one uppercase letter, one special character, and a combination of alphanumeric characters with no spaces.');
                        header("Location: " . URL . admin_link . "/change_password");
                        die;
                    }
                } else {
                    Session::set('danger', 'Your new password may not be the same as your old password.');
                    header("location: " . URL . admin_link . "/change_password");
                    die;
                }
            } else {
                Session::set('danger', 'Please Enter Correct Password.');
                header("location: " . URL . admin_link . "/change_password");
                die;
            }
        } else {
            Session::set('danger', 'Please provide all the ecessary details.');
            header('Location: ' . URL . admin_link . '/change_password');
            exit;
        }
    }
}
