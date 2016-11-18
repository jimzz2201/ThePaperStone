<?php

function GetCurrency() {
    $CI = get_instance();
    $CI->load->model("m_currency");
    return $CI->m_currency->GetDropDownCurrency();
}

function GetResponseFromAPI($url, $arr = array(), $method = 'GET', $CURLOPT_POSTFIELDS = array()) {
    $curl = curl_init();
    $config = GetConfig();
    if (count($arr) > 0) {
        $url.='?' . http_build_query($arr);
    }
    $postcon = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $config['CURLOPT_HTTPHEADER'],
    );
    if (count($CURLOPT_POSTFIELDS) > 0) {
        $postcon[CURLOPT_POSTFIELDS] = http_build_query($CURLOPT_POSTFIELDS);
    }
    curl_setopt_array($curl, $postcon);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
     if ($err) {
        return "cURL Error #:" . $err;
    } else {

        return $response;
    }
}

function SelectedCurrency() {
    $CI = get_instance();
    $currency = 0;
    $CI->load->model("m_currency");
    if (!CheckEmpty($CI->input->get("cry"))) {
        $currency = $CI->input->get("cry");
    } else {
        if (!CheckEmpty($CI->session->userdata("currency"))) {
            $currency = $CI->session->userdata("currency");
        }
    }


    $modelcurrency = $CI->m_currency->GetOneCurrency($currency, true);

    if ($modelcurrency != null) {
        $CI->session->set_userdata("currency", $modelcurrency->id_currency);
        return $modelcurrency->id_currency;
    }
    return 0;
}

function array_msort($array, $cols) {
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) {
            $colarr[$col]['_' . $k] = strtolower($row[$col]);
        }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\'' . $col . '\'],' . $order . ',';
    }
    $eval = substr($eval, 0, -1) . ');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k, 1);
            if (!isset($ret[$k]))
                $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;
}

function GetMenu() {
    $CI = get_instance();
    $CI->load->model("m_menu");
    $listmenu = $CI->m_menu->GetAllMenu(true);
    return $listmenu;
}

function GetAllDiscount() {
    $CI = get_instance();
    $CI->load->model("m_discount");
    $listmenu = $CI->m_discount->GetMenuDiscount(true);
    return $listmenu;
}

function GetMessageStatus() {
    $CI = get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('st') != null && $CI->session->userdata('st') != '') {
        return $CI->session->userdata('st');
    } else {
        return 5;
    }
}

Function DefaultDatePicker($val) {
    return date('d M Y', strtotime($val));
}


function ClearMessage() {
    $CI = get_instance();
    $CI->session->unset_userdata('message');
    $CI->session->unset_userdata('messagestatus');
    $CI->session->unset_userdata('title');
}

function GetMessage() {
    $CI = get_instance();
    if ($CI->session->userdata('msg') != null && $CI->session->userdata('msg') != '') {
        return $CI->session->userdata('msg');
    } else {
        return '';
    }
}

function GetTitle() {
    $CI = get_instance();
    if ($CI->session->userdata('title') != null && $CI->session->userdata('title') != '') {
        return $CI->session->userdata('title');
    } else {
        return GetMessageStatus() == 1 ? "Konfirmasi" : "Error";
    }
}

