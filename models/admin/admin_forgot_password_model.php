<?php

class admin_forgot_password_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function otp_send()
    {
        if (!empty($_POST["email"])) {
            $email = $this->checkemail($_POST["email"]);

            if (!empty($email)) {
                $user_id = $email["id"];
                $user_type = 3; # user_type 1=Business, 2=User, 3=Admin
                $type = 3; # type 1=mobile, 2=email, 3=forgot password

                $otp = parent::generateOTP(6);

                parent::__construct();
                $otp_count = $this->db->prepare("CALL check_otp(?,?,?)");
                $otp_count->bindParam(1, $user_id);
                $otp_count->bindParam(2, $user_type);
                $otp_count->bindParam(3, $type);

                $otp_count->execute();
                $otp_count_result = $otp_count->fetch(PDO::FETCH_ASSOC);

                if ($otp_count_result != '') {
                    $update_otp_result = $this->updateOtp($user_id, $otp, $user_type, $type);

                    if ($update_otp_result) {
                        $this->send_mail($otp, $_POST["email"], $user_id, $user_type, $type);
                    }
                } else {
                    parent::__construct();
                    $insert_otp = $this->db->prepare("CALL insert_otp(?,?,?,?)");
                    $insert_otp->bindParam(1, $user_id);
                    $insert_otp->bindParam(2, $user_type);
                    $insert_otp->bindParam(3, $otp);
                    $insert_otp->bindParam(4, $type);
                    $insert_otp_result = $insert_otp->execute();

                    if ($insert_otp_result) {
                        $this->send_mail($otp, $_POST["email"], $user_id, $user_type, $type);
                    } else {
                        Session::set('danger', 'Something Went Wrong! Try Again.'.$insert_otp->errorInfo()[2]);
                        header("location: " . URL . admin_link . "/forgot_password");
                        exit();
                    }
                }
            } else {
                Session::set('danger', 'No Account Registered With given Email Address.');
                header("location: " . URL . admin_link . "/forgot_password");
                exit();
            }
        } else {
            Session::set('danger', 'Enter Email Address First.');
            header("location: ". URL . admin_link ."/forgot_password");
            exit;
        }
    }

    public function send_mail($otp, $email, $user_id, $user_type, $type)
    {
        $type = 3;
        $message = "Your OTP for reset password is = " . $otp . ". It will expire in 5 minutes.";
        $issent = parent::send_mailtouser($email, $message, "Reset your Securlists admin password");
        // $issent = true;
        if ($issent) {
            Session::set('issetotp', true);
            Session::set('otp_email', $email);
            Session::set('time', $_SERVER["REQUEST_TIME"]);
            Session::set('success', 'Reset Password OTP has been Sent To your Email.');
            header("location: " . URL . admin_link . "/forgot_password/otp");
            exit();
        } else {
            $otp = 0;
            $this->updateOtp($user_id, $otp, $user_type, $type);
            Session::set('danger', 'Email Send Failed! Try Again.');
            header("location: ". URL . admin_link . "/forgot_password");
            exit();
        }
    }

    public function check_otp()
    {
        if (!empty($_POST["otp"])) {

            $user_email = Session::get("otp_email");
            $email = $this->checkemail($user_email);
            $user_id = $email["id"];

            $user_type = 3; # user_type 1=Business, 2=User, 3=Admin
            $type = 3; # type 1=mobile, 2=email, 3=forgot password

            $from_timestamp = $_SERVER["REQUEST_TIME"];
            if (($from_timestamp - Session::get('time')) > 300) {
                $otp = 0;
                Session::unset('issetotp');
                Session::unset('otp_email');
                $this->updateOtp($user_id, $otp, $user_type, $type);

                Session::set('danger', "Your OTP is Expired.");
                header("location: ". URL . admin_link ."/forgot_password");
                exit;
            } else {
                parent::__construct();

                $otp_data = $this->db->prepare("CALL check_otp(?,?,?)");
                $otp_data->bindParam(1, $user_id);
                $otp_data->bindParam(2, $user_type);
                $otp_data->bindParam(3, $type);
                $otp_data->execute();
                $otp_data_result = $otp_data->fetch(PDO::FETCH_ASSOC);
                if ($otp_data_result != '') {
                    if ($otp_data_result['otp'] == $_POST["otp"]) {
                        Session::unset('time');
                        Session::set('admin_reset_pass_userid', $user_id);
                        $this->updateOtp($user_id, 0, $user_type, $type);

                        header("location: ". URL . admin_link ."/reset_password");
                        exit;
                    } else {
                        Session::set('danger', "Wrong OTP Entered.");
                        header("location: ". URL . admin_link ."/forgot_password/otp");
                        exit;
                    }
                } else {
                    Session::set('danger', 'Something Went Wrong!.'.$otp_data->errorInfo()[2]);
                    header("location: ". URL . admin_link ."/forgot_password/otp");
                    exit;
                }
            }
        } else {
            Session::set('danger', 'Enter OTP First.');
            header("location: ". URL . admin_link ."/forgot_password/otp");
            exit;
        }
    }

    public function checkemail($email)
    {
        parent::__construct();
        $data = $this->db->prepare("CALL check_admin_email(?)");
        $data->bindParam(1, $email);
        $data->execute();
        $dataresult = $data->fetch(PDO::FETCH_ASSOC);
        $existCount = $data->rowCount();

        if ($existCount > 0) {
            return $dataresult;
        } else {
            return 0;
        }
    }

    public function updateOtp($user_id, $otp, $user_type, $type)
    {
        parent::__construct();
        $update_otp = $this->db->prepare("CALL update_otp(?,?,?,?)");
        $update_otp->bindParam(1, $user_id);
        $update_otp->bindParam(2, $otp);
        $update_otp->bindParam(3, $user_type);
        $update_otp->bindParam(4, $type);

        $update_otp_result = $update_otp->execute();

        if ($update_otp_result) {
            return true;
        } else {
            Session::set('danger', 'Something Went Wrong! Try Again.'.$update_otp->errorInfo()[2]);
            header("location: " . URL . admin_link . "/forgot_password");
            exit();
        }
    }
}
