<?php

class admin_questions_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_questions($type = 0, $question = '', $subcat = 0)
    {
        parent::__construct();
        $data = $this->db->prepare("CALL get_question_data(?,?,?)");
        $data->bindParam(1, $type);
        $data->bindParam(2, $question);
        $data->bindParam(3, $subcat);

        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // print_r($result);
        // die;

        return $result;
    }

    public function get_sub_cat_data()
    {
        $type = 1;
        $sub_cat_name = 0;

        parent::__construct();
        $data = $this->db->prepare("CALL get_sub_categories(?,?)");
        $data->bindParam(1, $type);
        $data->bindParam(2, $sub_cat_name);
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        for($i = 0; $i < sizeof($result); $i++) {
            $result[$i]['id'] = parent::encrypt_string($result[$i]['id']);
        }

        return $result;
    }

    public function add_questions()
    {
        if(isset($_POST['subCategory']) && !empty($_POST['subCategory']) && isset($_POST['inputType']) && !empty($_POST['inputType']) && isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['questionOrder']) && !empty($_POST['questionOrder'])) {
            // if($_POST['questionType'] == "Common" || $_POST['questionType'] == "Business Specific") {
            if($_POST['inputType'] == "Text" || $_POST['inputType'] == "Radio"|| $_POST['inputType'] == "Checkbox"|| $_POST['inputType'] == "Dropdown"|| $_POST['inputType'] == "Datepicker") {
                // if($_POST['questionType'] == "Business Specific" && empty($_POST['subCategory'])) {
                //     Session::set('danger', 'Please select sub category.');
                //     header("Location: " . URL . admin_link . "/questions");
                //     die;
                // } else {
                $sub_cat_id=parent::decrypt_string($_POST['subCategory']);

                $result = $this->get_all_questions(2, trim($_POST['question']), $sub_cat_id);

                if(sizeof($result) > 0) {
                    Session::set('danger', 'Question already exists.');
                    header("Location: " . URL . admin_link . "/questions");
                    die;
                } else {
                    // if(isset($_POST['subCategory'])) {
                    //     $sub_cat_id=parent::decrypt_string($_POST['subCategory']);
                    // } else {
                    //     $sub_cat_id=0;
                    // }

                    // $question_type = $this->get_question_type($_POST['questionType']);
                    $question_type = 2;
                    $inputType = $this->get_input_type($_POST['inputType']);

                    $question = trim($_POST['question']);
                    $user_id = parent::decrypt_string(parent::decrypt_admin_data("admin_id"));

                    parent::__construct();
                    $add_data = $this->db->prepare("CALL add_question(?,?,?,?,?,?)");
                    $add_data->bindParam(1, $question);
                    $add_data->bindParam(2, $question_type);
                    $add_data->bindParam(3, $inputType);
                    $add_data->bindParam(4, $_POST['questionOrder']);
                    $add_data->bindParam(5, $user_id);
                    $add_data->bindParam(6, $sub_cat_id);
                    $add_data_result = $add_data->execute();

                    if($add_data_result) {
                        Session::set("success", "Question successfully added.");
                        header("location: " . URL . admin_link . "/questions");
                        exit;
                    } else {
                        Session::set('danger', "Add question failed. Try Again! ".$add_data_result->errorInfo()[2]);
                        header("location: " . URL . admin_link . "/questions");
                        exit;
                    }
                }
                // }
            } else {
                Session::set('danger', 'Invalid input type selected.');
                header("Location: " . URL . admin_link . "/questions");
                die;
            }
            // } else {
            //     Session::set('danger', 'Invalid question type selected.');
            //     header("Location: " . URL . admin_link . "/questions");
            //     die;
            // }
        } else {
            Session::set('danger', 'Please provide all the necessary details.');
            header("Location: " . URL . admin_link . "/questions");
            die;
        }
    }

    public function get_question_type($question_type)
    {
        if($question_type == "Common") {
            return 1;
        }

        if($question_type == "Business Specific") {
            return 2;
        }
    }

    public function get_input_type($input_type)
    {
        switch($input_type) {
            case 'Text':
                return 1;
                break;
            case 'Radio':
                return 2;
                break;
            case 'Checkbox':
                return 3;
                break;
            case 'Dropdown':
                return 4;
                break;
            case 'Datepicker':
                return 5;
                break;
            default:
                return 0;
        }
    }

    public function edit_question_data()
    {
        $error = [];
        if(!empty($_POST['q_id']) && isset($_POST['subCategory']) && $_POST['subCategory'] != '-' && isset($_POST['inputType']) && !empty($_POST['inputType']) && isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['questionOrder']) && !empty($_POST['questionOrder'])) {
            // if($_POST['questionType'] == "Common" || $_POST['questionType'] == "Business Specific") {
            if($_POST['inputType'] == "Text" || $_POST['inputType'] == "Radio"|| $_POST['inputType'] == "Checkbox"|| $_POST['inputType'] == "Dropdown"|| $_POST['inputType'] == "Datepicker") {
                // if($_POST['questionType'] == "Business Specific" && $_POST['subCategory'] == '-') {
                //     array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please select sub category."]);
                //     echo json_encode($error);
                //     exit;
                // } else {
                $sub_cat_id=parent::decrypt_string($_POST['subCategory']);

                $result = $this->get_all_questions(2, trim($_POST['question']), $sub_cat_id);
                $question_id = parent::decrypt_string($_POST['q_id']);

                $filtered_data = array_filter($result, function ($ele) use ($question_id) {
                    return $ele['id'] != $question_id;
                });

                if (count($filtered_data) > 0) {
                    array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Question already exists."]);
                    echo json_encode($error);
                    exit;
                } else {
                    // if($_POST['questionType'] == "Business Specific" && !empty($_POST['subCategory']) && $_POST['subCategory'] != '-') {
                    //     $sub_cat_id=parent::decrypt_string($_POST['subCategory']);
                    // } else {
                    //     $sub_cat_id = 0;
                    // }

                    if(is_numeric($_POST['questionOrder']) && $_POST['questionOrder'] > 0) {
                        $questionOrder = $_POST['questionOrder'];
                    } else {
                        $questionOrder = 0;
                    }

                    $type = 1;
                    $question = trim($_POST['question']);
                    // $question_type = $this->get_question_type($_POST['questionType']);
                    $question_type = 2;
                    $input_type = $this->get_input_type($_POST['inputType']);
                    $status = 0;

                    // array_push($error, ["data"=>['type'=>$type, 'question'=>$question, 'question_type'=>$question_type, 'questionOrder'=>$questionOrder, 'sub_cat_id'=>$sub_cat_id, 'input_type'=>$input_type, 'question_id'=>$question_id, 'status'=>$status], "etype"=>"danger", "msg"=>"Please select sub category."]);
                    // echo json_encode($error);
                    // exit;

                    parent::__construct();
                    $update_data = $this->db->prepare("CALL update_question(?,?,?,?,?,?,?,?)");
                    $update_data->bindParam(1, $type);
                    $update_data->bindParam(2, $question);
                    $update_data->bindParam(3, $question_type);
                    $update_data->bindParam(4, $questionOrder);
                    $update_data->bindParam(5, $sub_cat_id);
                    $update_data->bindParam(6, $input_type);
                    $update_data->bindParam(7, $question_id);
                    $update_data->bindParam(8, $status);

                    $update_data_result = $update_data->execute();

                    if($update_data_result) {
                        $updated_questions_list = $this->get_all_questions();
                        if(count($updated_questions_list) > 0) {
                            for($i=0; $i < count($updated_questions_list); $i++) {
                                $updated_questions_list[$i]['id'] = parent::encrypt_string($updated_questions_list[$i]['id']);
                                $updated_questions_list[$i]['sub_category_id'] = parent::encrypt_string($updated_questions_list[$i]['sub_category_id']);
                            }
                        }
                        array_push($error, ["data"=> $updated_questions_list, "etype"=>"success", "msg"=>"Question successfully updated."]);
                        echo json_encode($error);
                        exit;
                    } else {
                        array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Update question failed. Try Again! ".$update_data_result->errorInfo()[2]]);
                        echo json_encode($error);
                        exit;
                    }
                }
                // }
            } else {
                array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Invalid input type selected."]);
                echo json_encode($error);
                exit;
            }
            // } else {
            //     array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Invalid question type selected."]);
            //     echo json_encode($error);
            //     exit;
            // }
        } else {
            array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function change_question_status()
    {
        if(isset($_POST['msg']) && isset($_POST['type']) && isset($_POST['qid'])) {
            if (!empty($_POST['msg'])) {
                if (strtolower($_POST['msg'])!='yes') {
                    Session::set('danger', 'Please Enter Right Text.');
                    header("Location: " . URL . admin_link . "/questions");
                    die;
                }
            } else {
                Session::set('danger', 'Please Type Something.');
                header("Location: " . URL . admin_link . "/questions");
                die;
            }

            if(($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['qid'])) {
                if($_POST['type'] == 1) {
                    $status = 0;
                    $success_msg = 'Question has been successfully activated.';
                    $error_msg = 'Could not activate question.';
                }

                if($_POST['type'] == 2) {
                    $status = 1;
                    $success_msg = 'Question has been successfully deleted.';
                    $error_msg = 'Could not delete question.';
                }

                $type = 0;
                $question_name = '';
                $question_type = 0;
                $question_order = 0;
                $added_by = 0;
                $sub_cat_id = 0;
                $input_type = 0;
                $question_id = parent::decrypt_string($_POST['qid']);

                parent::__construct();
                $data = $this->db->prepare("CALL update_question(?,?,?,?,?,?,?,?)");
                $data->bindParam(1, $type);
                $data->bindParam(2, $question_name);
                $data->bindParam(3, $question_type);
                $data->bindParam(4, $question_order);
                $data->bindParam(5, $sub_cat_id);
                $data->bindParam(6, $input_type);
                $data->bindParam(7, $question_id);
                $data->bindParam(8, $status);

                $result = $data->execute();
                if ($result) {
                    Session::set('success', $success_msg);
                    header("Location: " . URL . admin_link . "/questions");
                    die;
                } else {
                    Session::set('danger', $error_msg);
                    header("Location: " . URL . admin_link . "/questions");
                    die;
                }
            } else {
                Session::set('danger', 'Data authentication failed.');
                header("Location: " . URL . admin_link . "/questions");
                die;
            }
        } else {
            Session::set('danger', 'Data authentication failed.');
            header("Location: " . URL . admin_link . "/questions");
            die;
        }
    }
}
