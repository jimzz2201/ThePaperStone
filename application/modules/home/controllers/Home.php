<?php

class Home extends CI_Controller {

    public function index() {
        $model = array();
        $model['title'] = 'Home';
        $this->load->model("m_slider");
        $this->load->model("m_banner");
        $this->load->model("m_product");
        $model['slider']=$this->m_slider->GetAllSlider();
        $model['banner']=$this->m_banner->GetAllBanner();
        $javascript=array();
        $javascript[0]="asset/user/js/jquery.nivo.slider.pack.js";
        LoadTemplate($model, 'home/vhome',$javascript);
    }

}
