<?php

class M_shipping extends CI_Model {

    function GetShipmentForCart($id_country, $id_state, $id_addressbook) {

        $this->db->from("tbl_ecommerce_shipping");
        $this->db->where(array("publishing" => 1));
        $listshipment = $this->db->get()->result();
        $id_count = $id_country;
        $id_sta = $id_state;
        $listreturnarray = array();
         $listproduct = GetCart();
        $totalprice = 0;
        $totalweight =(float)0;
        foreach ($listproduct as $product) {
            $totalprice+=$product['subtotal'];

            $this->db->from("tbl_inv_product_master");
            $this->db->where(array("product_id" => $product['id']));
            $prodsat = $this->db->get()->row();
          
            if ($prodsat != null) {
               
                $totalweight+=(float)$prodsat->product_weight*(float)$product['qty'];
            }
        }
        foreach ($listshipment as $shipment) {
            if (!CheckEmpty($id_addressbook)) {
                $this->db->from("tbl_ecommerce_address_book");
                $this->db->where(array("id_address_book" => $id_addressbook));
                $row = $this->db->get()->row();
                if ($row != null) {
                    $id_count = $row->country_id;
                    $id_state = $row->state_id;
                }
            }

            $this->db->from("tbl_ecommerce_shipping_country");
            $this->db->where(array("id_shipping" => $shipment->id_shipping, "id_country" => $id_count, "id_state" => $id_sta));
            $rowbil = $this->db->get()->row();

            if ($rowbil == null) {
                $this->db->from("tbl_ecommerce_shipping_country");
                $this->db->where(array("id_shipping" => $shipment->id_shipping, "id_country" => $id_count, "id_state" => 0));
                $rowbil = $this->db->get()->row();
            }
            if ($rowbil == null) {
                $this->db->from("tbl_ecommerce_shipping_country");
                $this->db->where(array("id_shipping" => $shipment->id_shipping, "id_country" => 0, "id_state" => 0));
                $rowbil = $this->db->get()->row();
            }   
          
            if ($rowbil != null) {
              
                $shipprice=0;
                if($rowbil->free_shipment>0)
                {
                    if($totalprice>=$rowbil->free_shipment)
                    {
                        $shipprice=0;
                    }
                    else
                    {
                        $shipprice=$rowbil->price*ceil($totalweight);
                    }
                } else {
                    $shipprice = $rowbil->price * ceil($totalweight);
                }
                $selectcurrency=  SelectedCurrency();
                $shipment->shipprice=$shipprice=='0'?'Free Shipment':DefaultCurrencyForView(ConvertCurrency($selectcurrency, $shipprice), $selectcurrency);
                $shipment->totalweight=(float)$totalweight;
                $shipment->totalprice=$totalprice;
                $shipment->detail = $rowbil;
                $shipment->nominalprice=  $shipprice;
              
                array_push($listreturnarray, $shipment);
            }
        }
        
        
        
        return $listreturnarray;
    }

    function GetOneShipment($id, $isshow = false) {
        $this->db->from("tbl_ecommerce_shipping");
        $this->db->where(array("id_shipping" => $id));
        $row = $this->db->get()->row();
        if ($row != null && $isshow) {
            $this->db->from("tbl_ecommerce_shipping_country");
            $this->db->select("tbl_ecommerce_shipping_country.id_country as country_id,tbl_ecommerce_shipping_country.id_state,0 as isremove,free_shipment,price,estimation_day,country_name,country_3_code as country_code,state_name,state_3_code as state_code");
            $this->db->join("tbl_ecommerce_state", "tbl_ecommerce_state.state_id=tbl_ecommerce_shipping_country.id_state", "left");
            $this->db->join("tbl_ecommerce_countries", "tbl_ecommerce_countries.country_id=tbl_ecommerce_shipping_country.id_country", "left");
            $this->db->where(array("tbl_ecommerce_shipping_country.id_shipping" => $id));
            $row->listhippmentcost = $this->db->get()->result();
        }
        return $row;
    }

