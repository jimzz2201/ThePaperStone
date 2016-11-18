<?php

class M_user extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    function GetAddressBook($id_member=0,$isdefault=true)
    {
        if(CheckEmpty($id_member)&&!$isdefault)
        {
            $id_member= GetUserId();
        }
       $this->db->from("tbl_ecommerce_address_book");
       $this->db->select("tbl_ecommerce_address_book.*,state_name,country_name");
       $this->db->join("tbl_ecommerce_countries","tbl_ecommerce_countries.country_id=tbl_ecommerce_address_book.country_id","left");
       $this->db->join("tbl_ecommerce_state","tbl_ecommerce_state.state_id=tbl_ecommerce_address_book.state_id","left");

       $this->db->where(array("id_member"=>$id_member));
       return $this->db->get()->result(); 
    }
    function add_address_book($model)
    {
        if (GetUserId() != 0) {
            $arrayinsert = array();
            $arrayinsert['id_member'] = GetUserId();
            $arrayinsert['first_name'] =$model['firstname_billing'];
            $arrayinsert['last_name'] =$model['lastname_billing'];
            $arrayinsert['company'] = $model['company_billing'];
            $arrayinsert['company_id'] = $model['company_id_billing'];
            $arrayinsert['address'] = $model['address_billing'];
            $arrayinsert['city'] = $model['city_billing'];
            $arrayinsert['post_code'] = $model['postcode_billing'];
            $arrayinsert['telpnum'] = $model['telephone_billing'];
            $arrayinsert['fax'] = $model['fax_billing'];
            $arrayinsert['country_id'] = $model['country_billing'];
            $arrayinsert['state_id'] = $model['region_billing'];
            $this->db->insert("tbl_ecommerce_address_book", $arrayinsert);
            return $this->db->insert_id();
        } else {
            return 0;
        }
        
    }
    
    
    
    function forgot_password($email)
    {
        $message = '';
        $config = GetConfig();
        $arraypost['email'] = $email;
        $listuser = json_decode(GetResponseFromAPI($config['loginurl'], $arraypost));
        $this->db->from("tbl_ecommerce_customer");
        $this->db->where(array("email" => $email, 'from' => 'O'));
        $row = $this->db->get()->row();
        $message = '';

        if ($row != null) {
            if ($row->status == 0) {
                $message.='Your account not yet  been activated before please try to activate your account by click <b><i> <a href="' . base_url() . 'index.php/user/activate"> Click Here </i></b>';
            }
        } else {
            if (count($listuser) != 1) {
                $message.='We cannot found your profil data in our system , please try to re-register your account by click <b><i> <a href="' . base_url() . 'index.php/user/register"> Click Here </i></b>';
            }
            else {
                $message.='Your account not yet  been activated before please try to activate your account by click <b><i> <a href="' . base_url() . 'index.php/user/activate"> Click Here </i></b>';
            }
        }
        if($message=='')
        {
            $this->db->update("tbl_ecommerce_customer",array("forgot_password"=>  RandomPassword()),array("email" => $email, 'from' => 'O'));
        }
        return $message;
    }
    function validate_account($model, $iseccomerce = true) {
        //    $this->db->from("")
        // if($this->db->from(""))



        return '';
    }
    
    public function activate($email, $iseccomerce = true)
    {
        $row=$this->GetOneUserFromEmail($email);
        $config=  GetConfig();
        $posuser=null;
        $message='';
        $arraypost['email'] = $email;
        $listuser = json_decode(GetResponseFromAPI($config['loginurl'], $arraypost));
        if(count($listuser)>0)
        {
            $posuser=$listuser[0];
        }
        
        
        if($row!=null||$posuser!=null)
        {
            if ($row == null && $posuser != null) {
                $datainsert = array();
                $datainsert['first_name'] = $posuser->name;
                $datainsert['last_name'] ='';
                $datainsert['email'] = strtolower($posuser->email);
                $datainsert['telephone'] = $posuser->mobile_phone;
                $datainsert['fax'] ='';
                $datainsert['companyid'] = '';
                $datainsert['companyname'] = '';
                $datainsert['address'] = '';
                $datainsert['city'] = '';
                $datainsert['post_code'] = '';
                $datainsert['country'] = '';
                $datainsert['region'] = '';
                $datainsert['password'] = '';
                $datainsert['from'] = 'O' ;
                $datainsert['status'] = 1;
                $datainsert['create_date'] = GetDateNow();
                $this->db->insert("tbl_ecommerce_customer", $datainsert);
            }
            else if($row != null && $posuser == null)
            {
                $arrayins = array();
                $arrayins['membership_card_no'] =  $row->IC;
                $arrayins['type'] = 1;
                $arrayins['name'] = $row->first_name .' '.$row->last_name;
                $arrayins['password'] = '';
                $arrayins['credits'] = 0;
                $arrayins['email'] = $row->email;
                $arrayins['create_date'] = GetDateNow();
                $arrayins['location_id'] = 100;
                $arrayins['status'] = 1;
                GetResponseFromAPI($config['loginurl'], array(), 'POST', $arrayins);
                $datainsert = array();
                $datainsert['status'] = 1;
                $datainsert['update_date'] = GetDateNow();
                $this->db->update("tbl_ecommerce_customer", $datainsert, array("from" => 'O', 'email' => strtolower($email)));
            }
            else {
                $datainsert = array();
                $datainsert['status'] = 1;
                $datainsert['update_date'] = GetDateNow();
                $this->db->update("tbl_ecommerce_customer", $datainsert,array("from"=>'O','email'=> strtolower($email)));
            }
        }
        else
        {
            $message.='Your Email haven\'t been registered , please registered before for use our system by <b><i><a href="'.base_url().'index.php/user/register">Click Here </a></i></b>';
        }
        
        
    }
    public function set_new_password($password)
    {
        $this->db->update("tbl_ecommerce_customer",array("password"=>  sha1($password),'forgot_password'=>''),array("id_customer_ecommerce"=>  GetUserId()));
        SetMessageSession(1, 'Password has updated');
    }
    public function edit_info($model)
    {
        $arrayupdate=array();
        $arrayupdate['first_name']=$model['first_name'];
        $arrayupdate['last_name']=$model['last_name'];
        $arrayupdate['region']=$model['state_id'];
        $arrayupdate['telephone']=$model['telephone'];
        $arrayupdate['fax']=$model['fax'];
        $arrayupdate['address']=$model['address'];
        $arrayupdate['post_code']=$model['post_code'];
        $arrayupdate['country']=$model['country_id'];
        $arrayupdate['city']=$model['city'];
        $this->db->update('tbl_ecommerce_customer',$arrayupdate,array("id_customer_ecommerce"=>  GetUserId()));
    }
    
    public function GetOneUserFromEmail($email,$isecommerce=true)
    {
        $this->db->from("tbl_ecommerce_customer");
        $this->db->join("tbl_ecommerce_countries","tbl_ecommerce_customer.country=tbl_ecommerce_countries.country_id",'left');
        $this->db->join("tbl_ecommerce_state","tbl_ecommerce_state.state_id=tbl_ecommerce_customer.region",'left');
        $where=array();
        $where['email']=$email;
        if($isecommerce)
        {
             $where['from']='O';
        }
        else
        {
             $where['from']='I';
        }
        $this->db->where($where);
        $row=$this->db->get()->row();
        return $row;
        
    }
    function CheckActivation($email) {
        $config = GetConfig();
        $arraypost['email'] = $email;
        $listuser = json_decode(GetResponseFromAPI($config['loginurl'], $arraypost));
        $isfound = false;
        $this->db->from("tbl_ecommerce_customer");
        $this->db->where(array("email" => $email, 'from' => 'O'));
        $row = $this->db->get()->row();
        $message = '';

        if ($row != null) {
            if ($row->status != 0) {
                $message.='Your account has been activated before';
            }
        } else {
            if (count($listuser) != 1) {
                $message.='We cannot found your profil data in our system , please try to re-register your account by click <b><i> <a href="' . base_url() . 'index.php/user/register"> Click Here </i></b>';
            }
        }
        return $message;
    }

    function login($username, $password, $isecommerce = true) {
        $this->lang->load("user");
        $message = '';
        $wherearray = array();
        $wherearray['email'] = $username;
        $wherearray['password'] = sha1($password);
        $this->db->from("tbl_ecommerce_customer");
        if ($isecommerce) {
            $wherearray['from'] = 'O';
        } else {
            $wherearray['from'] = 'I';
        }
        $this->db->where($wherearray);
        $row = $this->db->get()->row();

        if ($row == null) {
            $message.=sprintf($this->lang->line('account_login_not_find')) . '<br/>';
        } else {
            if ($row->status == 0) {
                $message.='your account not activated yet , click <b><i><a href="' . base_url() . 'index.php/tools/activate">Here </a></i></b> for activate your account';
            }
        }


        if ($message == '') {
            SetUserId($row->id_customer_ecommerce);
            SetUsernameUser($row->email);
        }

        return $message;
    }

    function register_account($model, $iseccomerce = true) {
        $this->db->from("tbl_ecommerce_customer");
        $this->db->where(array("email" => strtolower($model['email']), 'from' => $iseccomerce ? 'O' : 'I'));
        $row = $this->db->get()->row();
        $message = '';
        if ($row == null) {
            $datainsert = array();
            $datainsert['first_name'] = $model['firstname'];
            $datainsert['last_name'] = $model['lastname'];
            $datainsert['email'] = strtolower($model['email']);
            $datainsert['telephone'] = $model['telephone'];
            $datainsert['fax'] = $model['fax'];
            $datainsert['companyid'] = $model['company_id'];
            $datainsert['companyname'] = $model['company'];
            $datainsert['address'] = $model['address'];
            $datainsert['city'] = $model['city'];
            $datainsert['post_code'] = $model['postcode'];
            $datainsert['country'] = $model['country_id'];
            $datainsert['region'] = $model['state_id'];
            $datainsert['password'] = sha1($model['password']);
            $datainsert['from'] = $iseccomerce ? 'O' : 'I';
            $datainsert['status'] = 0;
            $datainsert['create_date'] = GetDateNow();
            $this->db->insert("tbl_ecommerce_customer", $datainsert);
            $this->load->model('m_email');
            $this->m_email->SendEmailActivitation( $datainsert['email']);
            if (!CheckEmpty($model['newsletter'])) {
                $this->db->from("tbl_newsletter_address_book");
                $this->db->where(array("email" => strtolower($model['email']), "id_group" => 1));
                $rowemail = $this->db->get()->row();
                if ($rowemail != null) {
                    $dataemail = array();
                    $dataemail['isunsucsribber'] = 0;
                    $this->db->update("tbl_newsletter_address_book", $dataemail, array("email" => strtolower($model['email'])));
                } else {
                    $dataemail = array();
                    $dataemail['first_name'] = $model['firstname'];
                    $dataemail['last_name'] = $model['lastname'];
                    $dataemail['email'] = $model['email'];
                    $dataemail['id_group'] = 1;
                    $dataemail['create_date'] = GetDateNow();
                    $dataemail['isunsucsribber'] = 0;
                    $this->db->insert("tbl_newsletter_address_book", $dataemail);
                }
            }
        } else {
            $message = 'Your Account has registered before';
        }
        return $message;
    }

    function GetOneUser($value, $key = 'email') {
        $this->db->from("tbl_users");
        $where = array();
        $where[$key] = $value;
        $this->db->where($where);
        $user = $this->db->get()->row();

        return $user;
    }

    function Subscribe($model) {
        $this->db->from("tbl_newsletter_address_book");
        $message = '';
        $this->db->where(array("email" => strtolower($model['email']), "id_group" => 1));
        $obj = $this->db->get()->row();
        if ($obj != null) {
            if ($obj->isunsucsribber == 1) {
                $obj->isunsucsribber = 0;
                $this->db->update("tbl_newsletter_address_book", $obj, array("email" => strtolower($model['email']), "id_group" => 1));
            } else {
                $message = 'Your email already in our subscriber list';
            }
        } else {
            $obj = (object) array();
            $obj->salutation = $model['salutation'];
            $obj->first_name = $model['name'];
            $obj->email = strtolower($model['email']);
            $obj->id_group = 1;
            $obj->create_date = GetDateNow();
            $obj->isunsucsribber = 0;
            $this->db->insert("tbl_newsletter_address_book", $obj);
        }
        return $message;
    }

    function UnSubscribe($email) {
        $this->db->from("v_email_dealer");
        $message = '';
        $this->db->where(array("email" => strtolower($email), "unsuscribe" => 0, "id_group !=" => 32));
        $dealer = $this->db->get()->result_array();
        if (count($obj) > 0) {
            foreach ($dealer as $deal) {
                $obj = (object) array();
                $obj->salutation = $deal['salutation'];
                $obj->first_name = $deal['first_name'];
                $obj->email = strtolower($deal['email']);
                $obj->id_group = $deal['id_group'];
                $obj->create_date = GetDateNow();
                $obj->isunsucsribber = 1;
                $this->db->insert("tbl_newsletter_address_book", $obj);
            }
        } else {
            $message.='You are not in our subscriber list';
        }
        return $message;
    }

}

?>