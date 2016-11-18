<?php

class M_banner extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function GetAllBanner() {
        $this->db->from("tbl_banner");
        $listbanner = $this->db->get()->result();
        
        return $listbanner;
    }

}

?>