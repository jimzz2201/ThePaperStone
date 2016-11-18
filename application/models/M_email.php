<?php

class M_email extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        if (base_url() == 'http://localhost/ThePaperSone/') {
            $config = Array(
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE,
                'smtp_port' => 465,
                'smtp_user' => 'jimzzz2201@gmail.com',
                'smtp_pass' => 'admin1234/.',
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_crypto' => 'ssl',
                'validate' => TRUE,
                '_smtp_auth' => TRUE,
                'newline' => "\r\n"
            );
        } else {
            $config = Array(
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE,
                'smtp_port' => 25,
                'smtp_user' => 'cs@ezypos.co',
                'smtp_pass' => 'admin1234/.',
                'protocol' => 'smtp',
                'smtp_host' => 'mail.ezypos.co',
                'newline' => "\r\n"
            );
        }
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->initialize($config);
        $this->email->from('cs@ezypos.co', 'The Paper Stone');
        $this->email->set_newline("\r\n");
    }

    function SendEmailActivitation($email) {

        $this->email->to($email);
        $model['email'] = $email;
        $model['activation'] = sha1(strtolower($email));
        $message = $this->load->view("email/v_email_activation", array("model" => $model), true);
        $this->email->subject("Activation Email");
        $this->email->message($message);
        $this->email->send();
    }

    function SendEmailRecovery($email) {

        $this->email->to($email);
        $this->load->model('user/m_user');
        $row = $this->m_user->GetOneUserFromEmail($email);
        if ($row != null) {
            $model['email'] = $email;
            $model['activation'] = $row->forgot_password;
            $message = $this->load->view("email/v_email_recover", array("model" => $model), true);

            $this->email->subject("Recovery Email");
            $this->email->message($message);
            $this->email->send();
        }
    }

}

?>