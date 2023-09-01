<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/**
 *
 */
class View
{
    public function __construct()
    {
        // echo "This is view";
    }

    public function render($url0, $url1, $noInclude = false)
    {


        if ($noInclude == 1) {


            foreach ($url1 as $key) {

                require 'views/' . $url0 . '/head.php';
                require 'views/' . $url0 . '/' . $key . '.php';
                require 'views/' . $url0 . '/footer.php';
            }

        } elseif ($noInclude == false) {


            require 'views/' . $url0 . '/head.php';
            require 'views/includes.php';
            require 'views/' . $url0 . '/header.php';

            foreach ($url1 as $key) {

                require 'views/' . $url0 . '/' . $key . '.php';

            }

            require 'views/' . $url0 . '/footer.php';

        } elseif ($noInclude == 2) {

            foreach ($url1 as $key) {


                require 'views/' . $url0 . '/' . $key . '.php';

            }


        }

    }

    // public function check_errors()
    // {

    //     $types = array('success','info','warning','danger');
    //     $itypes = array('check-all','information','alert','block-helper');

    //     foreach($types as $t) {

    //         if(Session::get($t)!=false and !empty(Session::get($t)) and !is_array(Session::get($t))) {

    //             //  foreach(Session::get($t) as $msg){
    //             $msg = Session::get($t);
    //             switch($t) {

    //                 case 'success':
    //                     $icon='check-all';
    //                     $shout = 'Success!';
    //                     break;
    //                 case 'info':
    //                     $icon='information';
    //                     $shout = 'Info!';
    //                     break;
    //                 case 'warning':
    //                     $icon='alert';
    //                     $shout = 'Warning!';
    //                     break;
    //                 case 'danger':
    //                     $icon='block-helper';
    //                     $shout = 'Error!';
    //                     break;
    //             }

    //             echo'<div class="alert alert-icon alert-'.$t.' alert-dismissible fade show" role="alert">
    //                                             <button type="button" class="close" data-bs-dismiss="alert"
    //                                                     aria-label="Close">
    //                                                 <span aria-hidden="true">&times;</span>
    //                                             </button>
    //                                             <i class="mdi mdi-'.$icon.'"></i>
    //                                             <strong>'.$shout.'</strong> '.$msg.'
    //                                         </div>';
    //             //  }
    //             unset($_SESSION[$t]);
    //         }
    //     }
    // }

    public function check_errors()
    {

        $types = array('success', 'info', 'warning', 'danger');

        foreach ($types as $t) {

            if (Session::get($t) != false and !empty(Session::get($t)) and !is_array(Session::get($t))) {

                // foreach(Session::get($t) as $msg) {
                $msg = Session::get($t);
                switch ($t) {
                    case 'success':
                        $icon = 'ep:success-filled';
                        $shout = 'Success!';
                        break;
                    case 'info':
                        $icon = 'ri:information-fill';
                        $shout = 'Info!';
                        break;
                    case 'warning':
                        $icon = 'ic:round-warning';
                        $shout = 'Warning!';
                        break;
                    case 'danger':
                        $icon = 'carbon:error-filled';
                        $shout = 'Error!';
                        break;
                }

                echo '<div class="py-[18px] mb-3 px-6 font-normal text-sm rounded-md bg-'.$t.'-500 bg-opacity-[14%] text-white">
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <iconify-icon class="text-2xl flex-0 text-'.$t.'-500" icon="'.$icon.'"></iconify-icon>
                            <p class="flex-1 text-'. $t.'-500 font-Inter">
                            <strong>'.$shout.'</strong> '. $msg .'
                            </p>
                            <div class="flex-0 text-xl cursor-pointer text-'.$t.'-500" onclick="dismissAlert(this)">
                                <iconify-icon icon="line-md:close"></iconify-icon>
                            </div>
                        </div>
                    </div>';
                // }
                unset($_SESSION[$t]);
            }
        }
    }

    public function encrypt_string($string_val)
    {

        return openssl_encrypt($string_val, ciphering, encryption_key, options, encryption_iv);
    }

    public function decrypt_string($string_val)
    {

        return openssl_decrypt($string_val, ciphering, decryption_key, options, encryption_iv);

    }
}
