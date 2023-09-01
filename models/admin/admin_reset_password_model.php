<?php

class admin_reset_password_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function change_password()
    {
        $user_id = Session::get("admin_reset_pass_userid");
        if (!empty($_POST["new_pass"]) && !empty($_POST["confirm_pass"])) {
            if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$/', $_POST['new_pass'])) {
                if(strcmp($_POST['new_pass'], $_POST['confirm_pass']) === 0) {
                    $user_id = Session::get("admin_reset_pass_userid");
                    $user_name='';
                    parent::__construct();
                    $user_data = $this->db->prepare("CALL get_admin_data(?,?)");
                    $user_data->bindParam(1, $user_id);
                    $user_data->bindParam(2, $user_name);
                    $user_data->execute();
                    $user_data_result = $user_data->fetch(PDO::FETCH_ASSOC);
                    if(!empty($user_data_result)) {
                        $options = [
                            'cost' => 12,
                        ];

                        $password_hash = password_hash($_POST["new_pass"], PASSWORD_BCRYPT, $options);
                        parent::__construct();
                        $update_password = $this->db->prepare("CALL update_password(?,?)");
                        $update_password->bindParam(1, $user_data_result['id']);
                        $update_password->bindParam(2, $password_hash);

                        $update_password_check = $update_password->execute();

                        if ($update_password_check) {
                            Session::destroy();
                            Session::init();
                            Session::set('success', 'Password Updated Successfully.');
                            header("location: "  . URL . admin_link .  "/login");
                            exit();
                        } else {
                            Session::set('danger', 'Somethimg went wrong!'.$update_password->errorInfo()[2]);
                            header("location: "  . URL . admin_link . "/reset_password");
                            exit();
                        }
                    } else {
                        Session::set('danger', 'User does not exists.');
                        header("location: "  . URL . admin_link .  "/reset_password");
                        exit();
                    }
                } else {
                    Session::set('danger', 'Confirm password does not match with the new password.');
                    header("location: "  . URL . admin_link .  "/reset_password");
                    exit();
                }
            } else {
                Session::set('danger', "The password must be between eight to twelve characters long, and include at least one uppercase letter, one special character, and a combination of alphanumeric characters with no spaces.");
                header("Location: " . URL . admin_link . "/reset_password");
                exit();
            }
        } else {
            Session::set('danger', 'All the Fields are Required.');
            header("location: " . URL . admin_link . "/reset_password");
            exit;
        }
    }
}
