<?php

/**
 *
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Model
{
    public function __construct()
    {
        $this->db = new Database();
    }

    public function api_resp($status, $response, $error_desc)
    {

        $resp["status"] = $status;
        $resp["response"] = $response;
        $resp["error_desc"] = $error_desc;

        echo json_encode($resp);
        die();
    }

    public function get_login_details($user_name, $type, $result, $token)
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $this->db = new Database();

        $data = $this->db->prepare("call insert_login(?,?,?,?,?)");
        $data->bindParam(1, $user_name);
        $data->bindParam(2, $type);
        $data->bindParam(3, $result);
        $data->bindParam(4, $ip);
        $data->bindParam(5, $token);

        $result = $data->execute();
    }

    public function send_mailtouser($email, $msg, $sub)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $mail_send = 0;
        } else {
            require(server_root . '/public/API/PHPMailer/vendor/autoload.php');
            require(server_root . "/public/API/PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php");
            require(server_root . "/public/API/PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php");
            require(server_root . "/public/API/PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php");

            $mail = new PHPMailer(true); // create a new object

            try {
                // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
                $mail->IsSMTP(); // enable SMTP
                $mail->Mailer = "smtp";
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true; // authentication enabled
                $mail->Username = "rejoicehubsolution@gmail.com";
                $mail->Password = "ulihpsbmbypazluh";
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465; // or 587

                $mail->SetFrom = "rejoicehubsolution@gmail.com";

                $mail->IsHTML(true);
                $mail->Subject = $sub;
                $mail->Body = $msg;
                // $mail->SMTPDebug = 2;
                $mail->AddAddress($email);

                if (!$mail->Send()) {
                    return $mail_send = 0;
                } else {
                    return $mail_send = 1;
                }
            } catch (Exception $e) {
                return $mail_send = 0;
                // return $mail_send."Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

    public function decrypt_admin_data($key)
    {
        $decrypt_string = $this->decrypt_string(Session::get("admin_data"));
        $decrypted_array = explode(',', $decrypt_string);

        for ($i=0; $i < count($decrypted_array); $i++) {
            $key_value = explode('=', $decrypted_array [$i]);
            $end_array[$key_value[0]] = $key_value[1];
        }

        switch($key) {
            case 'admin_id':
                return $end_array["admin_id"];
                break;
            case 'admin_email':
                return $end_array["admin_email"];
                break;
            case 'admin_user_name':
                return $end_array["admin_user_name"];
                break;
            case 'admin_pass':
                return $end_array["admin_pass"];
                break;
            case 'user_2fa':
                return $end_array["user_2fa"];
                break;
            default:
                return;
        }
    }

    public function generateOTP($length = 8)
    {
        $characters = '1357902468';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function encrypt_string($string_val)
    {
        return openssl_encrypt($string_val, ciphering, encryption_key, options, encryption_iv);
    }

    public function decrypt_string($string_val)
    {
        return openssl_decrypt($string_val, ciphering, decryption_key, options, decryption_iv);
    }
}
