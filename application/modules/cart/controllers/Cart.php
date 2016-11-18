<?php

class Cart extends CI_Controller {

    function GetTopCart() {
        $html = $this->load->view('module/vcart_top', array(), true);
        echo $html;
    }

    function GetAllAddressFromUser() {
        $id_member = GetUserId();
        $this->load->model("user/m_user");
        $listaddressbook = $this->m_user->GetAddressBook($id_member, false);
        echo json_encode($listaddressbook);
    }
    function CheckoutView()
    {
        $model=$this->input->post();
       
        $addressid=0;
        $countryid=0;
        $stateid=0;
        $this->load->model("user/m_user");
        $this->load->model("m_shipping");
        $message = '';
        $data = array();
        $data['st'] = FALSE;
        if ($model['payment_delivery'] == 'new' && $model['isusenewdelivery'] == 'true') {
            $countryid=$model['country_delivery'];
            $stateid=$model['region_delivery'];
            
        } else {
            $addressid = $model['delivery_address_id'];
        }
        
        
        $listshipment=$this->m_shipping->GetShipmentForCart($countryid,$stateid,$addressid);
        $model['name_shipping'] = '';
        $model['nominalprice'] = 0;
        $model['shipprice'] = 0;

        if(count($listshipment)>0)
        {
            foreach ($listshipment as $ship) {
               if($ship->id_shipping==$model['shipping_method'])
               {
                   $model['name_shipping']=$ship->name_shipping;
                   $model['nominalprice']=$ship->nominalprice;
                   $model['shipprice']=$ship->shipprice;
                }
            }
        }
        $html=$this->load->view("cart/vw_checkout_step6",$model,true);
        $data=array();
        $data['view']=$html;
        $data['st']=true;
        echo json_encode($data);
       
    }
    function checkbilling() {
        $model = $this->input->post();
        $this->load->model("user/m_user");
        $message = '';
        $data = array();
        $data['st'] = FALSE;
        $this->load->model("m_shipping");
        $data['shipment']=array();
        if ($model['payment_billing'] == 'new' && $model['isusenewaddress'] == 'true') {
            $this->form_validation->set_rules('firstname_billing', "Billing : First Name", 'required');
            $this->form_validation->set_rules('lastname_billing', "Billing : Last Name", 'required');
            $this->form_validation->set_rules('email_billing', "Billing : Email", 'required');
            $this->form_validation->set_rules('telephone_billing', "Billing : Telephone", 'required');
            $this->form_validation->set_rules('address_billing', "Billing : Address", 'required');
            $this->form_validation->set_rules('city_billing', "Billing : City", 'required');
            $this->form_validation->set_rules('postcode_billing', "Billing : Post Code", 'required');
            $this->form_validation->set_rules('region_billing', "Billing : Country", 'required');
            if(!CheckEmpty($model['same_address']))
            {
                $data['shipment']=$this->m_shipping->GetShipmentForCart($model['country_billing'],$model['region_billing'],0);
            }
        } else {
            $this->form_validation->set_rules('billing_address_id', "Billing Addres", 'required');
        }

        if ($model['isguest'] == '0' && $model['payment_billing'] != 'new' && $model['isusenewaddress'] == 'true') {
            $this->form_validation->set_rules('password_billing', "Billing : Password", 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_billing', "Billing : Confirm Password", 'required|matches[password_billing]');
        }
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            $data['st'] = true;

            if (GetUserId() != 0 && $model['isusenewaddress'] == 'true') {
                $data['id'] = $this->m_user->add_address_book($model);
            } else {
                $data['id'] = 0;
            }
        }
      
        echo json_encode($data);
    }