    public function ShipmentManipulate($model) {

        $this->lang->load("shipment");
        $listhippmentcost = CheckArray($model, 'listhippmentcost');
        $strmessage = '';
        if (CheckEmpty($model['id_shipping'])) {
            $shipment = (object) array();
            $shipment->name_shipping = $model['name_shipping'];
            $shipment->description = $model['description'];
            $shipment->create_date = GetDateNow();
            $shipment->create_by = GetUserId();
            $shipment->publishing = 1;




            $this->db->insert("tbl_ecommerce_shipping", $shipment);
            $id_shipping = $this->db->insert_id();
            foreach ($listhippmentcost as $shipment) {
                if ($shipment['isremove'] == 0) {
                    $shipupdate = array();
                    $shipupdate['id_shipping'] = $id_shipping;
                    $shipupdate['id_country'] = $shipment['country_id'];
                    $shipupdate['id_state'] = $shipment['id_state'];
                    $shipupdate['price'] = $shipment['price'];
                    $shipupdate['free_shipment'] = $shipment['free_shipment'];
                    $shipupdate['estimation_day'] = $shipment['estimation_day'];
                    $shipupdate['create_date'] = GetDateNow();
                    $shipupdate['create_by'] = GetUserId();
                    $this->db->insert("tbl_ecommerce_shipping_country", $shipupdate);
                }
            }
            SetMessageSession(1, lang('insert_successfull'));
        } else {
            $this->db->from("tbl_ecommerce_shipping");
            $this->db->select("*");
            $this->db->where(array("id_shipping" => $model['id_shipping']));
            $shipment = $this->db->get()->row();
            $shipment->name_shipping = $model['name_shipping'];
            $shipment->description = $model['description'];
            $shipment->update_date = GetDateNow();
            $shipment->update_by = GetUserId();
            $shipment->publishing = $model['publishing'];
            $isremoveall = true;
            $strintid = '';
            $this->db->update("tbl_ecommerce_shipping", $shipment, array("id_shipping" => $model['id_shipping']));
            foreach ($listhippmentcost as $shipment) {
                if ($shipment['isremove'] == 0) {
                    $isremoveall = false;
                    $this->db->from("tbl_ecommerce_shipping_country");
                    $this->db->where(array("id_shipping" => $model['id_shipping'], "id_country" => $shipment['country_id'], "id_state" => $shipment['id_state']));
                    $row = $this->db->get()->row();
                    if ($row != null) {
                        $row->price = $shipment['price'];
                        $row->free_shipment = $shipment['free_shipment'];
                        $row->estimation_day = $shipment['estimation_day'];
                        $row->update_date = GetDateNow();
                        $row->update_by = GetUserId();
                        $this->db->update('tbl_ecommerce_shipping_country', $row, array("id_shipping_country" => $row->id_shipping_country));
                        $strintid.=$row->id_shipping_country . ',';
                    } else {
                        $shipupdate = array();
                        $shipupdate['id_shipping'] = $model['id_shipping'];
                        $shipupdate['id_country'] = $shipment['country_id'];
                        $shipupdate['id_state'] = $shipment['id_state'];
                        $shipupdate['price'] = $shipment['price'];
                        $shipupdate['free_shipment'] = $shipment['free_shipment'];
                        $shipupdate['estimation_day'] = $shipment['estimation_day'];
                        $shipupdate['create_date'] = GetDateNow();
                        $shipupdate['create_by'] = GetUserId();
                        $this->db->insert("tbl_ecommerce_shipping_country", $shipupdate);
                        $strintid.=$this->db->insert_id() . ',';
                    }
                    
                }
            }
           if (strlen($strintid) > 0) {
                $strintid = substr($strintid, 0, strlen($strintid) - 1);
                $strintid = 'Delete from tbl_ecommerce_shipping_country where id_shipping=' . $model['id_shipping']. ' and id_shipping_country not in (' . $strintid . ')';
                $query = $this->db->query($strintid);
            }
            
            if($isremoveall)
            {
                 $this->db->delete("tbl_ecommerce_shipping_country", array("id_shipping"=>$model['id_shipping']));
            }
            
            SetMessageSession(1, lang('edit_successfull'));
        }
        return true;
    }

    public function GetShipment($isshow = true) {
        $this->db->from("tbl_ecommerce_shipping");
        $listshipment = $this->db->get()->result();
        if ($isshow) {
            foreach ($listshipment as $shipment) {
                $this->db->from("tbl_ecommerce_shipping_country");
                $this->db->where(array("id_shipment" => $shipment->id_shipment));
                $shipment->listship = $this->db->get()->result();
            }
        }
        return $listshipment;
    }

    public function shipmentDelete($id) {
        $this->db->delete("tbl_customer_group_mailing", array("id_group_emailing_list" => $id));
        $this->db->delete("tbl_newsletter_group_customer", array("id_group" => $id));
        $this->db->delete("tbl_inv_customer_group_email", array("id_group_email" => $id));
    }

}

?>