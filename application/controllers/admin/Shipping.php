<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shipping extends CI_Controller
{

    private $redirectUrl = NULL;

    public function __construct()
    {
        parent::__construct();

        check_login_user();
        $this->load->library('session');
        $this->load->model('shipping_model');
        $this->load->model('Setting_model');
    }
    public function syncdataro()
    {
        $syncprovince = $this->shipping_model->sync_ro_province();
        if ($syncprovince == 1) {
            $synccity = $this->shipping_model->sync_city_ro();
            if ($synccity == 1) {
                echo "success";
            } else {
                echo "failed";
            }
        } else {
            echo "failed";
        }
    }
    public function getprovinceautocomplete()
    {
        $keyword = $this->input->get('searchTerm');
        $getprovince = $this->shipping_model->get_list_province_ro('id', 'ASC', '', '', $keyword);
        $arraydata = array();
        if (count($getprovince) > 0) {
            foreach ($getprovince as  $value) {
                # code...
                $select = array(
                    'val' => $value->id_ro_province,
                    'label' => $value->name,
                    'id' => $value->id_ro_province,
                    'text' => $value->name
                );
                array_push($arraydata, $select);
            }
        }
        $json = array(
            "results" => $arraydata,
            "total" => count($arraydata)
        );
        echo json_encode($json);
    }
    public function getcityautocomplete()
    {
        $keyword = $this->input->get('searchTerm');
        $id_province = $this->input->get('id_province');
        $getprovince = $this->shipping_model->get_list_city_ro('id', 'ASC', '', '', $keyword, $id_province);
        $arraydata = array();

        if (count($getprovince) > 0) {
            foreach ($getprovince as  $value) {
                # code...
                $select = array(
                    'val' => $value->id_ro_city,
                    'label' => $value->city,
                    'postal_code' => $value->pcode
                );
                array_push($arraydata, $select);
            }
        }
        $json = array(
            "results" => $arraydata,
            "total" => count($arraydata)
        );
        echo json_encode($json);
    }
    public function getcouriersite()
    {
        $html = "";
        $id_address = $this->input->post('id_address');
        $user_id = $this->input->post("user_id");
        $listcourir = array();
        $getcourier = $this->shipping_model->GetListshipping();

        $addressfrom = $this->Setting_model->get_web_details();

        $addressto = $this->shipping_model->GetAddressTo($id_address);

        $getweight = $this->shipping_model->GetWeight($user_id);

        $cost = 0;
        if (sizeof($getcourier) > 0) {
            $html = '<ul  class="list-group">';
            foreach ($getcourier as $key => $value) {
                # code...
                $id_from = $addressfrom->id_ro_city;
                $id_to = $addressto != "0" ? $addressto : "0";
                $weight = sizeof($getweight) > 0 ?  $getweight['ttl_weight'] : "1";
                $courier = $value["code"];
                $getcostro = $this->shipping_model->GetCostShippingRo($id_from, $id_to, $weight, $courier);
                // echo json_encode($getcostro);die();
               
                $listchild = array();
                if (isset($getcostro["rajaongkir"]["results"]) && count($getcostro["rajaongkir"]["results"]) > 0) {
                    $datacostcourier = $getcostro["rajaongkir"]["results"][0];
                    $courierparent = $datacostcourier["code"];
                    foreach ($value["child"] as  $c) {
                  
                      
                       
                        foreach ($datacostcourier["costs"] as $v) {
                            $service = strtolower($courierparent . "-" . $v["service"]);
                            $c["code"] = $value["code"] == "pos" && $c["code"] == "pos-kilat" ?  $datacostcourier["code"] . "-" . $v["service"] : $c["code"];
                            # code... 
                            if (strtolower($c["code"]) == $service) {

                                $datachild = array(
                                    "name" => $c["name"],
                                    "id" => $c["id"],
                                    "price" => number_format($v['cost'][0]["value"], 2, ",", "."),
                                    "rawprice"=> $v['cost'][0]["value"],
                                    "est" => $v['cost'][0]["etd"] . " day"
                                );
                                array_push($listchild, $datachild);
                            }
                        }
                        # code...

                    }
                }else{
                    continue;
                }
                $datacourir = array(
                    "name" => $value["name"],
                    "path" => $value["path_img"],
                    "child" => $listchild
                );
                array_push($listcourir, $datacourir);
            }
        }
        echo json_encode($listcourir);
    }
}
