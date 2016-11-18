<?php

class M_discount extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function GetOneDiscount($id) {
        $this->db->from("tbl_ecommerce_discount");
        $this->db->where(array("id_discount" => $id));
        $discount = $this->db->get()->row();
        if ($discount->type == 0) {
            $discount->value = $discount->nominal_value;
        } else {
            $discount->value = $discount->persen_value;
        }

        return $discount;
    }

    function GetMenuDiscount($isecommerce = true) {
        $this->db->from("tbl_ecommerce_discount");
        $this->db->select("id_discount as kode , nama_discount as name");
        if ($isecommerce) {
            $this->db->where(array("display_in !=" => 1));
        } else {
            $this->db->where(array("display_in !=" => 0));
        }
        $this->db->order_by("id_discount", "desc");
        $this->db->where("(start_date='1970-01-01' or start_date>=date(now())) and (until_date='1970-01-01' or date(now())<=until_date)");
        $listdiscount = $this->db->get()->result();
        return $listdiscount;
    }

    function GetDiscountItem($id, $isecommerce = true) {
        $obj = null;
        $price = array();
        $this->db->from("tbl_inv_product_master");
        $this->db->join("tbl_ecommerce_discount", "tbl_ecommerce_discount.id_discount=tbl_inv_product_master.id_discount", "left");
        $this->db->select("not_group_affect,tbl_inv_product_master.id_discount,product_sub_category_id,product_image,product_unit_cost,price_discount,image_header,persen_value,nominal_value,type,start_date,until_date");
        $this->db->where(array("product_id" => $id));
        $obj = $this->db->get()->row();
        if ($obj != null) {
            $price['product_image'] = $obj->product_image;
            $price['image_header'] = $obj->image_header;
            $price['price'] = $obj->product_unit_cost;
            $price['discountprice'] = $price['price'];
            $this->db->from("tbl_inv_product_stock");
            $this->db->where(array("tbl_inv_product_stock.stock_product_id" => $id, "stock_location" => 1));
            $stock = $this->db->get()->row();
            if ($stock != null) {
                $price['stock'] = $stock->stock_qty_current;
            } else {
                $price['stock'] = 0;
            }
            if (!CheckEmpty($obj->id_discount) && (CheckEmpty($obj->start_date) || $obj->start_date == '1970-01-01' || $obj->start_date <= DefaultTanggalDatabase(GetDateNow())) && (CheckEmpty($obj->until_date) || $obj->until_date == '1970-01-01' || $obj->until_date >= DefaultTanggalDatabase(GetDateNow()))) {
                if (!CheckEmpty($obj->not_group_affect)) {
                    $price['discountprice'] = $obj->price_discount;

                    $price['id_discount'] = $obj->id_discount;
                } else {
                    $price['price'] = $obj->product_unit_cost;
                    if ($obj->type == 1) {
                        $price['discountprice'] = (float) $obj->product_unit_cost * ((float) (100 - $obj->persen_value) / (float) 100);
                    } else if ($obj->type == 0) {
                        $price['discountprice'] = (float) $obj->product_unit_cost - $obj->nominal_value;
                    } else {
                        $price['discountprice'] = $obj->nominal_value;
                    }
                    $price['image_header'] = $obj->image_header;
                    $price['id_discount'] = $obj->id_discount;
                }
            } else {
                $this->db->from("tbl_ecommerce_discount");
                $this->db->join("tbl_ecommerce_discount_sub_category", "tbl_ecommerce_discount_sub_category.id_discount=tbl_ecommerce_discount.id_discount");
                $this->db->where(array("tbl_ecommerce_discount_sub_category.id_sub_category" => $obj->product_sub_category_id));
                $this->db->where("(start_date='1970-01-01' or start_date>=date(now())) and (until_date='1970-01-01' or date(now())<=until_date)");
                $this->db->select("tbl_ecommerce_discount.*");
                $listdiscount = $this->db->get()->result();

                foreach ($listdiscount as $discount) {
                    $pricediscount = 0;
                    if ($discount->type == 1) {
                        $pricediscount = (float) $obj->product_unit_cost * ((float) (100 - $discount->persen_value) / (float) 100);
                    } else if ($discount->type == 0) {
                        $pricediscount = (float) $obj->product_unit_cost - $discount->nominal_value;
                    } else {
                        $pricediscount = $discount->nominal_value;
                    }

                    if ($pricediscount < $price['discountprice']) {
                        $price['discountprice'] = $pricediscount;
                        $price['image_header'] = $discount->image_header;
                        $price['id_discount'] = $discount->id_discount;
                    }
                }
            }
        } else {
            $price['price'] = 0;
            $price['discountprice'] = 0;
            $price['image_header'] = '';
            $price['id_discount'] = 0;
            $price['stock'] = 0;
        }
        return $price;
    }

    function GetTotalDiscount($id_discount = 0, $isecommerce = true) {
        $this->db->from("tbl_ecommerce_discount_sub_category");
        $this->db->join("tbl_inv_category_sub", "tbl_inv_category_sub.id_sub_category=tbl_ecommerce_discount_sub_category.id_sub_category");
        $this->db->select("tbl_ecommerce_discount_sub_category.id_sub_category as value");
        $this->db->where(array("tbl_ecommerce_discount_sub_category.id_discount" => $id_discount));
        $discountgroup = $this->db->get()->result();
        $strdiscount = '';
        foreach ($discountgroup as $discount) {
            $strdiscount.=$discount->value . ',';
        }
        $this->db->from("tbl_inv_product_master");
        $this->db->where(array("product_status !=" => '1'));
        $where = array();
        $where['product_active'] = 2;
        $where['id_discount'] = $id_discount;
        if ($isecommerce) {
            $where['product_status !='] = 2;
        } else {
            $where['product_status !='] = 3;
        }
        $this->db->where($where);
        if (strlen($strdiscount) > 0) {
            $strdiscount = substr($strdiscount, 0, strlen($strdiscount) - 1);
            $this->db->or_where(" product_sub_category_id in(" . $strdiscount . ")");
        }

        return $this->db->get()->num_rows();
    }

    function GetListDiscount($id_discount = 0, $start = 0, $limit = 0, $isecommerce = true) {
        $config = GetConfig();
        $this->db->from("tbl_ecommerce_discount_sub_category");
        $this->db->join("tbl_inv_category_sub", "tbl_inv_category_sub.id_sub_category=tbl_ecommerce_discount_sub_category.id_sub_category");
        $this->db->select("tbl_ecommerce_discount_sub_category.id_sub_category as value");
        $this->db->where(array("tbl_ecommerce_discount_sub_category.id_discount" => $id_discount));
        $discountgroup = $this->db->get()->result();
        $strdiscount = '';
        foreach ($discountgroup as $discount) {
            $strdiscount.=$discount->value . ',';
        }


        $this->db->from("tbl_inv_product_master");
        $this->db->where(array("product_status !=" => '1'));
        $where = array();
        $where['product_active'] = 2;
        $where['id_discount'] = $id_discount;
        if ($isecommerce) {
            $where['product_status !='] = 2;
        } else {
            $where['product_status !='] = 3;
        }


        if (!CheckEmpty($start) || !CheckEmpty($limit)) {
            $this->db->limit($limit, $start);
        }
        $this->db->where($where);

        if (strlen($strdiscount) > 0) {
            $strdiscount = substr($strdiscount, 0, strlen($strdiscount) - 1);
            $this->db->or_where(" product_sub_category_id in(" . $strdiscount . ")");
        }


        $this->db->select("product_description,id_discount,price_discount,not_group_affect,product_name,product_image,product_id");

        $listproduct = $this->db->get()->result();

        foreach ($listproduct as $product) {
            $headers = get_headers($config['folderproduct'] . $product->product_image);
            if (!stripos($headers[0], "200 OK")) {
                $product->product_image = "default.jpg";
            }
            $product->listprice = $this->GetDiscountItem($product->product_id, $isecommerce);
        }
        return $listproduct;
    }

}

?>