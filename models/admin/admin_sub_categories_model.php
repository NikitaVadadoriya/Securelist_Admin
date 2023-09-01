<?php

class admin_sub_categories_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_sub_categories()
    {
        $type=0;
        $sub_cat_name='';
        parent::__construct();
        $data = $this->db->prepare("Call get_sub_categories(?,?)");
        $data->bindParam(1, $type);
        $data->bindParam(2, $sub_cat_name);
        $data->execute();

        $data_result = $data->fetchALL(PDO::FETCH_ASSOC);
        // echo "<pre>";
        // print_r($data_result);
        // die;
        return $data_result;
    }

    public function add_sub_category()
    {
        if(isset($_POST['subCategoryName']) && !empty($_POST['subCategoryName']) && isset($_POST['credits']) && !empty($_POST['credits'])) {
            if(preg_match("/^[a-zA-Z0-9()&,\s\/-]+$/", $_POST['subCategoryName'])) {
                if(is_numeric($_POST['credits'])) {
                    $type=2;
                    parent::__construct();
                    $data = $this->db->prepare("Call get_sub_categories(?,?)");
                    $data->bindParam(1, $type);
                    $data->bindParam(2, $_POST['subCategoryName']);
                    $data->execute();

                    $data_result = $data->fetch(PDO::FETCH_ASSOC);

                    if($data_result) {
                        Session::set('danger', 'Sub category already exists.');
                        header("Location: " . URL . admin_link . "/sub_categories");
                        die;
                    } else {
                        $category_id = 1; // Security
                        parent::__construct();
                        $add_sub_cat = $this->db->prepare("Call add_sub_category(?,?,?)");
                        $add_sub_cat->bindParam(1, $_POST['subCategoryName']);
                        $add_sub_cat->bindParam(2, $category_id);
                        $add_sub_cat->bindParam(3, $_POST['credits']);

                        $add_sub_cat->execute();

                        if ($add_sub_cat) {
                            Session::set("success", "Sub category successfully added.");
                            header("location: " . URL . admin_link . "/sub_categories");
                            exit;
                        } else {
                            Session::set('danger', "Add sub category failed. Try Again! ".$add_sub_cat->errorInfo()[2]);
                            header("location: " . URL . admin_link . "/sub_categories");
                            exit;
                        }
                    }
                } else {
                    Session::set('danger', 'Please enter valid credits.');
                    header("Location: " . URL . admin_link . "/sub_categories");
                    die;
                }
            } else {
                Session::set('danger', 'Please enter valid sub category name.');
                header("Location: " . URL . admin_link . "/sub_categories");
                die;
            }
        } else {
            Session::set('danger', 'Please enter sub category name.');
            header("Location: " . URL . admin_link . "/sub_categories");
            die;
        }
    }

    public function edit_sub_cat_data()
    {
        $error = [];
        if (!empty($_POST["sub_cat_id"]) && !empty($_POST["sub_cat_name"]) && !empty($_POST['credits'])) {
            if(preg_match("/^[a-zA-Z0-9()&,\s\/-]+$/", $_POST['sub_cat_name'])) {
                if(is_numeric($_POST['credits'])) {
                    $sub_cat_id = parent::decrypt_string($_POST["sub_cat_id"]);

                    $type=2;
                    parent::__construct();
                    $data = $this->db->prepare("Call get_sub_categories(?,?)");
                    $data->bindParam(1, $type);
                    $data->bindParam(2, $_POST['sub_cat_name']);
                    $data->execute();

                    $sub_cat_data = $data->fetch(PDO::FETCH_ASSOC);

                    if(isset($sub_cat_data['id']) && $sub_cat_data['id'] != $sub_cat_id) {
                        array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Sub category already exists."]);
                        echo json_encode($error);
                        exit;
                    } else {
                        // Update Country details
                        parent::__construct();
                        $type = 1;
                        $category_id = 1; // Security
                        $sub_cat_name = trim($_POST["sub_cat_name"]);
                        $status = 0;

                        $update_sub_cat = $this->db->prepare("CALL update_sub_category(?,?,?,?,?,?)");
                        $update_sub_cat->bindParam(1, $type);
                        $update_sub_cat->bindParam(2, $sub_cat_id);
                        $update_sub_cat->bindParam(3, $category_id);
                        $update_sub_cat->bindParam(4, $sub_cat_name);
                        $update_sub_cat->bindParam(5, $status);
                        $update_sub_cat->bindParam(6, $_POST['credits']);

                        $update_sub_cat_result = $update_sub_cat->execute();

                        if ($update_sub_cat_result) {
                            array_push($error, ["data"=>"","etype"=>"success", "msg"=>"Sub category successfully updated."]);
                            echo json_encode($error);
                            exit;
                        } else {
                            array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Update sub category failed. Try Again! ".$update_sub_cat->errorInfo()[2]]);
                            echo json_encode($error);
                            exit;
                        }
                    }
                } else {
                    array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Please enter valid credits."]);
                    echo json_encode($error);
                    exit;
                }
            } else {
                array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Please enter valid sub category name."]);
                echo json_encode($error);
                exit;
            }
        } else {
            array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function change_sub_cat_status()
    {
        if(isset($_POST['msg']) && isset($_POST['type']) && isset($_POST['sub_cat_name'])) {
            if (!empty($_POST['msg'])) {
                if (strtolower($_POST['msg'])!='yes') {
                    Session::set('danger', 'Please Enter Right Text.');
                    header("Location: " . URL . admin_link . "/sub_categories");
                    die;
                }
            } else {
                Session::set('danger', 'Please Type Something.');
                header("Location: " . URL . admin_link . "/sub_categories");
                die;
            }

            if(($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['sub_cat_name'])) {
                if($_POST['type'] == 1) {
                    $status = 0;
                    $success_msg = 'Sub category has been successfully activated.';
                    $error_msg = 'Could not activate sub category.';
                }

                if($_POST['type'] == 2) {
                    $status = 1;
                    $success_msg = 'Sub category has been successfully deleted.';
                    $error_msg = 'Could not delete sub category.';
                }

                $type = 0;
                $sub_cat_id = 0;
                $cat_id = 0;
                $sub_cat_name = parent::decrypt_string($_POST['sub_cat_name']);
                $credits = 0;

                parent::__construct();
                $data = $this->db->prepare("CALL update_sub_category(?,?,?,?,?,?)");
                $data->bindParam(1, $type);
                $data->bindParam(2, $sub_cat_id);
                $data->bindParam(3, $cat_id);
                $data->bindParam(4, $sub_cat_name);
                $data->bindParam(5, $status);
                $data->bindParam(6, $credits);

                $result = $data->execute();
                if ($result) {
                    Session::set('success', $success_msg);
                    header("Location: " . URL . admin_link . "/sub_categories");
                    die;
                } else {
                    Session::set('danger', $error_msg);
                    header("Location: " . URL . admin_link . "/sub_categories");
                    die;
                }
            } else {
                Session::set('danger', 'Data authentication failed.');
                header("Location: " . URL . admin_link . "/sub_categories");
                die;
            }
        } else {
            Session::set('danger', 'Data authentication failed.');
            header("Location: " . URL . admin_link . "/sub_categories");
            die;
        }
    }
}
