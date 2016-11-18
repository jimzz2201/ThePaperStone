<?php

class Tools extends CI_Controller {

    public function account() {
        $model = array();
        $model['title'] = 'My Account';
        $javascript = array();
        $javascript[0] = "asset/user/js/jquery.nivo.slider.pack.js";
        LoadTemplate($model, 'tools/vaccount', $javascript);
    }

    public function activate_sent() {
        $message = '';
        $email = $this->input->post("email");
        $this->load->model("m_email");
        $data['st']=FALSE;
        $this->form_validation->set_rules('email', "Email", 'required');
        $this->load->model("user/m_user");
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            $message = $this->m_user->CheckActivation($email);
            if($message=='')
            {
                  $this->m_email->SendEmailActivitation($email);
            }
            $data['st'] = $message == '';
            $data['msg'] = $message != '' ? $message : "We have sent email step for activation your account";
        }
        echo json_encode($data);
    }
    public function new_password_action(){
         $model = $this->input->post();
        
        $message = '';
        $data = array();
        $data['st'] = false;
        $this->lang->load("user");
        $this->form_validation->set_rules('password', "Password", 'required');
        $this->form_validation->set_rules('confirm', "Confirm Password", 'required|matches[password]');
      
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            if($model['member_id']!=  GetUserId())
            {
                $message.='This action cannot be completed because you need to refresh your account<br/>';
            }
            else
            {   $this->load->model('user/m_user');
                $this->m_user->set_new_password($model['password']);
                $this->session->set_userdata("ischangepassword",false);
            }
            $data['st']=$message=='';
            $data['msg']=$message;
        }
        echo json_encode($data);
        exit;
        
        
    }
    
    
    public function newpassword(){
       
        $session=$this->session->userdata('ischangepassword');
        if($session!=null&&$session=false)
        {
            redirect(base_url().'index.php/tools/account');
        }
        LoadTemplate(array(), 'tools/vaccount_new_password'); 
    }
    public function activationdirectly()
    {
        $email=$this->input->get("email");
        $activation=$this->input->get("activation");
        $this->load->model("user/m_user");
        
        
        $message = $this->m_user->CheckActivation($email);
        if ($message == '') {
            $encrypt = sha1(strtolower($email));
            if ($encrypt != $activation) {
                $message.='Your Activation Code is wrong<br/>';
            } 
            else
            {   $user=$this->m_user->GetOneUserFromEmail($email);
                $this->m_user->activate($email);
                $newuser=$this->m_user->GetOneUserFromEmail($email);
               
                if($user==null||CheckEmpty($user->password))
                {
                    SetUserId($newuser->id_customer_ecommerce);
                    SetUsernameUser($newuser->email);
                    $this->session->set_userdata('ischangepassword',true);
                    redirect(base_url().'index.php/tools/newpassword');
                }
                else
                {
       
                  SetMessageSession(1, 'Your Account has been acivated');
                  SetUserId($user->id_customer_ecommerce);
                  SetUsernameUser($user->email);
                  redirect(base_url().'index.php/user/message');
                }
            }
        }


        echo $message;
    }
    public function recoverdirectly()
    {
        $email=$this->input->get("email");
        $activation=$this->input->get("activation");
        $this->load->model("user/m_user");
        $message='';
        
        $row = $this->m_user->GetOneUserFromEmail($email);
        if ($row != null) {
            if ($row->forgot_password != $activation || $row->forgot_password=='') {
                $message.='Your Recover Code is wrong<br/>';
            } else {
                SetUserId($row->id_customer_ecommerce);
                SetUsernameUser($row->email);
                $this->session->set_userdata('ischangepassword', true);
                redirect(base_url() . 'index.php/tools/newpassword');
            }
        }


        echo $message;
    }
    
    
    public function activate_process() {
        $message = '';
        $email = $this->input->post("email");
        $activationcode = $this->input->post("activationcode");
        $data['st']=FALSE;
        $this->form_validation->set_rules('email', "Email", 'required');
        $this->form_validation->set_rules('activationcode', "Activation Code", 'required');
        $url='';
        $this->load->model("user/m_user");
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            $message = $this->m_user->CheckActivation($email);
            if($message=='')
            {
                $encrypt=sha1(strtolower($email));
                if($encrypt!=$activationcode)
                {
                   $message.='Your Activation Code is wrong<br/>';
                }
                else {
                   $url.=base_url().'index.php/tools/activationdirectly?email='. strtolower($email).'&&activation='.$encrypt;
                }
              
            }
            $data['st'] = $message == '';
            $data['url'] = $url;
            $data['msg'] = $message != '' ? $message : "We have sent email step for activation your account";
        }
        echo json_encode($data);
    }
   
     public function forgot_process() {
        $message = '';
        $email = $this->input->post("email");
        $activationcode = $this->input->post("activationcode");
        $data['st']=FALSE;
        $this->form_validation->set_rules('email', "Email", 'required');
        $this->form_validation->set_rules('activationcode', "Recover Code", 'required');
        $url='';
        $this->load->model("user/m_user");
        if ($this->form_validation->run() === FALSE || $message != '') {
            $data['msg'] = 'Error :' . validation_errors() . $message;
        } else {
            $row = $this->m_user->GetOneUserFromEmail($email);
            
            if($row!=null)
            {
                
                if($row->forgot_password=='')
                {
                    $message.='Your Recover Code is expired , you can retry for recover your password again by click form above<br/>';
                }
                if ($message == '') {
                    if ($row->forgot_password != $activationcode) {
                        $message.='Your Recover Code is wrong<br/>';
                    } else {
                        $url.=base_url() . 'index.php/tools/recoverdirectly?email=' . strtolower($email) . '&&activation=' . $activationcode;
                    }
                }
            }
            else
            {
                   $message.='We Cannot found your profil from our database<br/>';
                
            }
            $data['st'] = $message == '';
            $data['url'] = $url;
            $data['msg'] = $message != '' ? $message : "We have sent email step for activation your account";
        }
        echo json_encode($data);
    }
    
    
    public function edit() {
        $model = array();
        if(GetUserId()==0)
        {
            redirect(base_url().'index.php/user/login');
        }
        $model['title'] = 'Edit Profile';
        $javascript = array();
        $this->load->model("user/m_area");
        $model['listcountry'] = $this->m_area->GetAllCountries();
        $javascript[0] = "asset/user/js/jquery.nivo.slider.pack.js";
        LoadTemplate($model, 'tools/vaccount_edit', $javascript);
    }
    
    public function activate() {
        $model = array();
        $model['title'] = 'Edit Profile';
        $javascript = array();
        $javascript[0] = "asset/user/js/jquery.nivo.slider.pack.js";
        LoadTemplate($model, 'tools/vaccount_activate', $javascript);
    }

}