    function checkdelivery() {
        $model = $this->input->post();
        $addressid=0;
        $countryid=0;
        $stateid=0;
        $this->load->model("user/m_user");
        $this->load->model("m_shipping");
        $message = '';
        $data = array();
        $data['st'] = FALSE;
        if ($model['payment_delivery'] == 'new' && $model['isusenewdelivery'] == 'true') {
            $this->form_validation->set_rules('firstname_delivery', "Delivery : First Name", 'required');
            $this->form_validation->set_rules('lastname_delivery', "Delivery : Last Name", 'required');
            $this->form_validation->set_rules('telephone_delivery', "Delivery : Telephone", 'required');
            $this->form_validation->set_rules('address_delivery', "Delivery : Address", 'required');
            $this->form_validation->set_rules('city_delivery', "Delivery : City", 'required');
            $this->form_validation->set_rules('postcode_delivery', "Delivery : Post Code", 'required');
            $this->form_validation->set_rules('country_delivery', "Delivery : Country", 'required');
            $this->form_validation->set_rules('region_delivery', "Delivery : Region", 'required');
        } else {
            $addressid=$model['delivery_address_id'];
            $this->form_validation->set_rules('delivery_address_id', "Delivery Addres", 'required');
        }

        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            $data['st'] = true;
            $stateid=$model['region_delivery'];
            $countryid=$model['country_delivery'];
            if (GetUserId() != 0 && $model['isusenewdelivery'] == 'true') {
                $arrayinput = array();
                $arrayinput['firstname_billing'] = $model['firstname_delivery'];
                $arrayinput['lastname_billing'] = $model['lastname_delivery'];
                $arrayinput['telephone_billing'] = $model['telephone_delivery'];
                $arrayinput['address_billing'] = $model['address_delivery'];
                $arrayinput['city_billing'] = $model['city_delivery'];
                $arrayinput['postcode_billing'] = $model['postcode_delivery'];
                $arrayinput['country_billing'] = $model['country_delivery'];
                $arrayinput['region_billing'] = $model['region_delivery'];
                $arrayinput['fax_billing'] = $model['fax_delivery'];
                $arrayinput['company_billing'] = '';
                $arrayinput['company_id_billing'] = '';
                $data['id'] = $this->m_user->add_address_book($arrayinput);
                $addressid=$data['id'];
                
            } else {
                $data['id'] = 0;
            }
            $data['shipment']=$this->m_shipping->GetShipmentForCart($countryid,$stateid,$addressid);
        }
        echo json_encode($data);
    }

    function addtocart() {
        $model = $this->input->post();
        $message = '';
        $quantitycart = 0;

        $id = $this->input->post("product_id");
        $this->load->model('cart/m_cart');
        $this->load->model('m_discount');
        $this->load->model('m_product');
        $qty = 0;
        $listcart = $this->m_cart->GetCart();
        foreach ($listcart as $item) {
            if ($item['id'] == $id) {
                $quantitycart = $item['qty'];
            }
        }

        $barang = $this->m_discount->GetDiscountItem($id);
        $product = $this->m_product->GetOneProduct($id);

        if ($barang['stock'] < $quantitycart + 1) {
            $message.='We just have ' . $barang['stock'] . ' left for this product';
        }
        if ($message != '') {
            $message = 'Add to cart failed : <br/>';
        }

        if ($message == '') {

            $ispernahdidatabase = false;
            foreach ($listcart as $item) {
                if ($item['id'] == $id) {
                    $ispernahdidatabase = true;
                }
            }
            $qty = $quantitycart + 1;
            if (GetUserId() == 0) {
                $data['name'] = preg_replace("/[^ \w]+/", "", str_replace('’', ' ', $product->product_name));
                $data['id'] = $id;
                $data['qty'] = $qty;
                $data['price'] = (float) $barang['discountprice'];
                $data['normal_price'] = (float) $barang['price'];
                $data['image_header'] = @$barang['image_header'];
                $data['product_image'] = @$barang['product_image'];
                $this->cart->insert($data);
            } else {
                $data['name'] = preg_replace("/[^ \w]+/", "", str_replace('’', ' ', $product->product_name));
                $data['id'] = $id;
                $data['normal_price'] = (float) $barang['price'];
                $data['price'] = (float) $barang['discountprice'];
                $data['qty'] = $qty;
                $data['id_member'] = GetUserId();
                $data['subtotal'] = $qty * $barang['discountprice'];
                $data['image_header'] = @$barang['image_header'];
                $data['product_image'] = @$barang['product_image'];
                if ($ispernahdidatabase == true) {
                    $this->db->update('tbl_ecommerce_cart', $data, array('id' => $id, 'id_member' => GetUserId()));
                } else {
                    $this->db->insert('tbl_ecommerce_cart', $data);
                }
            }
            echo json_encode((object) array('st' => true, 'msg' => ' <b>1</b> x  <b><i>' . $product->product_name . '</i></b> has been add into your cart'));
        } else
            echo json_encode((object) array('st' => false, 'msg' => $message));
    }

    function removecart() {
        $model = $this->input->post();
        $message = '';
        $msgst = '';
        $quantitycart = 0;

        $id = $this->input->post("product_id");
        $this->load->model('cart/m_cart');
        $listcart = $this->m_cart->GetCart();
        $itemdelete = null;
        foreach ($listcart as $item) {
            if ($item['id'] == $id) {
                $msgst = $item['name'] . '</i></b> has been remove from your cart';
                $itemdelete = $item;
            }
        }


        if ($message == '') {

            if (GetUserId() == 0) {
                $itemdelete['qty'] = 0;
                $this->cart->update($itemdelete);
            } else {
                $this->db->delete('tbl_ecommerce_cart', array('id_product' => $id, 'id_member' => GetUserId()));
            }
            SetMessageSession(1, $msgst);
            echo json_encode((object) array('st' => true, 'msg' => $msgst));
        } else
            echo json_encode((object) array('st' => false, 'msg' => $message));
    }

    function updatecart() {
        $model = $this->input->post();
        $message = '';
        $quantitycart = 0;

        $id = $this->input->post("product_id");
        $qty = $this->input->post("qty");
        $this->load->model('cart/m_cart');
        $this->load->model('m_discount');
        $this->load->model('m_product');
        $listcart = $this->m_cart->GetCart();
        foreach ($listcart as $item) {
            if ($item['id'] == $id) {
                $quantitycart = $item['qty'];
            }
        }
        $barang = $this->m_discount->GetDiscountItem($id);
        $product = $this->m_product->GetOneProduct($id);

        if ($barang['stock'] < $qty) {
            $message.='We just have ' . $barang['stock'] . ' left for this product';
        }

        if ($barang['stock'] < $qty) {
            $message.='We just have ' . $barang['stock'] . ' left for this product';
        }
        if ($qty <= 0) {
            $message.='Qty must more than 0';
        }
        if ($message != '') {
            $message = 'Add to cart failed : <br/>' . $message;
        }

        if ($message == '') {

            $ispernahdidatabase = false;
            foreach ($listcart as $item) {
                if ($item['id'] == $id) {
                    $ispernahdidatabase = true;
                }
            }
            if (GetUserId() == 0) {
                $data['name'] = preg_replace("/[^ \w]+/", "", str_replace('’', ' ', $product->product_name));
                $data['id'] = $id;
                $data['qty'] = $qty - $quantitycart;
                $data['price'] = (float) $barang['discountprice'];
                $data['normal_price'] = (float) $barang['price'];
                $data['image_header'] = @$barang['image_header'];
                $data['product_image'] = @$barang['product_image'];
                $this->cart->insert($data);
            } else {
                $data['name'] = preg_replace("/[^ \w]+/", "", str_replace('’', ' ', $product->product_name));
                $data['id'] = $id;
                $data['normal_price'] = (float) $barang['price'];
                $data['price'] = (float) $barang['discountprice'];
                $data['qty'] = $qty;
                $data['subtotal'] = $qty * $barang['discountprice'];
                $data['image_header'] = $barang['image_header'];
                $data['product_image'] = @$barang['product_image'];
                if ($ispernahdidatabase == true) {
                    $this->db->update('tbl_ecommerce_cart', $data, array('id_product' => $id, 'id_member' => GetUserId()));
                } else {
                    $this->db->insert('tbl_ecommerce_cart', $data);
                }
            }
            SetMessageSession(1, $product->product_name . '</i></b> has been updated');
            echo json_encode((object) array('st' => true, 'msg' => ' <b>1</b> x  <b><i>' . $product->product_name . '</i></b> has been add into your cart'));
        } else
            echo json_encode((object) array('st' => false, 'msg' => $message));
    }

}
