<?php

class M_menu extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function GetAllMenu($islengkap = false,$isecommerce=true) {
        $this->db->from("tbl_inv_category");
        $this->db->where(array("display_in !=" => '1'));
        $where = array();
        if ($isecommerce) {
            $where['display_in !='] = 2;    
        } else {
            $where['display_in !='] = 3;
        }
        $this->db->where($where);
        $this->db->order_by("urut");
        $listmenu = $this->db->get()->result();
        if ($islengkap) {
            foreach ($listmenu as $menu) {
                $menu->submenu = $this->GetAllSubMenu($menu->cat_id);
            }
        }
        return $listmenu;
    }
    function GetLeftMenu($id_cat=0,$isecommerce=true)
    {   $this->db->from("tbl_inv_category");
        $this->db->where(array("display_in !=" => '1'));
        $this->db->order_by("urut");
        $where = array();
        if ($isecommerce) {
            $where['display_in !='] = 2;
        } else {
            $where['display_in !='] = 3;
        }
        $listmenu = $this->db->get()->result();
        foreach ($listmenu as $menu) {
            if($menu->cat_id==$id_cat)
                $menu->submenu = $this->GetAllSubMenu($menu->cat_id);
            else
                $menu->submenu=array();
        }
        return $listmenu;
    }
    function GetOneMenu($id_cat=0,$ikut=false)
    {
        $this->db->from("tbl_inv_category");
        $this->db->where(array("cat_id"=>$id_cat));
        $objectmenu = $this->db->get()->row();
        if($objectmenu!=null&&$ikut)
        {
           $objectmenu->submenu = $this->GetAllSubMenu($objectmenu->cat_id);
        }
        
        return $objectmenu;
    }
     function GetOneSubMenu($id_sub_cat=0)
    {
        $this->db->from("tbl_inv_category_sub");
        $this->db->where(array("id_sub_category"=>$id_sub_cat));
        $objectmenu = $this->db->get()->row();
        
        return $objectmenu;
    }
    
    function GetAllSubMenu($id_cat = 0,$isecommerce=true) {
        $this->db->from("tbl_inv_category_sub");
        $this->db->order_by("urut");
        if (!CheckEmpty($id_cat)) {
            $this->db->where(array("cat_id" => $id_cat));
        }
        $listsubmenu = $this->db->get()->result();
        foreach($listsubmenu as $menu)
        {
            $this->db->from("tbl_inv_product_master");
            $this->db->where(array("product_status !=" => '1'));
            $where = array();
            $where['product_active'] = 2;
            $where['product_sub_category_id'] = $menu->id_sub_category;
            if ($isecommerce) {
                $where['product_status !='] = 2;
            } else {
                $where['product_status !='] = 3;
            }
            $this->db->where($where);
            $menu->countitem=$this->db->get()->num_rows();
        }
        return $listsubmenu;
    }

}

?>