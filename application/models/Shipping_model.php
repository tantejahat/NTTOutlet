<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Shipping_model extends CI_Model
{
    private $baseurl_rajaongkir = "https://api.rajaongkir.com/starter/";
    private $api_key_ro = "eb69544fc1b353eafdd402d0e734528d";
    function __construct()
    {
        $CI = &get_instance();
        parent::__construct();
        // $CI->load->library('shipping');
    }
    private function baseurl_rajaongkir()
    {
        $this->db->select('url_rajaongkir');
        $this->db->from('tbl_web_settings');

        return $this->db->get()->url_rajaongkir;
    }
    private function api_key_rajaongkir()
    {
        $this->db->select('key_rajaongkir');
        $this->db->from('tbl_web_settings');

        return $this->db->get()->key_rajaongkir;
    }
    function RajaOngkir($data, $type)
    {
        $parameter = "";
        $ro_id_provinsi = $data["id_province_ro"];
        if ($type == "provinsi") {
            $url = $this->baseurl_rajaongkir . "province";
        } else if ($type == "kota") {
            $url = $this->baseurl_rajaongkir . "city?province=" . $ro_id_provinsi;
        } else {
            $url = $this->baseurl_rajaongkir . "cost";
        }

        $curl = curl_init();
        if ($type == "cost") {
            $datasend = "origin=" . $data["id_kota_pengirim"] . "&destination=" . $data["id_kota_tujuan"] . "&weight=" . $data["berat"] . "&courier=" . $data["id_kurir"];
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $datasend,
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: " . $this->api_key_ro
                ),
            ));
        } else {
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "key: " . $this->api_key_ro
                ),
            ));
        }


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false; //"cURL Error #:" . $err;
        } else {
            return json_decode($response, true);
        }
    }
    function sync_ro_province()
    {
        $arrayproinvce = $this->RajaOngkir(array(), "provinsi");
        $datainsert = array();
        if (isset($arrayproinvce["rajaongkir"]["results"]) && count($arrayproinvce["rajaongkir"]["results"]) > 0) {
            foreach ($arrayproinvce["rajaongkir"]["results"] as $row) {
                $dataprovince = array(
                    "id_ro_province" => $row["province_id"],
                    "name" => $row['province'],
                    "created_at" => date("Y-m-d H:i:s")
                );
                array_push($datainsert, $dataprovince);
            }
        }
        $checkprovince = $this->get_list_province_ro();
        if (count($checkprovince) > 0) {
            //truncate
            $this->db->truncate('tbl_province_ro');
        }

        if ($this->db->insert_batch('tbl_province_ro', $datainsert)) {
            return 1;
        } else {
            return 0;
        }
    }
    function sync_city_ro()
    {
        $checkprovince = $this->get_list_province_ro();
        $datainsert = array();
        if (count($checkprovince) > 0) {
            foreach ($checkprovince as $row) {
                $data = array(
                    "id_province_ro" => $row->id_ro_province
                );
                $getcityro = $this->RajaOngkir($data, "kota");

                if (isset($getcityro["rajaongkir"]["results"]) && count($getcityro["rajaongkir"]["results"]) > 0) {
                    foreach ($getcityro["rajaongkir"]["results"] as $r) {
                        $datacity = array(
                            "id_ro_province" => $r["province_id"],
                            "id_ro_city" => $r["city_id"],
                            "city" => $r['city_name'],
                            "type" => $r['type'],
                            "pcode" => $r["postal_code"],
                            "created_at" => date("Y-m-d H:i:s")
                        );
                        array_push($datainsert, $datacity);
                    }
                }
            }

            $checkprovince = $this->get_list_city_ro();
            if (count($checkprovince) > 0) {
                //truncate
                $this->db->truncate('tbl_city_ro');
            }

            if ($this->db->insert_batch('tbl_city_ro', $datainsert)) {
                return 1;
            } else {
                return 0;
            }
        }
        return 0;
    }
    public function get_list_province_ro($sortBy = 'id', $sort = 'ASC', $limit = '', $start = '', $keyword = '')
    {

        $this->db->select('*');
        $this->db->from('tbl_province_ro');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        if ($keyword != '') {
            $this->db->like('name', stripslashes($keyword));
        }
        $this->db->order_by($sortBy, $sort);
        return $this->db->get()->result();
    }
    public function get_list_city_ro($sortBy = 'id', $sort = 'ASC', $limit = '', $start = '', $keyword = '', $where = '')
    {

        $this->db->select('*');
        $this->db->from('tbl_city_ro');
        if ($where != '') {
            $this->db->where('id_ro_province', $where);
        }
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        if ($keyword != '') {
            $this->db->like('city', stripslashes($keyword));
        }
        $this->db->order_by($sortBy, $sort);
        return $this->db->get()->result();
    }
    public function get_list_mst_Courier()
    {
        $list_courier = array();
        $get_mst_courier = $this->get_mst_courier("0");
        if (count($get_mst_courier) > 0) {
            foreach ($get_mst_courier as $value) {
                # code...
                $list_child = array();
                $get_mst_child = $this->get_mst_courier($value->id);
                if (count($get_mst_child) > 0) {
                    $checked = "";
                    foreach ($get_mst_child as $v) {
                        # code...

                        $checked =  sizeof($this->get_one_courier($v->id)) > 0 ? "checked" : "";
                        $child = array(
                            "id" => $v->id,
                            "name" => $v->name,
                            "code" => $v->code,
                            "checked" => $checked
                        );
                        array_push($list_child, $child);
                    }
                } else {
                    continue;
                }
                $mst = array(
                    "id" => $value->id,
                    "name" => $value->name,
                    "code" => $value->code,
                    "child" => $list_child
                );
                array_push($list_courier, $mst);
            }
        }
        return $list_courier;
    }
    public function get_mst_courier($parent)
    {
        $order = $parent == "0" ? "name" : "id";
        $this->db->select('*');
        $this->db->from('tbl_mst_courier');
        $this->db->where('parent', $parent);
        $this->db->order_by($order, "asc");
        return $this->db->get()->result();
    }
    public function get_courier()
    {

        $this->db->select('*');
        $this->db->from('tbl_shipping');

        $this->db->order_by("2", "asc");
        return $this->db->get()->result_array();
    }
    public function get_one_courier($id_mst_courier)
    {

        $this->db->select('*');
        $this->db->from('tbl_shipping');
        $this->db->where('id_mst_courier', $id_mst_courier);
        $this->db->order_by("2", "asc");
        return $this->db->get()->row_array();
    }
    function InsertShippingWeb($data)
    {
        $chekshipping = $this->get_courier();
        if (count($chekshipping) > 0) {
            $this->db->truncate('tbl_shipping');
        }

        if (sizeof($data['shipping_mst']) > 0) {
            foreach ($data['shipping_mst'] as $value) {
                # code...
                $datainsert = array(
                    "id_mst_courier" => $value
                );

                $this->db->insert('tbl_shipping', $datainsert);
            }
        }
        return true;
    }
    function GetListshipping()
    {
        $list_courier = array();
        $get_mst_courier = $this->get_mst_courier("0");
        if (count($get_mst_courier) > 0) {
            foreach ($get_mst_courier as $value) {
                # code...
                $list_child = array();
                $get_mst_child = $this->get_mst_courier($value->id);
                if (count($get_mst_child) > 0) {
                    $checked = "";
                    foreach ($get_mst_child as $v) {
                        # code...
                        if (sizeof($this->get_one_courier($v->id)) > 0) {
                            $checked =  sizeof($this->get_one_courier($v->id)) > 0 ? "checked" : "";
                            $child = array(
                                "id" => $v->id,
                                "name" => $v->name,
                                "code" => $v->code,

                            );
                            array_push($list_child, $child);
                        }
                    }
                } else {
                    continue;
                }
                $mst = array(
                    "id" => $value->id,
                    "name" => $value->name,
                    "code" => $value->code,
                    "path" => $value->path_img,
                    "child" => $list_child

                );
                if (sizeof($list_child) > 0) {
                    array_push($list_courier, $mst);
                }
            }
        }
        return $list_courier;
    }
    function GetAddressTo($id_address)
    {
        $address = $this->get_one_address($id_address);
        $getcityro = $this->get_list_city_ro('id', 'ASC', '', '', $address['city'], '');
        if (count($getcityro) > 0) {
            return $getcityro[0]->id_ro_city;
        }
        return "0";
    }

    function get_one_address($id_address)
    {
        $this->db->select('*');
        $this->db->from('tbl_addresses');
        $this->db->where('id', $id_address);
        $this->db->order_by("1", "asc");
        return $this->db->get()->row_array();
    }
    function GetCostShippingRo($id_from, $id_to, $weight, $courier)
    {
        $data = array(
            "id_kota_pengirim" => $id_from,
            "id_kota_tujuan" => $id_to,
            "berat" => $weight,
            "id_kurir" => $courier
        );
        // print_r($data);die();
        return $this->RajaOngkir($data, "cost");
    }
    function GetWeight($user_id)
    {
        $sql = "select user_id, sum(total_weight) ttl_weight 
from (select cart.* , product.weight * cart.product_qty as total_weight 
from tbl_cart cart 
left join tbl_product product on cart.product_id = product.id 
where cart.user_id=" . $user_id .
            ")a group by user_id ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
}
