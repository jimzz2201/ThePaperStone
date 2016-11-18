<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function featured_product($featured)
{
    $CI = get_instance();
    $CI->load->model("m_product");
    $model=array();
    $model['listproduct']=$CI->m_product->GetAllFeatureProduct($featured);
    echo $CI->load->view('module/vproduct_featured',$model, true);    
}

function left_category($catid=0,$subcatid=0)
{
    $CI = get_instance();
    $CI->load->model("m_menu");
    $model=array();
    $model['listmenu']=$CI->m_menu->GetLeftMenu($catid,$subcatid);
    $model['cat_id']=$catid;
    $model['sub_cat_id']=$subcatid;
    echo $CI->load->view('module/vleft_category',$model, true);    
}


function left_account($acc=0)
{
    $CI = get_instance();
    $model=array();
    $model['acc']=$acc;
    echo $CI->load->view('module/vleft_useraccount',$model, true);    
}