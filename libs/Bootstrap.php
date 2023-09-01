<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
/**
 *
 */
class Bootstrap
{
    public function __construct()
    {

        $url = isset($_GET['url']) ? $_GET['url'] : 'index';

        $url = rtrim($url, '/');

        $url = explode('/', $url);

        if ($url[0] == 'members' or $url[0] == 'TeamLeader' or $url[0] == 'TeamLeader' or $url[0] == 'Supervisor' or $url[0] == 'Manager') {

            if (isset($url[1])) {
                $file = 'controllers/members/members_' . $url[1] . '.php';
                $file_path = 0;

            } else {

                $file = 'controllers/members/members_index.php';
                $file_path = 1;

            }
        } elseif ($url[0] == admin_link) {

            if (isset($url[1])) {
                $file = 'controllers/admin/admin_' . $url[1] . '.php';
                $file_path = 0;

            } else {

                $file = 'controllers/admin/admin_index.php';
                $file_path = 1;

            }

        } elseif ($url[0] == 'api') {

            if (isset($url[1])) {
                $file = 'controllers/api/api_' . $url[1] . '.php';
                $file_path = 0;

            } else {

                $file = 'controllers/api/api_index.php';
                $file_path = 1;

            }

        } else {
            $url[0] = str_replace("-", "_", $url[0]);
            $file = 'controllers/web/' . $url[0] . '.php';
            $file_path = 1;

        }


        if (file_exists($file)) {

            require $file;

            if ($url[0] == 'members' or $url[0] == 'TeamLeader' or $url[0] == 'Supervisor' or $url[0] == 'Manager') {

                $class = $file_path == 1 ? 'members_index' : 'members' . '_' . $url[1];

                $controller = new $class();
                $controller->loadModel('members', $file_path == 1 ? 'index' : $url[1], 1);

            } elseif ($url[0] == admin_link) {

                $class = $file_path == 1 ? 'admin_index' : 'admin_' . $url[1];

                $controller = new $class();
                $controller->loadModel('admin', $file_path == 1 ? 'index' : $url[1], 1);

            } elseif ($url[0] == 'api') {

                $class = $file_path == 1 ? 'api_index' : 'api_' . $url[1];

                $controller = new $class();
                $controller->loadModel('api', $file_path == 1 ? 'index' : $url[1], 1);

            } else {

                $class = $file_path == 1 ? $url[0] : $url[0];
                $class = str_replace("-", "_", $class);
                $controller = new $class();
                $controller->loadModel($url[0], $url[0], 0);

            }

        } else {

            $this->error();
        }

        if ($url[0] == 'members' or $url[0] == admin_link or  $url[0] == 'api' or $url[0] == 'TeamLeader' or $url[0] == 'TeamLeader' or $url[0] == 'Supervisor' or $url[0] == 'Manager') {

            if (isset($url[3])) {

                if (isset($url[4])) {
                    if (method_exists($controller, $url[2])) {
                        $controller->{$url[2]}($url[3], $url[4]);
                    } else {

                        // echo "here";
                        // $this->error();
                    }
                } else {
                    if (method_exists($controller, $url[2])) {
                        $controller->{$url[2]}($url[3]);
                    } else {

                        // echo "here";
                        // $this->error();
                    }
                }

            } else {

                if (isset($url[2])) {

                    if (method_exists($controller, $url[2])) {
                        $controller->{$url[2]}();
                    } else {
                        // echo "here";
                        $this->error();

                    }

                } else {

                    // echo "here";
                    $controller->index();
                }
            }

        } else {

            if (isset($url[2])) {

                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}($url[2]);
                } else {

                    // echo "here";
                    // $this->error();
                }

            } else {

                if (isset($url[1])) {

                    if (method_exists($controller, $url[1])) {
                        $controller->{$url[1]}();
                    } else {
                        // echo "here";
                        $this->error();

                    }

                } else {

                    // echo "here";
                    $controller->index();
                }
            }

        }

    }

    public function error()
    {
        // echo "here";
        require 'controllers/errorcode.php';
        $controller = new Errorcode();
        $controller->index();
        exit();
    }

}
