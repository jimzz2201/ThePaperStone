<?php

class M_area extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    function GetAllCountries()
    {
        $this->db->from("tbl_ecommerce_countries");
        $this->db->select("country_id as kode, country_name as name");
        $this->db->where(array("published"=>1));
        $this->db->order_by("country_name");
        return $this->db->get()->result();
    }
    
    function GetAllState($id_country)
    {
        $this->db->from("tbl_ecommerce_state");
        $this->db->select("state_id as kode, state_name as name");
        $this->db->where(array("published"=>1,"country_id"=>$id_country));
        $this->db->order_by("state_name");
        return $this->db->get()->result();
    }
}

?>