<?php

class M_currency extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    function ConvertCurrency($id=0,$nominal=0)
    {
       $returnnominal=$nominal;
       if(!CheckEmpty($id))
       {
           
           $objcurrency=$this->GetLastCurrencyConverter($id);
           if($objcurrency->exchange_rate!=1||$objcurrency->exchange_rate!=0)
           {
               $returnnominal=  round_up((float)$objcurrency->exchange_rate*$nominal,2);
           }
       }
       return $returnnominal;
    }
    
    function GetLastCurrencyConverter($id)
    {
        $this->db->from("tbl_currency_changer");
        $this->db->where(array("id_currency"=>$id));
        $this->db->order_by("currency_changer_create_date","desc");
        return  $this->db->get()->row();
    }
    
    
    function GetDropDownCurrency()
    {
        $this->db->from("tbl_currency");
        $this->db->where(array("active"=>1));
        return $this->db->get()->result();
    }
    
    function GetOneCurrency($id=0,$validate=false) {
        $this->db->from("tbl_currency");
        $wherearray=array();
        if($validate)
        {
            $wherearray['active']=1;
        }
        if(!CheckEmpty($id))
        {
            $wherearray['id_currency']=$id;
        }
        else
        {
            $wherearray['default_currency']=1;
        }
        $currency = $this->db->where($wherearray)->get()->row();
        if($currency==null)
        {
            $this->db->from("tbl_currency");
            $currency = $this->db->where(array("default_currency"=>1))->get()->row();
            
        }
      
        return $currency;
    }

}

?>