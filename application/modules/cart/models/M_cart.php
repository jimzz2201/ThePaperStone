<?php

class M_cart extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function SyncronDbAndCart() {
        $listcart = array();
        $this->load->model("m_discount");

        foreach ($this->cart->contents() as $cartsatuan) {
            $arraywhere = array("id" => $cartsatuan['id'], 'id_member' => GetUserId());
            $harga = $this->m_discount->GetDiscountItem($cartsatuan['id']);
            $this->db->from("tbl_ecommerce_cart");
            $this->db->where($arraywhere);
            $row = $this->db->get()->row();

            if ($row != null) {

                $row->qty = $row->qty + $cartsatuan['qty'];
                $row->price = (float) $harga['discountprice'];
                $row->normal_price = (float) $harga['price'];
                $row->image_header = $harga['image_header'];
                $row->product_image = $harga['product_image'];
                $row->subtotal = $row->qty * $row->price;

                $this->db->update("tbl_ecommerce_cart", $row, $arraywhere);
            } else {
                $row = (object) array();
                $row->qty = $cartsatuan['qty'];
                $row->price = (float) $harga['discountprice'];
                $row->normal_price = (float) $harga['price'];
                $row->image_header = $harga['image_header'];
                $row->product_image = $harga['product_image'];
                $row->subtotal = $row->qty * $row->price;
                $row->id_member = GetUserId();
                $row->id = $cartsatuan['id'];
                $row->name = $cartsatuan['name'];
                $this->db->insert('tbl_ecommerce_cart', $row);
            }
        }
        $this->cart->destroy();
    }
    function EmptyCartDatabase()
    {
         $arraywhere = array( 'id_member' => GetUserId());
         $this->db->delete("tbl_ecommerce_cart",$arraywhere);
    }
    function GetCart() {
        $listcart = array();
        $this->load->model("m_discount");

        if (GetUserId() != 0) {
            $this->db->from("tbl_ecommerce_cart");
            $this->db->where(array("id_member" => GetUserId()));
            $listcart = $this->db->get()->result_array();
            foreach ($listcart as $cartsatuan) {
                $harga = $this->m_discount->GetDiscountItem($cartsatuan['id']);
                if ($cartsatuan['price'] != $harga['discountprice'] || $cartsatuan['normal_price'] != $harga['price']) {
                    $cartsatuan['price'] = $harga['discountprice'];
                    $cartsatuan['normal_price'] = $harga['price'];
                    $cartsatuan['subtotal'] = $harga['discountprice'] * $cartsatuan['qty'];
                    $this->db->update("tbl_ecommerce_cart", $cartsatuan, array("rowid" => $cartsatuan['rowid']));
                }
                $cartsatuan['image_header'] = @$harga['image_header'];
            }
        } else {
            foreach ($this->cart->contents() as $cartsatuan) {
                $harga = $this->m_discount->GetDiscountItem($cartsatuan['id']);

                $cartsatuan['image_header'] = @$harga['image_header'];
                $temparray = $cartsatuan;
                array_push($listcart, $temparray);
            }
        }
        $this->load->model("m_product");
        foreach($listcart as $key=>$satuan)
        {
            $product=$this->m_product->GetOneProduct($satuan['id']);
            $listcart[$key]['products_code']=$product!=null?$product->code_prefix:'';
        }
        return $listcart;
    }

}

?>