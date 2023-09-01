<?php

class admin_answers_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_questions()
    {
        $error = [];
        if(isset($_POST['sub_cat_id']) && !empty($_POST['sub_cat_id'])) {
            $type = 1;
            $question = '';
            $subcat = parent::decrypt_string($_POST['sub_cat_id']);
            parent::__construct();
            $data = $this->db->prepare("CALL get_question_data(?,?,?)");
            $data->bindParam(1, $type);
            $data->bindParam(2, $question);
            $data->bindParam(3, $subcat);

            $data->execute();
            $result = $data->fetchAll(PDO::FETCH_ASSOC);

            if(count($result) > 0) {
                for ($i=0; $i < count($result); $i++) {
                    $result[$i]['id'] = parent::encrypt_string($result[$i]['id']);
                }
            }

            array_push($error, ["data"=>$result, "etype"=>"success", "msg"=>"Subcategories fetched successfully."]);
            echo json_encode($error);
            die;
        } else {
            array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please select subcategory first."]);
            echo json_encode($error);
            die;
        }
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

    public function get_all_answers()
    {
        $error = [];
        if(isset($_POST['question_id']) && !empty($_POST['question_id'])) {
            parent::__construct();
            $question_id = parent::decrypt_string($_POST['question_id']);
            $ans_name='';
            $type=1;
            $data = $this->db->prepare("CALL get_answer_data(?,?,?)");
            $data->bindParam(1, $question_id);
            $data->bindParam(2, $ans_name);
            $data->bindParam(3, $type);
            $data->execute();
            $result = $data->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {

                for($i = 0; $i < sizeof($result);$i++) {
                    $result[$i]['id'] = parent::encrypt_string($result[$i]['id']);
                    $result[$i]['question_id'] = parent::encrypt_string($result[$i]['question_id']);
                }

                array_push($error, ["data"=>$result,"etype"=>"success", "msg"=>"Answer data fetched successfully."]);
                echo json_encode($error);
                exit;
            } else {
                array_push($error, ["data"=>$result,"etype"=>"danger", "msg"=>"No data available."]);
                echo json_encode($error);
                exit;
            }
        } else {
            array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function add_answers()
    {
        $error = [];

        if(isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['answerName']) && !empty($_POST['answerName'])) {
            $user_id = parent::decrypt_string(parent::decrypt_admin_data("admin_id"));

            $question_id = parent::decrypt_string($_POST['question']);
            $ans_name = trim($_POST['answerName']);
            $type=0;
            parent::__construct();
            $data = $this->db->prepare("CALL get_answer_data(?,?,?)");
            $data->bindParam(1, $question_id);
            $data->bindParam(2, $ans_name);
            $data->bindParam(3, $type);
            $data->execute();
            $result = $data->fetch(PDO::FETCH_ASSOC);
            if($result) {
                array_push($error, ["data" => "", "etype" => "danger", "msg" => "Answer already exist."]);
                echo json_encode($error);
                exit;
            } else {
                parent::__construct();
                $add_answer_data = $this->db->prepare("CALL add_answer_data(?,?,?)");
                $add_answer_data->bindParam(1, $question_id);
                $add_answer_data->bindParam(2, $ans_name);
                $add_answer_data->bindParam(3, $user_id);
                $add_answer_data_result = $add_answer_data->execute();

                if($add_answer_data_result) {
                    array_push($error, ["data" => "", "etype" => "success", "msg" => "Answer successfully added."]);
                    echo json_encode($error);
                    exit;
                } else {
                    array_push($error, ["data" => "", "etype" => "danger", "msg" => "Add answer failed. Try Again! " ] . $add_answer_data->errorInfo()[2]);
                    echo json_encode($error);
                    exit;
                }
            }
        } else {
            array_push($error, ["data" => "", "etype" => "danger", "msg" => "Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function edit_answer_data()
    {
        $error = [];
        if (!empty($_POST["ans_id"]) && !empty($_POST["question_id"]) && !empty($_POST["ans_name"])) {
            $ans_id = parent::decrypt_string($_POST["ans_id"]);
            $question_id = parent::decrypt_string($_POST["question_id"]);

            $type=0;
            $status=0;

            $ans_name = trim($_POST["ans_name"]);
            parent::__construct();
            $data = $this->db->prepare("CALL get_answer_data(?,?,?)");
            $data->bindParam(1, $question_id);
            $data->bindParam(2, $ans_name);
            $data->bindParam(3, $type);
            $data->execute();
            $result = $data->fetch(PDO::FETCH_ASSOC);

            if(isset($result['id']) && $result['id'] != $ans_id) {
                array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Answer already exist."]);
                echo json_encode($error);
                exit;
            } else {
                $type=1;

                parent::__construct();
                $update_answer_data = $this->db->prepare("CALL update_answer(?,?,?,?)");
                $update_answer_data->bindParam(1, $ans_id);
                $update_answer_data->bindParam(2, $ans_name);
                $update_answer_data->bindParam(3, $type);
                $update_answer_data->bindParam(4, $status);
                $update_answer_data_result = $update_answer_data->execute();

                if ($update_answer_data_result) {
                    array_push($error, ["data"=>"","etype"=>"success", "msg"=>"Answer successfully updated."]);
                    echo json_encode($error);
                    exit;
                } else {
                    array_push($error, ["data"=>"","etype"=>"danger", "msg"=>"Update Answer failed. Try Again! ".$update_answer_data->errorInfo()[2]]);
                    echo json_encode($error);
                    exit;
                }
            }
        } else {
            array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please provide all the necessary details."]);
            echo json_encode($error);
            exit;
        }
    }

    public function change_answer_status()
    {
        $error = [];
        if(isset($_POST['msg']) && isset($_POST['type']) && isset($_POST['ans_id'])) {
            if (!empty($_POST['msg'])) {
                if (strtolower($_POST['msg']) != 'yes') {
                    array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please Enter Right Text."]);
                    echo json_encode($error);
                    exit;
                }
            } else {
                array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Please Type Something."]);
                echo json_encode($error);
                exit;
            }

            if(($_POST['type'] == 1 || $_POST['type'] == 2) && !empty($_POST['ans_id'])) {
                if($_POST['type'] == 1) {
                    $status = 0;
                    $success_msg = 'Answer has been successfully activated.';
                    $error_msg = 'Could not activate answer.';
                }

                if($_POST['type'] == 2) {
                    $status = 1;
                    $success_msg = 'Answer has been successfully deleted.';
                    $error_msg = 'Could not delete answer.';
                }

                $answer_id = parent::decrypt_string($_POST['ans_id']);
                $ans_name='';
                $type = 0;

                parent::__construct();
                $data = $this->db->prepare("CALL update_answer(?,?,?,?)");
                $data->bindParam(1, $answer_id);
                $data->bindParam(2, $ans_name);
                $data->bindParam(3, $type);
                $data->bindParam(4, $status);

                $result = $data->execute();
                if ($result) {
                    array_push($error, ["data"=>"", "etype"=>"success", "msg"=>$success_msg]);
                    echo json_encode($error);
                    exit;
                } else {
                    array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>$error_msg]);
                    echo json_encode($error);
                    exit;
                }
            } else {
                array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Data authentication failed."]);
                echo json_encode($error);
                exit;
            }
        } else {
            array_push($error, ["data"=>"", "etype"=>"danger", "msg"=>"Data authentication failed."]);
            echo json_encode($error);
            exit;
        }

    }
}
