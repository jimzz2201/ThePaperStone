<?php

class M_product extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function GetAllFeatureProduct($limit = 0,$isecommerce=true) {
        $this->db->from("tbl_inv_product_master");
        $this->db->where(array("featured" => 1, "product_status !=" => 1));
        $this->db->order_by("RAND()");
        $where=array();
        $where['product_active'] = 2;
        if ($isecommerce) {
            $where['product_status !='] = 2;
        } else {
            $where['product_status !='] = 3;
        }
        if (!CheckEmpty($limit)) {
            $this->db->limit($limit);
        }
        $this->db->where($where);
        $listproduct = $this->db->get()->result();
        $config = GetConfig();
        foreach ($listproduct as $product) {
            $headers = get_headers($config['folderproduct'] . $product->product_image);
            
            if (!stripos($headers[0], "200 OK")) {
                $product->product_image = "default.jpg";
            }
            if(@$product->product_image=='')
            {
                $product->product_image = "default.jpg";
            }
        }
        return $listproduct;
    }

    public function GetOneProduct($id, $val = false) {
        $this->db->from("tbl_inv_product_master");
        $this->db->join("tbl_inv_code_management", "tbl_inv_code_management.code_id=tbl_inv_product_master.product_code_id", "left");
        $this->db->join("tbl_inv_category", "tbl_inv_category.cat_id=tbl_inv_product_master.product_category", "left");
        $this->db->join("tbl_inv_category_sub", "tbl_inv_category_sub.id_sub_category=tbl_inv_product_master.product_sub_category_id", "left");
        $this->db->select("tbl_inv_product_master.*,tbl_inv_code_management.code_prefix,tbl_inv_category_sub.name_sub_category as 'subname',tbl_inv_category.cat_name as 'parentname'");
        $wherearray = array();
        $wherearray['product_id'] = $id;
        if ($val) {
            $wherearray['product_status'] = 1;
        }
        $this->db->where($wherearray);
        $product = $this->db->get()->row();

        return $product;
    }

    function GetTotalProducts($cat_id = 0, $sub_cat_id = 0, $isecommerce = true) {
        $this->db->from("tbl_inv_product_master");
        $this->db->where(array("product_status !=" => '1'));
        $where = array();
        $where['product_active'] = 2;
        if ($isecommerce) {
            $where['product_status !='] = 2;
        } else {
            $where['product_status !='] = 3;
        }
        if (!CheckEmpty($cat_id)) {
            $where['product_category'] = $cat_id;
        }
        if (!CheckEmpty($sub_cat_id)) {
            $where['product_sub_category_id'] = $sub_cat_id;
        }
        $this->db->where($where);
        return $this->db->get()->num_rows();
    }

    function GetListProduct($cat_id = 0, $sub_cat_id = 0, $start = 0, $limit = 0, $isecommerce = true) {
        $config = GetConfig();
        $this->load->model("m_discount");
        $this->db->from("tbl_inv_product_master");
        $this->db->where(array("product_status !=" => '1'));
        $where = array();
        $where['product_active'] = 2;
        if ($isecommerce) {
            $where['product_status !='] = 2;
        } else {
            $where['product_status !='] = 3;
        }
        if (!CheckEmpty($start) || !CheckEmpty($limit)) {
            $this->db->limit($limit, $start);
        }
        if (!CheckEmpty($cat_id)) {
            $where['product_category'] = $cat_id;
        }
        if (!CheckEmpty($sub_cat_id)) {
            $where['product_sub_category_id'] = $sub_cat_id;
        }
        $this->db->where($where);
        $this->db->select("product_description,id_discount,price_discount,not_group_affect,product_name,product_image,product_id");
       
        $listproduct = $this->db->get()->result();
        foreach ($listproduct as $product) {
            $headers = get_headers($config['folderproduct'] . $product->product_image);
            if (!stripos($headers[0], "200 OK")) {
                $product->product_image = "default.jpg";
            }
            $product->listprice=$this->m_discount->GetDiscountItem($product->product_id,$isecommerce);
        }
        return $listproduct;
    }


}

?>