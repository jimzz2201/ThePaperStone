<?php

class M_slider extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function GetAllSlider() {
        $this->db->from("tbl_slider");
        $listslider = $this->db->get()->result();
        
        return $listslider;
    }

}

?>