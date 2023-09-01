<?php

class admin_job_fee_packages_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_job_fee_packages()
    {
        parent::__construct();
        $type = 0;
        $package_name = '';
        $data = $this->db->prepare("CALL get_job_fee_packages(?,?)");
        $data->bindParam(1, $type);
        $data->bindParam(2, $package_name);

        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        // echo "<pre>";
        // print_r($result);
        // die;
        return $result;
    }

    public function add_job_fee_packages()
    {
        if (!empty($_POST["packageName"]) && !empty($_POST["credits"]) && !empty($_POST["expireIn"]) && isset($_POST["candidates_radio"])) {
            if($_POST["candidates_radio"] === 'unlimited_candidate' || $_POST["candidates_radio"] === 'limited_candidate') {
                if($_POST["candidates_radio"] === 'limited_candidate' && $_POST["candidates"] <= 0) {
                    Session::set('danger', "Candidate must be greater than 0");
                    header("location: " . URL . admin_link . "/job_fee_packages");
                    exit;
                } else {
                    parent::__construct();
                    $type = 1;
                    $package_name = trim($_POST["packageName"]);
                    $data = $this->db->prepare("CALL get_job_fee_packages(?,?)");
                    $data->bindParam(1, $type);
                    $data->bindParam(2, $package_name);

                    $data->execute();
                    $result = $data->fetchAll(PDO::FETCH_ASSOC);
                    if (sizeof($result) > 0) {
                        Session::set("danger", "Same package registered with given package name.");
                        header("location: " . URL . admin_link . "/job_fee_packages");
                        exit;
                    } else {
                        switch($_POST['candidates_radio']) {
                            case 'unlimited_candidate':
                                $candidates=0;
                                break;
                            case 'limited_candidate':
                                $candidates=$_POST['candidates'];
                                break;
                            default:
                                die;
                        }

                        // Add Package details
                        parent::__construct();
                        $add_package = $this->db->prepare("CALL add_job_fee_package(?,?,?,?)");
                        $add_package->bindParam(1, $package_name);
                        $add_package->bindParam(2, $_POST["credits"]);
                        $add_package->bindParam(3, $candidates);
                        $add_package->bindParam(4, $_POST["expireIn"]);
                        $add_package_result = $add_package->execute();

                        if ($add_package_result) {
                            Session::set('success', "Job fee package successfully added.");
                            header("location: " . URL . admin_link . "/job_fee_packages");
                            exit;
                        } else {
                            Session::set('danger', "Add job fee package failed. Try Again! ".$add_package->errorInfo()[2]);
                            header("location: " . URL . admin_link . "/job_fee_packages");
                            exit;
                        }
                    }
                }
            } else {
                Session::set('danger', "Invalid candidate selected.");
                header("location: " . URL . admin_link . "/job_fee_packages");
                exit;
            }
        } else {
            Session::set('danger', "Please provide all the necessary details.");
            header("location: " . URL . admin_link . "/job_fee_packages");
            exit;
        }
    }

    public function edit_job_fee_packages_data()
    {
        $error = [];

        if(!empty($_POST["pid"]) && !empty($_POST["packageName"]) && !empty($_POST["credits"]) && !empty($_POST["expireIn"]) && isset($_POST["candidates_radio"])) {
            if($_POST["candidates_radio"] === 'unlimited_candidate' || $_POST["candidates_radio"] === 'limited_candidate') {
                if($_POST["candidates_radio"] === 'limited_candidate' && $_POST["candidates"] <= 0) {
                    array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Candidate must be greater than 0"]);
                    echo json_encode($error);
                    exit;
                } else {
                    $package_id = parent::decrypt_string($_POST["pid"]);

                    parent::__construct();
                    $type = 1;
                    $package_name = trim($_POST["packageName"]);
                    $package_data = $this->db->prepare("CALL get_job_fee_packages(?,?)");
                    $package_data->bindParam(1, $type);
                    $package_data->bindParam(2, $package_name);

                    $package_data->execute();
                    $package_result = $package_data->fetchAll(PDO::FETCH_ASSOC);

                    if($package_result) {
                        $filtered_data = array_filter($package_result, function ($ele) use ($package_id) {
                            return $ele['id'] != $package_id;
                        });

                        if (count($filtered_data) > 0) {
                            array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Same package registered with given package name."]);
                            echo json_encode($error);
                            exit;
                        } else {
                            switch($_POST['candidates_radio']) {
                                case 'unlimited_candidate':
                                    $candidates=0;
                                    break;
                                case 'limited_candidate':
                                    $candidates=$_POST['candidates'];
                                    break;
                                default:
                                    die;
                            }

                            // Update Country details
                            parent::__construct();
                            $package_name = trim($_POST["packageName"]);

                            $edit_package = $this->db->prepare("CALL update_job_fee_package(?,?,?,?,?)");
                            $edit_package->bindParam(1, $package_id);
                            $edit_package->bindParam(2, $package_name);
                            $edit_package->bindParam(3, $_POST["credits"]);
                            $edit_package->bindParam(4, $candidates);
                            $edit_package->bindParam(5, $_POST["expireIn"]);
                            $edit_package_result = $edit_package->execute();

                            if ($edit_package_result) {
                                array_push($error, ["data"=>"","etype"=>"success", "msg"=>"Job fee package successfully updated."]);
                                echo json_encode($error);
                                exit;
                            } else {
                                array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Update job fee package failed. Try Again! ".$edit_package->errorInfo()[2]]);
                                echo json_encode($error);
                                exit;
                            }
                        }
                    } else {
                        array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Something went wrong. Try Again! ".$package_data->errorInfo()[2]]);
                        echo json_encode($error);
                        exit;
                    }
                }
            } else {
                array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Invalid candidate selected."]);
                echo json_encode($error);
                exit;
            }
        } else {
            array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function change_job_fee_packages_status()
    {
        if(isset($_POST['msg']) && isset($_POST['type']) && isset($_POST['pid'])) {
            if (!empty($_POST['msg'])) {
                if (strtolower($_POST['msg']) != 'yes') {
                    Session::set('danger', 'Please Enter Right Text.');
                    header("Location: " . URL . admin_link . "/job_fee_packages");
                    die;
                }
            } else {
                Session::set('danger', 'Please Type Something.');
                header("Location: " . URL . admin_link . "/job_fee_packages");
                die;
            }

            if(($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['pid'])) {
                parent::__construct();
                $package_id = parent::decrypt_string($_POST['pid']);

                if($_POST['type'] == 1) {
                    $status = 0;
                    $success_msg = 'Package has been successfully activated.';
                    $error_msg = 'Could not activate package.';
                }

                if($_POST['type'] == 2) {
                    $status = 1;
                    $success_msg = 'Package has been successfully deleted.';
                    $error_msg = 'Could not delete package.';
                }

                $data = $this->db->prepare("CALL update_job_fee_package_status(?,?)");
                $data->bindParam(1, $package_id);
                $data->bindParam(2, $status);

                $result = $data->execute();
                if ($result) {
                    Session::set('success', $success_msg);
                    header("Location: " . URL . admin_link . "/job_fee_packages");
                    die;
                } else {
                    Session::set('danger', $error_msg);
                    header("Location: " . URL . admin_link . "/job_fee_packages");
                    die;
                }
            } else {
                Session::set('danger', 'Data authentication failed.');
                header("Location: " . URL . admin_link . "/job_fee_packages");
                die;
            }
        } else {
            Session::set('danger', 'Data authentication failed.');
            header("Location: " . URL . admin_link . "/job_fee_packages");
            die;
        }
    }
}
