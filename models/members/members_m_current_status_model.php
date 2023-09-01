<?php

class members_m_current_status_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_cdatas()
    {

        $user_id = Session::get('user_id');

        parent::__construct();
        $data = $this->db->prepare("call get_zone_by_manager(?)");
        $data->bindparam(1, $user_id);
        $data->execute();
        $result["all_zone"] = $data->fetchAll(PDO::FETCH_ASSOC);

        if (in_array('0', $_POST["user_zone"]) && in_array('0', $_POST["user_area"]) && in_array('0', $_POST["user_locality"]) && in_array('0', $_POST["user_supervisor"])) {

            parent::__construct();
            $data = $this->db->query("call get_supervisor_by_manager('".$user_id."')");
            $superviosr_list = $data->fetchAll(PDO::FETCH_ASSOC);

            foreach ($superviosr_list as $superviosr) {
                parent::__construct();
                $data = $this->db->query("call get_area_by_supervisor('".$superviosr["id"]."')");
                $area_list= $data->fetchAll(PDO::FETCH_ASSOC);

                foreach ($area_list as $area) {
                    parent::__construct();
                    $data = $this->db->query("call get_locality_by_area('".$area["id"]."')");
                    $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                    $locality_list=$result_array;

                    foreach ($locality_list as $locality) {
                        parent::__construct();
                        $data = $this->db->query("call get_report_data('".$locality["id"]."','".$superviosr["id"]."','".date("Y/m/d")."')");
                        $tbl_data = $data->fetchAll(PDO::FETCH_ASSOC);
                        $tbl_data[0]['locality'] = $result_array[0]["locality"];
                        $result['report_data'][]=$tbl_data[0];
                    }
                }
            }

            foreach ($result["all_zone"] as $zone) {
                parent::__construct();
                $data = $this->db->query("call get_area_byzone('".$zone["id"]."')");
                $area_list[] = $data->fetchAll(PDO::FETCH_ASSOC);
            }
            /*echo "<pre>";
        	print_r($area_list);
        	exit();*/
            /*echo "<pre>";
        	print_r($area_list);*/


        } else {
            $date = date('Y/m/d');
            if (in_array('0', $_POST['user_zone'])) {
                if (in_array('0', $_POST['user_area'])) {
                    if (in_array('0', $_POST['user_locality'])) {
                        parent::__construct();
                        $data1 = $this->db->prepare("call get_zone_by_manager(?)");
                        $data1->bindparam(1, $user_id);
                        $data1->execute();
                        $result1 = $data1->fetchAll(PDO::FETCH_ASSOC);

                        for ($j=0; $j < sizeof($result1); $j++) {
                            parent::__construct();
                            $data2 = $this->db->prepare("call get_area_byzone(?)");
                            $data2->bindparam(1, $result1[$j]['id']);
                            $data2->execute();
                            $result2 = $data2->fetchAll(PDO::FETCH_ASSOC);

                            for ($k=0; $k < sizeof($result2); $k++) {
                                parent::__construct();
                                $data3 = $this->db->prepare("call get_locality_by_area(?)");
                                $data3->bindparam(1, $result2[$k]['id']);
                                $data3->execute();
                                $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                for ($l=0; $l < sizeof($result3); $l++) {
                                    for ($m=0; $m < sizeof($_POST['user_supervisor']); $m++) {
                                        parent::__construct();
                                        $data4 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data4->bindparam(1, $result3[$l]['id']);
                                        $data4->bindparam(2, $_POST['user_supervisor'][$m]);
                                        $data4->bindparam(3, $date);
                                        $data4->execute();
                                        $result4 = $data4->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$result3[$l]['id']."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result4[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result4[0];
                                    }
                                }
                            }
                        }
                    } else {
                        for ($j=0; $j < sizeof($_POST['user_locality']); $j++) {
                            for ($k=0; $k < sizeof($_POST['user_supervisor']); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    parent::__construct();
                                    $data1 = $this->db->prepare("call get_zone_by_manager(?)");
                                    $data1->bindparam(1, $user_id);
                                    $data1->execute();
                                    $result1 = $data1->fetchAll(PDO::FETCH_ASSOC);

                                    for ($l=0; $l < sizeof($result1); $l++) {
                                        parent::__construct();
                                        $data2 = $this->db->prepare("call get_area_byzone(?)");
                                        $data2->bindparam(1, $result1[$l]['id']);
                                        $data2->execute();
                                        $result2 = $data2->fetchAll(PDO::FETCH_ASSOC);

                                        for ($m=0; $m < sizeof($result2); $m++) {
                                            parent::__construct();
                                            $data3 = $this->db->query("call get_supervisor_by_area('".$result2[$m]['id']."')");
                                            $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                            for ($n=0; $n < sizeof($result3); $n++) {
                                                parent::__construct();
                                                $data4 = $this->db->prepare("call get_report_data(?,?,?)");
                                                $data4->bindparam(1, $_POST['user_locality'][$j]);
                                                $data4->bindparam(2, $result3[$n]['id']);
                                                $data4->bindparam(3, $date);
                                                $data4->execute();
                                                $result4 = $data4->fetchAll(PDO::FETCH_ASSOC);

                                                parent::__construct();
                                                $local = $this->db->prepare("SELECT * FROM localities where id= ".$_POST['user_locality'][$j]."");
                                                $local->execute();
                                                $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                                $result4[0]['locality'] = $local_data[0]["locality"];
                                                $result['report_data'][]=$result4[0];
                                            }
                                        }
                                    }
                                } else {
                                    parent::__construct();
                                    $data4 = $this->db->prepare("call get_report_data(?,?,?)");
                                    $data4->bindparam(1, $_POST['user_locality'][$j]);
                                    $data4->bindparam(2, $_POST['user_supervisor'][$k]);
                                    $data4->bindparam(3, $date);
                                    $data4->execute();
                                    $result4 = $data4->fetchAll(PDO::FETCH_ASSOC);

                                    parent::__construct();
                                    $local = $this->db->prepare("SELECT * FROM localities where id= ".$_POST['user_locality'][$j]."");
                                    $local->execute();
                                    $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                    $result4[0]['locality'] = $local_data[0]["locality"];
                                    $result['report_data'][]=$result4[0];
                                }
                            }
                        }
                    }
                } else {
                    for ($j=0; $j < sizeof($_POST['user_area']); $j++) {
                        if (in_array('0', $_POST['user_locality'])) {
                            parent::__construct();
                            $data1 = $this->db->query("call get_locality_by_area('".$_POST['user_area'][$j]."')");
                            $result1 = $data1->fetchAll(PDO::FETCH_ASSOC);

                            for ($k=0; $k < sizeof($result1); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    parent::__construct();
                                    $data2 = $this->db->query("call get_supervisor_by_area('".$_POST['user_area'][$j]."')");
                                    $result2 = $data2->fetchAll(PDO::FETCH_ASSOC);

                                    for ($l=0; $l < sizeof($result2); $l++) {
                                        parent::__construct();
                                        $data3 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data3->bindparam(1, $result1[$k]['id']);
                                        $data3->bindparam(2, $result2[$l]['id']);
                                        $data3->bindparam(3, $date);
                                        $data3->execute();
                                        $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$result1[$k]['id']."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result3[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result3[0];
                                    }
                                } else {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        parent::__construct();
                                        $data3 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data3->bindparam(1, $result1[$k]['id']);
                                        $data3->bindparam(2, $_POST['user_supervisor'][$l]);
                                        $data3->bindparam(3, $date);
                                        $data3->execute();
                                        $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$result1[$k]['id']."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result3[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result3[0];
                                    }
                                }
                            }
                        } else {
                            for ($k=0; $k < sizeof($_POST['user_locality']); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    parent::__construct();
                                    $data2 = $this->db->query("call get_supervisor_by_area('".$_POST['user_area'][$j]."')");
                                    $result2 = $data2->fetchAll(PDO::FETCH_ASSOC);

                                    for ($l=0; $l < sizeof($result2); $l++) {
                                        parent::__construct();
                                        $data3 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data3->bindparam(1, $_POST['user_locality'][$k]);
                                        $data3->bindparam(2, $result2[$l]['id']);
                                        $data3->bindparam(3, $date);
                                        $data3->execute();
                                        $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$_POST['user_locality'][$k]."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result3[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result3[0];
                                    }
                                } else {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        parent::__construct();
                                        $data3 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data3->bindparam(1, $_POST['user_locality'][$k]);
                                        $data3->bindparam(2, $_POST['user_supervisor'][$l]);
                                        $data3->bindparam(3, $date);
                                        $data3->execute();
                                        $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$_POST['user_locality'][$k]."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result3[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result3[0];
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                if (in_array('0', $_POST['user_area'])) {
                    if (in_array('0', $_POST['user_locality'])) {
                        for ($j=0; $j < sizeof($_POST['user_zone']); $j++) {
                            parent::__construct();
                            $data2 = $this->db->prepare("call get_area_byzone(?)");
                            $data2->bindparam(1, $_POST['user_zone'][$j]);
                            $data2->execute();
                            $result2 = $data2->fetchAll(PDO::FETCH_ASSOC);

                            for ($k=0; $k < sizeof($result2); $k++) {
                                parent::__construct();
                                $data3 = $this->db->prepare("call get_locality_by_area(?)");
                                $data3->bindparam(1, $result2[$k]['id']);
                                $data3->execute();
                                $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                for ($l=0; $l < sizeof($result3); $l++) {
                                    for ($m=0; $m < sizeof($_POST['user_supervisor']); $m++) {
                                        parent::__construct();
                                        $data4 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data4->bindparam(1, $result3[$l]['id']);
                                        $data4->bindparam(2, $_POST['user_supervisor'][$m]);
                                        $data4->bindparam(3, $date);
                                        $data4->execute();
                                        $result4 = $data4->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$result3[$l]['id']."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result4[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result4[0];
                                    }
                                }
                            }
                        }
                    } else {
                        for ($j=0; $j < sizeof($_POST['user_locality']); $j++) {
                            for ($k=0; $k < sizeof($_POST['user_supervisor']); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    for ($l=0; $l < sizeof($_POST['user_zone']); $l++) {
                                        parent::__construct();
                                        $data2 = $this->db->prepare("call get_area_byzone(?)");
                                        $data2->bindparam(1, $_POST['user_zone'][$l]);
                                        $data2->execute();
                                        $result2 = $data2->fetchAll(PDO::FETCH_ASSOC);

                                        for ($m=0; $m < sizeof($result2); $m++) {
                                            parent::__construct();
                                            $data3 = $this->db->query("call get_supervisor_by_area('".$result2[$m]['id']."')");
                                            $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                            for ($n=0; $n < sizeof($result3); $n++) {
                                                parent::__construct();
                                                $data4 = $this->db->prepare("call get_report_data(?,?,?)");
                                                $data4->bindparam(1, $_POST['user_locality'][$j]);
                                                $data4->bindparam(2, $result3[$n]['id']);
                                                $data4->bindparam(3, $date);
                                                $data4->execute();
                                                $result4 = $data4->fetchAll(PDO::FETCH_ASSOC);

                                                parent::__construct();
                                                $local = $this->db->prepare("SELECT * FROM localities where id= ".$_POST['user_locality'][$j]."");
                                                $local->execute();
                                                $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                                $result4[0]['locality'] = $local_data[0]["locality"];
                                                $result['report_data'][]=$result4[0];
                                            }
                                        }
                                    }
                                } else {
                                    parent::__construct();
                                    $data4 = $this->db->prepare("call get_report_data(?,?,?)");
                                    $data4->bindparam(1, $_POST['user_locality'][$j]);
                                    $data4->bindparam(2, $_POST['user_supervisor'][$k]);
                                    $data4->bindparam(3, $date);
                                    $data4->execute();
                                    $result4 = $data4->fetchAll(PDO::FETCH_ASSOC);

                                    parent::__construct();
                                    $local = $this->db->prepare("SELECT * FROM localities where id= ".$_POST['user_locality'][$j]."");
                                    $local->execute();
                                    $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                    $result4[0]['locality'] = $local_data[0]["locality"];
                                    $result['report_data'][]=$result4[0];
                                }
                            }
                        }
                    }
                } else {
                    for ($j=0; $j < sizeof($_POST['user_area']); $j++) {
                        if (in_array('0', $_POST['user_locality'])) {
                            parent::__construct();
                            $data1 = $this->db->query("call get_locality_by_area('".$_POST['user_area'][$j]."')");
                            $result1 = $data1->fetchAll(PDO::FETCH_ASSOC);

                            for ($k=0; $k < sizeof($result1); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    parent::__construct();
                                    $data2 = $this->db->query("call get_supervisor_by_area('".$_POST['user_area'][$j]."')");
                                    $result2 = $data2->fetchAll(PDO::FETCH_ASSOC);

                                    for ($l=0; $l < sizeof($result2); $l++) {
                                        parent::__construct();
                                        $data3 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data3->bindparam(1, $result1[$k]['id']);
                                        $data3->bindparam(2, $result2[$l]['id']);
                                        $data3->bindparam(3, $date);
                                        $data3->execute();
                                        $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$result1[$k]['id']."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result3[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result3[0];
                                    }
                                } else {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        parent::__construct();
                                        $data3 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data3->bindparam(1, $result1[$k]['id']);
                                        $data3->bindparam(2, $_POST['user_supervisor'][$l]);
                                        $data3->bindparam(3, $date);
                                        $data3->execute();
                                        $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$result1[$k]['id']."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result3[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result3[0];
                                    }
                                }
                            }
                        } else {
                            for ($k=0; $k < sizeof($_POST['user_locality']); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    parent::__construct();
                                    $data2 = $this->db->query("call get_supervisor_by_area('".$_POST['user_area'][$j]."')");
                                    $result2 = $data2->fetchAll(PDO::FETCH_ASSOC);

                                    for ($l=0; $l < sizeof($result2); $l++) {
                                        parent::__construct();
                                        $data3 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data3->bindparam(1, $_POST['user_locality'][$k]);
                                        $data3->bindparam(2, $result2[$l]['id']);
                                        $data3->bindparam(3, $date);
                                        $data3->execute();
                                        $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$_POST['user_locality'][$k]."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result3[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result3[0];
                                    }
                                } else {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        parent::__construct();
                                        $data3 = $this->db->prepare("call get_report_data(?,?,?)");
                                        $data3->bindparam(1, $_POST['user_locality'][$k]);
                                        $data3->bindparam(2, $_POST['user_supervisor'][$l]);
                                        $data3->bindparam(3, $date);
                                        $data3->execute();
                                        $result3 = $data3->fetchAll(PDO::FETCH_ASSOC);

                                        parent::__construct();
                                        $local = $this->db->prepare("SELECT * FROM localities where id= ".$_POST['user_locality'][$j]."");
                                        $local->execute();
                                        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

                                        $result3[0]['locality'] = $local_data[0]["locality"];
                                        $result['report_data'][]=$result3[0];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        /*echo "<pre>";
        print_r($result);
        exit();*/
        return $result;
    }

    public function get_cdata()
    {
        $user_id = Session::get('user_id');

        parent::__construct();
        $data = $this->db->prepare("call get_zone_by_manager(?)");
        $data->bindparam(1, $user_id);
        $data->execute();
        $result["all_zone"] = $data->fetchAll(PDO::FETCH_ASSOC);

        $date = date('Y/m/d');
        $user_id = Session::get('user_id');

        if (in_array('0', $_POST['user_zone'])) {
            if (in_array('0', $_POST['user_area'])) {
                if (in_array('0', $_POST['user_locality'])) {
                    if (in_array('0', $_POST['user_supervisor'])) {
                        $zone_data = $this->get_zone_by_manager($user_id);

                        for ($i=0; $i < sizeof($zone_data); $i++) {
                            $area_data = $this->get_all_area($zone_data[$i]['id']);

                            for ($j=0; $j < sizeof($area_data); $j++) {
                                $locality_data = $this->get_all_locality($area_data[$j]['id']);

                                for ($k=0; $k < sizeof($locality_data); $k++) {
                                    $super_data = $this->get_supervisor_by_manager($user_id);

                                    for ($l=0; $l < sizeof($super_data); $l++) {
                                        $report_data = $this->get_all_locality_by_area($area_data[$j]['id'], $locality_data[$k]['id'], $super_data[$l]['id']);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                        /*$report_data = $this->get_report_data($locality_data[$k]['id'],$super_data[$l]['id']);
                                        $local_data = $this->get_locality_data($locality_data[$k]['id']);

                                        $report_data[0]['locality'] = $local_data[0]['locality'];
                                        $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data[0];*/
                                    }
                                }
                            }
                        }
                    } else {
                        $zone_data = $this->get_zone_by_manager($user_id);

                        for ($i=0; $i < sizeof($zone_data); $i++) {
                            $area_data = $this->get_all_area($zone_data[$i]['id']);

                            for ($j=0; $j < sizeof($area_data); $j++) {
                                $locality_data = $this->get_all_locality($area_data[$j]['id']);

                                for ($k=0; $k < sizeof($locality_data); $k++) {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        $report_data = $this->get_all_locality_by_area($area_data[$j]['id'], $locality_data[$k]['id'], $_POST['user_supervisor'][$l]);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if (in_array('0', $_POST['user_supervisor'])) {
                        $zone_data = $this->get_zone_by_manager($user_id);

                        for ($i=0; $i < sizeof($zone_data); $i++) {
                            $area_data = $this->get_all_area($zone_data[$i]['id']);

                            for ($j=0; $j < sizeof($area_data); $j++) {
                                for ($k=0; $k < sizeof($_POST['user_locality']); $k++) {
                                    $super_data = $this->get_supervisor_by_manager($user_id);

                                    for ($l=0; $l < sizeof($super_data); $l++) {
                                        $report_data = $this->get_all_locality_by_area($area_data[$j]['id'], $_POST['user_locality'][$k], $super_data[$l]['id']);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $zone_data = $this->get_zone_by_manager($user_id);

                        for ($i=0; $i < sizeof($zone_data); $i++) {
                            $area_data = $this->get_all_area($zone_data[$i]['id']);

                            for ($j=0; $j < sizeof($area_data); $j++) {
                                for ($k=0; $k < sizeof($_POST['user_locality']); $k++) {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        $report_data = $this->get_all_locality_by_area($area_data[$j]['id'], $_POST['user_locality'][$k], $_POST['user_supervisor'][$l]);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $zone_data = $this->get_zone_by_manager($user_id);

                for ($i=0; $i < sizeof($zone_data); $i++) {
                    for ($j=0; $j < sizeof($_POST['user_area']); $j++) {
                        if (in_array('0', $_POST['user_locality'])) {
                            $locality_data = $this->get_all_locality($_POST['user_area'][$j]);

                            for ($k=0; $k < sizeof($locality_data); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    $super_data = $this->get_supervisor_by_manager($user_id);

                                    for ($l=0; $l < sizeof($super_data); $l++) {
                                        $report_data = $this->get_all_locality_by_area($_POST['user_area'][$j], $locality_data[$k]['id'], $super_data[$l]['id']);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                } else {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        $report_data = $this->get_all_locality_by_area($_POST['user_area'][$j], $locality_data[$k]['id'], $_POST['user_supervisor'][$l]);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        } else {
                            for ($k=0; $k < sizeof($_POST['user_locality']); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    $super_data = $this->get_supervisor_by_manager($user_id);

                                    for ($l=0; $l < sizeof($super_data); $l++) {
                                        $report_data = $this->get_all_locality_by_area($_POST['user_area'][$j], $_POST['user_locality'][$k], $super_data[$l]['id']);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                } else {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        $report_data = $this->get_all_locality_by_area($_POST['user_area'][$j], $_POST['user_locality'][$k], $_POST['user_supervisor'][$l]);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            if (in_array('0', $_POST['user_area'])) {
                if (in_array('0', $_POST['user_locality'])) {
                    if (in_array('0', $_POST['user_supervisor'])) {

                        for ($i=0; $i < sizeof($_POST['user_zone']); $i++) {
                            //echo "Zone : ".$_POST['user_zone'][$i]."<br>";
                            $area_data = $this->get_all_area($_POST['user_zone'][$i]);

                            for ($j=0; $j < sizeof($area_data); $j++) {
                                //echo "Area : ".$area_data[$j]['id']."<br>";
                                $locality_data = $this->get_all_locality($area_data[$j]['id']);

                                for ($k=0; $k < sizeof($locality_data); $k++) {
                                    //echo "Locality : ".$locality_data[$k]['locality']."<br>";
                                    $super_data = $this->get_supervisor_by_manager($user_id);
                                    //echo "<pre>";
                                    //print_r($super_data);
                                    for ($l=0; $l < sizeof($super_data); $l++) {
                                        //echo "Supervisor : ".$super_data[$l]['id']."<br>";
                                        $report_data = $this->get_all_locality_by_area($area_data[$j]['id'], $locality_data[$k]['id'], $super_data[$l]['id']);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        for ($i=0; $i < sizeof($_POST['user_zone']); $i++) {
                            $area_data = $this->get_all_area($_POST['user_zone'][$i]);

                            for ($j=0; $j < sizeof($area_data); $j++) {
                                $locality_data = $this->get_all_locality($area_data[$j]['id']);

                                for ($k=0; $k < sizeof($locality_data); $k++) {
                                    $super_data = $this->get_supervisor_by_manager($user_id);

                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        $report_data = $this->get_all_locality_by_area($area_data[$j]['id'], $locality_data[$k]['id'], $_POST['user_supervisor'][$l]);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if (in_array('0', $_POST['user_supervisor'])) {
                        for ($i=0; $i < sizeof($_POST['user_zone']); $i++) {
                            $area_data = $this->get_all_area($_POST['user_zone'][$i]);

                            for ($j=0; $j < sizeof($area_data); $j++) {
                                for ($k=0; $k < sizeof($_POST['user_locality']); $k++) {
                                    $super_data = $this->get_supervisor_by_manager($user_id);

                                    for ($l=0; $l < sizeof($super_data); $l++) {
                                        $report_data = $this->get_all_locality_by_area($area_data[$j]['id'], $_POST['user_locality'][$k], $super_data[$l]['id']);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        for ($i=0; $i < sizeof($_POST['user_zone']); $i++) {
                            $area_data = $this->get_all_area($_POST['user_zone'][$i]);

                            for ($j=0; $j < sizeof($area_data); $j++) {
                                for ($k=0; $k < sizeof($_POST['user_locality']); $k++) {
                                    $super_data = $this->get_supervisor_by_manager($user_id);

                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        $report_data = $this->get_all_locality_by_area($area_data[$j]['id'], $_POST['user_locality'][$k], $_POST['user_supervisor'][$l]);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                for ($i=0; $i < sizeof($_POST['user_zone']); $i++) {
                    for ($j=0; $j < sizeof($_POST['user_area']); $j++) {
                        if (in_array('0', $_POST['user_locality'])) {
                            $locality_data = $this->get_all_locality($_POST['user_area'][$j]);

                            for ($k=0; $k < sizeof($locality_data); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    $super_data = $this->get_supervisor_by_manager($user_id);

                                    for ($l=0; $l < sizeof($super_data); $l++) {
                                        $report_data = $this->get_all_locality_by_area($_POST['user_area'][$j], $locality_data[$k]['id'], $super_data[$l]['id']);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                } else {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        $report_data = $this->get_all_locality_by_area($_POST['user_area'][$j], $locality_data[$k]['id'], $_POST['user_supervisor'][$l]);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        } else {
                            for ($k=0; $k < sizeof($_POST['user_locality']); $k++) {
                                if (in_array('0', $_POST['user_supervisor'])) {
                                    $super_data = $this->get_supervisor_by_manager($user_id);

                                    for ($l=0; $l < sizeof($super_data); $l++) {
                                        $report_data = $this->get_all_locality_by_area($_POST['user_area'][$j], $_POST['user_locality'][$k], $super_data[$l]['id']);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                } else {
                                    for ($l=0; $l < sizeof($_POST['user_supervisor']); $l++) {
                                        $report_data = $this->get_all_locality_by_area($_POST['user_area'][$j], $_POST['user_locality'][$k], $_POST['user_supervisor'][$l]);

                                        if (sizeof($report_data) > 0) {
                                            $result['report_data']['zone_'.$i.'']['area_'.$j.'']['locality_'.$k.''][] = $report_data;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        /*echo "<pre>";
        print_r($result);
        exit();*/
        return $result;
    }

    public function get_all_area($zone_id)
    {
        $area = array();

        $area['zone_1'] = array(["id"=>"1","area"=>"zone 1 area 1"],["id"=>"2","area"=>"zone 1 area 2"]);
        $area['zone_2'] = array(["id"=>"1","area"=>"zone 2 area 1"],["id"=>"2","area"=>"zone 2 area 2"],["id"=>"3","area"=>"zone 2 area 3"],["id"=>"4","area"=>"zone 2 area 4"]);
        $area['zone_3'] = array(["id"=>"1","area"=>"zone 3 area 1"],["id"=>"2","area"=>"zone 3 area 2"]);

        if (array_key_exists('zone_'.$zone_id.'', $area)) {
            return $area['zone_'.$zone_id.''];
        }
    }

    public function get_all_locality($area_id)
    {
        $locality = array();

        $locality['area_1'] = array(["id"=>"1","locality"=>"area 1 locality 1"],["id"=>"2","locality"=>"area 1 locality 2"],["id"=>"3","locality"=>"area 1 locality 3"],["id"=>"4","locality"=>"area 1 locality 4"],["id"=>"5","locality"=>"area 1 locality 5"],["id"=>"6","locality"=>"area 1 locality 6"],["id"=>"7","locality"=>"area 1 locality 7"],["id"=>"8","locality"=>"area 1 locality 8"]);

        $locality['area_2'] = array(["id"=>"1","locality"=>"area 2 locality 1"],["id"=>"2","locality"=>"area 2 locality 2"],["id"=>"3","locality"=>"area 2 locality 3"],["id"=>"4","locality"=>"area 2 locality 4"],["id"=>"5","locality"=>"area 2 locality 5"]);

        if (array_key_exists('area_'.$area_id.'', $locality)) {
            return $locality['area_'.$area_id.''];
        }
    }

    public function get_all_locality_by_area($area_id, $lid, $super_id)
    {
        $locality = array();

        $locality['area_1']['supervisor_12'] = array("1"=>["locality"=>"area 1 locality 1","total_houses"=>"5","total_collected"=>"5","total_na"=>"0","total_others"=>"1"],"2"=>["locality"=>"area 1 locality 2","total_houses"=>"5","total_collected"=>"5","total_na"=>"0","total_others"=>"1"],"3"=>["locality"=>"area 1 locality 3","total_houses"=>"5","total_collected"=>"1","total_na"=>"2","total_others"=>"0"],"4"=>["locality"=>"area 1 locality 4","total_houses"=>"5","total_collected"=>"1","total_na"=>"2","total_others"=>"0"],"5"=>["locality"=>"area 1 locality 5","total_houses"=>"5","total_collected"=>"1","total_na"=>"2","total_others"=>"0"],"6"=>["locality"=>"area 1 locality 6","total_houses"=>"5","total_collected"=>"1","total_na"=>"2","total_others"=>"0"],"7"=>["locality"=>"area 1 locality 7","total_houses"=>"5","total_collected"=>"1","total_na"=>"2","total_others"=>"0"],"8"=>["locality"=>"area 1 locality 8","total_houses"=>"5","total_collected"=>"3","total_na"=>"0","total_others"=>"0"]);

        $locality['area_2']['supervisor_14'] = array("1"=>["locality"=>"area 2 locality 1","total_houses"=>"5","total_collected"=>"5","total_na"=>"0","total_others"=>"1"],"2"=>["locality"=>"area 2 locality 2","total_houses"=>"5","total_collected"=>"5","total_na"=>"0","total_others"=>"1"],"3"=>["locality"=>"area 2 locality 3","total_houses"=>"5","total_collected"=>"1","total_na"=>"2","total_others"=>"0"],"4"=>["locality"=>"area 2 locality 4","total_houses"=>"5","total_collected"=>"1","total_na"=>"2","total_others"=>"0"],"5"=>["locality"=>"area 2 locality 5","total_houses"=>"5","total_collected"=>"1","total_na"=>"2","total_others"=>"0"]);

        if (array_key_exists('area_'.$area_id.'', $locality)) {
            return $locality['area_'.$area_id.'']['supervisor_'.$super_id.''][''.$lid.''];
        }
    }

    public function get_zone_by_manager($user_id)
    {
        parent::__construct();
        $data1 = $this->db->prepare("call get_zone_by_manager(?)");
        $data1->bindparam(1, $user_id);
        $data1->execute();
        $result1 = $data1->fetchAll(PDO::FETCH_ASSOC);

        return $result1;
    }

    public function get_area_by_zone($zone_id)
    {
        parent::__construct();
        $data1 = $this->db->prepare("call get_area_byzone(?)");
        $data1->bindparam(1, $zone_id);
        $data1->execute();
        $result1 = $data1->fetchAll(PDO::FETCH_ASSOC);

        return $result1;
    }

    public function get_locality_by_area($area_id)
    {
        parent::__construct();
        $data1 = $this->db->prepare("call get_locality_by_area(?)");
        $data1->bindparam(1, $area_id);
        $data1->execute();
        $result1 = $data1->fetchAll(PDO::FETCH_ASSOC);

        return $result1;
    }

    public function get_supervisor_by_manager($user_id)
    {
        parent::__construct();
        $data = $this->db->query("call get_supervisor_by_manager('".$user_id."')");
        $superviosr_list = $data->fetchAll(PDO::FETCH_ASSOC);

        return $superviosr_list;
    }

    public function get_report_data($local_id, $super_id)
    {
        $date = date('Y/m/d');

        parent::__construct();
        $data4 = $this->db->prepare("call get_report_data(?,?,?)");
        $data4->bindparam(1, $local_id);
        $data4->bindparam(2, $super_id);
        $data4->bindparam(3, $date);
        $check = $data4->execute();
        $result4 = $data4->fetchAll(PDO::FETCH_ASSOC);

        return $result4;
    }

    public function get_locality_data($local_id)
    {
        echo "lid : ".$local_id;
        $local = $this->db->prepare("SELECT * FROM localities where id = ".$local_id."");
        $local->execute();
        $local_data = $local->fetchAll(PDO::FETCH_ASSOC);

        echo "<pre>".$local->errorInfo()[2];
        print_r($local_data);
        exit();
        return $local_data;
    }

    public function get_area()
    {
        $result = array();
        if ($_POST["id"] == 0) {

            $user_id = Session::get('user_id');

            parent::__construct();
            $data = $this->db->prepare("call get_zone_by_manager(?)");
            $data->bindparam(1, $user_id);
            $data->execute();
            $area_data["all_zone"] = $data->fetchAll(PDO::FETCH_ASSOC);

            foreach ($area_data["all_zone"] as $area_list) {
                parent::__construct();
                $data = $this->db->query("call get_area_byzone('".$area_list["id"]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result[]=$result_array;
            }
            // parent::__construct();
            //    $data = $this->db->query("call get_locality_by_area('2')");
            //    $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
            //    $result[]=$result_array;

        } else {
            $selected_area = explode(',', $_POST["id"]);
            for ($i=0; $i < count($selected_area); $i++) {
                // echo $selected_area[$i];
                parent::__construct();
                $data = $this->db->query("call get_area_byzone('".$selected_area[$i]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result[]=$result_array;
            }
        }

        // echo "<pre>";
        // print_r($result);
        echo json_encode($result);
    }

    public function get_locality()
    {
        $result = array();
        if ($_POST["id"] == 0) {

            $user_id = Session::get('user_id');

            parent::__construct();
            $data = $this->db->prepare("call get_zone_by_manager(?)");
            $data->bindparam(1, $user_id);
            $data->execute();
            $area_data["all_zone"] = $data->fetchAll(PDO::FETCH_ASSOC);

            foreach ($area_data["all_zone"] as $area_list) {
                parent::__construct();
                $data = $this->db->query("call get_area_byzone('".$area_list["id"]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $area_list=$result_array;
            }

            foreach ($area_list as $area) {
                parent::__construct();
                $data = $this->db->query("call get_locality_by_area('".$area["id"]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result["locality_list"]=$result_array;

                parent::__construct();
                $data = $this->db->query("call get_supervisor_by_area('".$area["id"]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result["superviosr_list"]=$result_array;
            }




        } else {
            $selected_area = explode(',', $_POST["id"]);
            for ($i=0; $i < count($selected_area); $i++) {
                // echo $selected_area[$i];
                // parent::__construct();
                //    $data = $this->db->query("call get_area_byzone('".$selected_area[$i]."')");
                //    $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                //    $result[]=$result_array;

                parent::__construct();
                $data = $this->db->query("call get_locality_by_area('".$selected_area[$i]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result["locality_list"]=$result_array;

                parent::__construct();
                $data = $this->db->query("call get_supervisor_by_area('".$selected_area[$i]."')");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
                $result["superviosr_list"]=$result_array;
            }
        }

        echo json_encode($result);
    }

    public function insert_house()
    {

        parent::__construct();
        $data = $this->db->query("SELECT * FROM houses");
        $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
        $result=$result_array;

        for ($i=0; $i <=count($result); $i++) {
            echo $result[$i]["id"];

            for ($j=1; $j <= 9; $j++) {

                // echo "INSERT INTO link_houses(house_id, qr_type) VALUES ('".$result[$i]["id"]."','".$j."');";
                parent::__construct();
                $data = $this->db->query("INSERT INTO link_houses(house_id, qr_type) VALUES ('".$result[$i]["id"]."','".$j."');");
                $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        // for ($i=0; $i <= 5; $i++) {
        // 	$house = 365+ $i;
        // 	$house_add = $house."shubhalaxmi soc , nana varachha";
        // parent::__construct();
        //    $data = $this->db->query("INSERT INTO houses (street, locality_id,ondate) VALUES ('".$house_add."', '14', '2020-01-19 00:00:00');')");
        //    $result_array = $data->fetchAll(PDO::FETCH_ASSOC);
        //    $result["locality_list"]=$result_array;
        // }

    }
}