function CekSessionUser() {
    $CI = get_instance();
    if ($CI->session->userdata('username_user') != null && $CI->session->userdata('username_user') != '') {
        return true;
    } else {
        redirect(base_url() . 'index.php/web/register?url=' . "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]);
    }
}

function LoadTemplate($model, $template, $javascript = array()) {
    $CI = get_instance();
    $CI->load->view('template/vtemplate_top', $model);
    $CI->load->view($template, $model);
    $bottom = array();
    $bottom['javascript'] = $javascript;
    $CI->load->view('template/vtemplate_bottom', $bottom);
}

function GetCurrencyPath($isquerystring = false, $lanjut = false) {
    $CI = get_instance();
    $currency = SelectedCurrency();
    $querystring = '';
    $modelcurrency = $CI->m_currency->GetOneCurrency($currency, true);
    if ($modelcurrency != null) {
        if (!$modelcurrency->default_currency) {
            $querystring.='cry=' . $modelcurrency->id_currency;
        }
    }


    if (strlen($querystring) > 0) {
        if ($isquerystring) {
            $querystring = '?' . $querystring;
        }
        if ($lanjut) {
            $querystring.='&';
        }
    }
    return $querystring;
}

function CheckEmpty($val) {
    if ($val == '' || $val == '0' || $val == false || $val == null) {
        return true;
    }
    return false;
}

function GetUserId() {
    $CI = get_instance();
    $id = $CI->session->userdata('member_id');
    if ($id != null)
        return $id;
    else
        return 0;
}

function SetUserId($Id) {
    $CI = get_instance();
    $CI->session->set_userdata("member_id", $Id);
}

function GetMemberData() {
    $CI = get_instance();
    $CI->load->model('user/m_user');
    $objuser=$CI->m_user->GetOneUserFromEmail(GetUsernameUser());
    //$listuser = json_decode(GetResponseFromAPI($CI->config->config['loginurl'], array("member_id" => GetUserId())));
    //if (count($listuser) > 0) {
      //  $objuser = $listuser[0];
    //} else {
      //  $objuser = array();
    //}
    return $objuser;
}

function GetUsernameUser() {
    $CI = get_instance();
    $username = $CI->session->userdata('username_user');
    if ($username != null)
        return $username;
    else
        return '';
}

function SetUsernameUser($username) {
    $CI = get_instance();
    $CI->session->set_userdata("username_user", $username);
}

function GetUsername() {
    $CI = get_instance();
    $username = $CI->session->userdata('username');
    if ($username != null)
        return $username;
    else
        return '';
}

function RandomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function SetMessageSession($st, $message) {
    $CI = get_instance();
    $CI->session->set_userdata(array("st" => $st, 'msg' => $message));
}

function ClearSessionData() {
    $CI = get_instance();
    $CI->session->unset_userdata("st");
    $CI->session->unset_userdata("msg");
}

function GetDateNow() {
    return date("Y-m-d h:i:s");
}

function DefaultCurrency($number) {

    return number_format(DefaultCurrencyDatabase($number), 0, '', ',');
}

Function ConvertCurrency($id_currency, $nominal) {
    $CI = get_instance();
    $CI->load->model("m_currency");
    return $CI->m_currency->ConvertCurrency($id_currency, $nominal);
}

function DefaultCurrencyForView($number, $db_format = 0) {
    $CI = get_instance();
    $CI->load->model("m_currency");
    $currency = $CI->m_currency->GetOneCurrency($db_format);
    return $currency->format_depan . ' ' . number_format(DefaultCurrencyDatabase($number), $currency->comma_belakang, $currency->separator_currency, $currency->separator_comma) . $currency->format_belakang;
}

function GetValueRadioButton($rad, $arrayname) {
    $yangdibandingin = $rad;
    if ($arrayname !== "") {
        $yangdibandingin = isset($rad[$arrayname]) ? $rad[$arrayname] : null;
    }

    if (isset($yangdibandingin)) {
        if ($yangdibandingin === "on") {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function ForeignKeyFromDb($val) {
    if ($val != null && $val != '' && $val != '0') {
        return $val;
    } else {
        return null;
    }
}

function CheckArray($arr, $key) {
    if (array_key_exists($key, $arr)) {
        if (isset($arr[$key])) {
            if ($arr[$key] != null && $arr[$key] != false && $arr[$key] != '' && is_array($arr[$key])) {
                return $arr[$key];
            } else
                return array();
        }
        else {
            return array();
        }
    } else {
        return array();
    }
}

function DefaultCurrencyDatabase($number) {
    return str_replace(',', '', $number);
}

function Multi_array_search($array, $field, $value) {
    $results = array();

    if (is_array($array)) {
        foreach ($array as $arraysatuan) {
            if ($arraysatuan[$field] == $value) {  //chek the filed against teh value, you can do addional check s(i.e. if field has been set)
                $results[] = $arraysatuan;
            }
        }
    }

    return $results;
}

function Datatable($arraytemp) {

    $row = 0;
    foreach ($arraytemp as $arraysatuan) {
        $arraysatuan->DT_RowId = "row" . $row;
        $row++;
    }
    return $arraytemp;
}

function GetErrorDb($tempstring = "") {
    $CI = get_instance();
    $message = "";
    if ($CI->db->error()['message'] != "") {
        if ($CI->db->db_debug == true) {
            $message = preg_replace('/(<\/?p>)+/', ' ', $CI->db->error()['message']);
        } else {
            if ($tempstring != "") {
                $message = $tempstring;
            } else {
                $message = "Terjadi Sesuatu yang salah dengan system";
            }
        }
    }
    if ($message != "") {
        throw new Exception("Database error occured with message : {$message}");
    }
}

function SetValue($val, $return = "0") {
    if ($val == null) {
        return $return;
    } else {
        return $val;
    }
}

function DefaultTanggal($val) {
    return date('d M Y', strtotime($val));
}

function DefaultTanggalSemestinya($val) {
    return date('m/d/Y', strtotime($val));
}

function DefaultTanggalDatabase($val) {
    return date('Y-m-d', strtotime($val));
}

function DefaultTanggalWithday($val) {
    return date('l , d-M-Y', strtotime($val));
}

function GetConfig() {
    $ci = get_instance(); // CI_Loader instance
    return $ci->config->config;
}

function round_up($value, $places = 0) {
    if ($places < 0) {
        $places = 0;
    }
    $mult = pow(10, $places);
    return ceil($value * $mult) / $mult;
}

function GetCartResult($selectcurrency) {
    $listcart = GetCart();
    $totalsum = 0;
    $totaldiscount = 0;
    $totalitem = 0;
    $totalnominal=0;
    foreach ($listcart as $itemsatuan) {
        $normalprice=ConvertCurrency($selectcurrency, $itemsatuan['normal_price']);
        $subtotal=ConvertCurrency($selectcurrency, $itemsatuan['subtotal']);
        $totalitem+=$itemsatuan['qty'];
        $totaldiscount=($itemsatuan['qty']*$normalprice)-$subtotal;
        $totalsum+=$subtotal;
        $totalnominal+=$itemsatuan['subtotal'];
        
    }
  
    $data = array();
    $data['totalsum'] = $totalsum;
    $data['totaldiscount'] = $totaldiscount;
    $data['totalitem'] = $totalitem;
    $data['totalnominal'] = $totalnominal;

    return $data;
}

function GetCart() {
    $ci = get_instance(); // CI_Loader instance
    $ci->load->model('cart/m_cart');
    return $ci->m_cart->GetCart();
}

function UpdateCart() {
    $ci = get_instance(); // CI_Loader instance
    $ci->load->model('cart/m_cart');
    $ci->m_cart->SyncronDbAndCart();
}
