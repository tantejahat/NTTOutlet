<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ManualTf_model extends CI_Model
{

    public function Get_list_bank()
    {

        $this->db->select('*');
        $this->db->from('tbl_manual_tranfer');

        $this->db->order_by("1", "asc");
        return $this->db->get()->result();
    }
    public function Insert_bank($bank_name, $acc_no, $acc_name)
    {
        $datainsert = array(
            "bank_name" => $bank_name,
            "account_number" => $acc_no,
            "account_name" => $acc_name,
            "created_at" => date("Y-m-d H:i:s")
        );
        if ($this->db->insert('tbl_manual_tranfer', $datainsert)) {
            return 1;
        } else {
            return 0;
        }
    }
}
