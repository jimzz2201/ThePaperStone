<?php

class User extends CI_Controller {

    public function subscribber() {
        $salutation = $this->input->post("salutation");
        $name = $this->input->post("name");
        $email = $this->input->post("email");
    }
    
    
    public function forgot_action(){
        $message = '';
        $data = array();
        $model = $this->input->post();
        $data['st'] = false;
        $this->form_validation->set_rules('email', "Email", 'required');
        $this->load->model("user/m_user");
        $this->load->model("m_email");
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            $message = $this->m_user->forgot_password($model['email']);
            if($message=='')
            {
                  $this->m_email->SendEmailRecovery($model['email']);
            }
            $data['st'] = $message == '';
            $data['msg'] = $message != '' ? $message : "We have sent you email step for recover your password<br/>";
        }
        echo json_encode($data);

    }
    public function getState() {
        $this->load->model("user/m_area");
        $id_country = $this->input->post("id_country");
        echo json_encode($this->m_area->GetAllState($id_country));
    }

    public function cart() {
        $model = array();
        $model['isshowcart'] = 1;
        $this->load->model("user/m_area");
        $model['listcountry'] = $this->m_area->GetAllCountries();
        LoadTemplate($model, 'user/vcart', array());
    }

    public function checkout() {
        $model = array();
        $model['isshowcart'] = 1;
        $this->load->model("user/m_area");
        $model['listcountry'] = $this->m_area->GetAllCountries();
        LoadTemplate($model, 'user/vcheckout', array());
    }

    public function register_action() {
        $message = '';
        $data = array();
        $model = $this->input->post();
        $data['st'] = false;
        $this->form_validation->set_rules('firstname', "First Name", 'required');
        $this->form_validation->set_rules('lastname', "Last Name", 'required');
        $this->form_validation->set_rules('email', "Email", 'required');
        $this->form_validation->set_rules('telephone', "Telephone", 'required');
        $this->form_validation->set_rules('fax', "Fax", 'required');
        $this->form_validation->set_rules('address', "Address", 'required');
        $this->form_validation->set_rules('city', "City", 'required');
        $this->form_validation->set_rules('country_id', "Country", 'required');
        $this->form_validation->set_rules('password', "Password", 'required|min_length[6]');
        $this->form_validation->set_rules('confirm', "Confirm Password", 'required|matches[password]');
        $this->load->model("user/m_user");
        $message = $this->m_user->validate_account($model['email']);
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            $message = $this->m_user->register_account($model);
            $data['st'] = $message == '';
            $data['msg'] = $message != '' ? $message : "Your account successfully registered into database we have sent you the email step for activate your account";
        }
        echo json_encode($data);
    }

    public function view_category($id) {
        $model = array();
        $this->load->library('pagination');
        $start = $this->input->get_post('per_page');
        $view = 16;
        $model['title'] = 'Home';
        $this->load->model("m_menu");
        $this->load->model("m_product");
        $model['cat_id'] = $id;
        $model['model'] = $this->m_menu->GetOneMenu($id);
        $javascript = array();
        $model['listproduct'] = $this->m_product->GetListProduct($id, 0, $start, $view);
        $config['base_url'] = base_url() . 'index.php/user/view_category/' . $id . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $model['model']->cat_name) . '.html';
        $config['total_rows'] = $this->m_product->GetTotalProducts($id, 0);
        $config['per_page'] = $view;
        $config["uri_segment"] = 1;
        $config['first_link'] = 'First';
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['use_page_numbers'] = TRUE;
        $page_num = $this->uri->segment(1);
        $offset = ($page_num == NULL) ? 0 :
                ($page_num * $config['per_page']) - $config['per_page'];

        $model['configpaging'] = $config;
        $this->pagination->initialize($config);
        $model['paging'] = $this->pagination->create_links();
        $model['text'] = $this->pagination->current_place();
        LoadTemplate($model, 'user/vcategory', $javascript);
    }

    public function changecurrency() {
        $currency = $this->input->post("currency");
        $currenturl = $this->input->post("currenturl");
        $url = parse_url($currenturl);
        $querystring = '';
        $listquerystring = array();
        $listurl = explode("?", $currenturl);
        $returnrul = $listurl[0];
        $this->load->model("m_currency");
        if (CheckEmpty($currency)) {
            $currency = 0;
        }


        if (count($listurl > 1)) {
            if (array_key_exists("query", $url)) {
                parse_str($url['query'], $listquerystring);
                foreach ($listquerystring as $key => $query) {

                    if ($key != "cry") {

                        $querystring.=$key . "=" . $query . "&";
                    }
                }
            }
        }

        $modelcurrency = $this->m_currency->GetOneCurrency($currency);
        if ($modelcurrency != null) {
            $this->session->set_userdata("currency", $modelcurrency->id_currency);
            if (!($modelcurrency->default_currency == "1")) {
                $querystring = "cry=" . $modelcurrency->id_currency . "&" . $querystring;
            }
        }

        if (strlen($querystring) > 0) {
            $querystring = substr($querystring, 0, strlen($querystring) - 1);
        }

        if (strlen($querystring) > 0) {
            $returnrul.="?" . $querystring;
        }

        $model = array();
        $model['st'] = true;
        $model['url'] = $returnrul;
        echo json_encode($model);
    }
    public function activate()
    {
        $this->input->post("email");
    }
    public function login_validation() {
        $model = $this->input->post();
        $message = '';
        $data = array();
        $data['st'] = false;
        $this->load->model('m_user');
        $this->load->model('cart/m_cart');
        $this->lang->load("user");
        $this->form_validation->set_rules('email', "Email", 'required');
        $this->form_validation->set_rules('password', "Password", 'required');
       
        
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            $message = $this->m_user->login($model['email'], $model['password']);
            $data['st'] = $message == '';
            if ($message == '') {
                if (array_key_exists('isremove', $model)) {
                    if ($model['isremove'] == 1) {
                        $this->m_cart->EmptyCartDatabase();
                    }
                }
                $this->m_cart->SyncronDbAndCart();
            }
            $data['msg']=$message;
        }
        echo json_encode($data);
        exit;
    }

    /*
      public function login_validation() {
      $model = $this->input->post();
      $message = '';
      $data = array();
      $data['st'] = false;
      $config = GetConfig();
      $this->lang->load("user");
      $this->form_validation->set_rules('email', "Email", 'required');
      $this->form_validation->set_rules('password', "Password", 'required');

      if (!CheckEmpty($model['email']) && !CheckEmpty($model['password'])) {
      $arraypost = array();
      $arraypost['IC'] = $model['password'];
      $arraypost['email'] = $model['email'];

      $listuser = json_decode(GetResponseFromAPI($config['loginurl'], $arraypost));

      if (count($listuser) != 1) {
      $message.=sprintf($this->lang->line('account_login_not_find')) . '<br/>';
      } else {
      SetUserId($listuser[0]->member_id);

      $data['st'] = true;
      }
      }

      if ($this->form_validation->run() === FALSE || $message != '') {
      $data['msg'] = 'Error :' . validation_errors() . $message;
      }
      echo json_encode($data);
      exit;
      }
     */

   /* public function edit_info() {
        $model = $this->input->post();
        $arraypost = array();
        $arraypost['primary[member_id]'] = GetUserId();
        $arraypost['data[name]'] = $model['name'];
        $arraypost['data[email]'] = $model['email'];
        $arraypost['data[mobile_phone]'] = $model['mobile_phone'];
        $returnpost = '';
        $message = '';
        $data = array();
        $data['st'] = false;
        $config = GetConfig();
        $this->lang->load("user");
        $this->form_validation->set_rules('email', "Email", 'required');
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            $returnpost = json_decode(GetResponseFromAPI($config['loginurl'], array(), 'PUT', $arraypost));
            if ($returnpost->message == "Success") {
                $data['st'] = true;
            } else {
                $data['msg'] = "No update for your account";
            }
        }
        echo json_encode($data);
        exit;
    }*/
    
    public function forgot()
    {
         LoadTemplate(array(), 'user/vforgot', array());
    }
    
    
    public function message() {
        if(GetMessage()=='' ||  GetMessageStatus()==5)
        {
            redirect(base_url());
        }
        LoadTemplate(array(), 'user/vmessage', array());
    }

    public function edit_info() {
        $model = $this->input->post();
        
        $arraypost = array();
        $returnpost = '';
        $message = '';
        $data = array();
        $data['st'] = false;
        $config = GetConfig();
        $this->lang->load("user");
        $this->form_validation->set_rules('email', "Email", 'required');
        $this->form_validation->set_rules('first_name', "First Name", 'required');
        $this->form_validation->set_rules('country_id', "Country", 'required');
    
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            if($model['member_id']!=  GetUserId())
            {
                $message.='This action cannot be completed because you need to refresh your account<br/>';
            }
            else
            {   $this->load->model('user/m_user');
                $this->m_user->edit_info($model);
            }
            $data['st']=$message=='';
            $data['msg']=$message;
        }
        echo json_encode($data);
        exit;
    }

    

    public function logout() {
        SetUserId(0);
        redirect(base_url() . 'index.php/user/login');
    }

    public function login() {
        if (GetUserId() > 0) {
            redirect(base_url());
        }
        LoadTemplate(array(), 'user/vlogin_user', array());
    }

    public function register() {
        if (GetUserId() > 0) {
            redirect(base_url());
        }
        $model = array();
        $this->load->model("user/m_area");
        $model['listcountry'] = $this->m_area->GetAllCountries();
        LoadTemplate($model, 'user/vregister', array());
    }

    public function view_category_discount($id) {
        $model = array();
        $model['title'] = 'Home';
        $this->load->model("m_discount");
        $this->load->model("m_product");
        $model['model'] = $this->m_discount->GetOneDiscount($id);

        $this->load->library('pagination');
        $start = $this->input->get_post('per_page');
        $view = 16;

        if (!CheckEmpty($model['model'])) {
            $model['title'] = $model['model']->nama_discount;
        }
        $model['listproduct'] = $this->m_discount->GetListDiscount($id, $start, $view);
        $config['base_url'] = base_url() . 'index.php/user/view_category_discount/' . $id . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $model['model']->nama_discount) . '.html';
        $config['total_rows'] = $this->m_discount->GetTotalDiscount($id);
        $config['per_page'] = $view;
        $config["uri_segment"] = 1;
        $config['first_link'] = 'First';
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['use_page_numbers'] = TRUE;
        $page_num = $this->uri->segment(1);

        $offset = ($page_num == NULL) ? 0 :
                ($page_num * $config['per_page']) - $config['per_page'];

        $model['configpaging'] = $config;
        $this->pagination->initialize($config);
        $model['paging'] = $this->pagination->create_links();
        $model['text'] = $this->pagination->current_place();
        $javascript = array();
        $javascript[0] = "asset/user/js/jquery.nivo.slider.pack.js";
        LoadTemplate($model, 'user/vdiscount', $javascript);
    }

    public function view_product($id = 0) {
        $model = array();
        $this->load->model("m_product");
        $product = $this->m_product->GetOneProduct($id);
        $this->load->model("m_discount");

        $model['model'] = $product;
        if ($product != null) {
            $model['cat_id'] = $product->product_category;
            $product->listprice = $this->m_discount->GetDiscountItem($product->product_id);
            $model['sub_cat_id'] = $product->product_sub_category_id;
        }

        LoadTemplate($model, 'product/vproduct', array());
    }

    public function subscribe() {
        $this->form_validation->set_rules('email', "Email", 'required');
        $this->form_validation->set_rules('name', "Name", 'required');
        $message = '';
        $this->load->model("user/m_user");
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
            $data['st'] = false;
        } else {
            $message = $this->m_user->Subscribe($this->input->post());
            $data['st'] = $message == '';
            $data['msg'] = ($message == '' ? 'Thanks for subscribe to ThePaperstone , we will inform you any update about product and information in ThePaperstone' : $message);
        }
        echo json_encode($data);
    }

    public function view_sub_category($id) {
        $model = array();
        $model['title'] = 'Home';
        $this->load->model("m_menu");
        $this->load->model("m_product");
        $model['sub_cat_id'] = $id;
        $model['model'] = $this->m_menu->GetOneSubMenu($id);

        $this->load->library('pagination');
        $start = $this->input->get_post('per_page');
        $view = 16;

        if (!CheckEmpty($model['model'])) {
            $model['model']->parent = $this->m_menu->GetOneMenu($model['model']->cat_id, false);
            $model['cat_id'] = $model['model']->cat_id;

            $model['title'] = $model['model']->name_sub_category;
        }
        $model['listproduct'] = $this->m_product->GetListProduct(0, $id, $start, $view);
        $config['base_url'] = base_url() . 'index.php/user/view_sub_category/' . $id . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $model['model']->name_sub_category) . '.html';
        $config['total_rows'] = $this->m_product->GetTotalProducts(0, $id);
        $config['per_page'] = $view;
        $config["uri_segment"] = 1;
        $config['first_link'] = 'First';
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['use_page_numbers'] = TRUE;
        $page_num = $this->uri->segment(1);
        $offset = ($page_num == NULL) ? 0 :
                ($page_num * $config['per_page']) - $config['per_page'];

        $model['configpaging'] = $config;
        $this->pagination->initialize($config);
        $model['paging'] = $this->pagination->create_links();
        $model['text'] = $this->pagination->current_place();
        $javascript = array();
        $javascript[0] = "asset/user/js/jquery.nivo.slider.pack.js";
        LoadTemplate($model, 'user/vcategorysub', $javascript);
    }

}
