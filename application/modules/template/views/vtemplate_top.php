<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
    <head>
        <title><?php echo @$title != "" ? @$title : "ThePaperStone" ?></title>
        <script type="text/javascript" src="<?php echo base_url(); ?>asset/user/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/jquery-ui-1.8.16.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/user/css/stylesheet.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/user/css/cloud-zoom.css">
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/jquery.colorbox.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>asset/user/js/colorbox.css">
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/tabs.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/elegantcart_custom.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/js.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/elegantcart_custom.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/cloud_zoom.js"></script>
        <link href="<?php echo base_url() ?>asset/user/css/tabulous.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/tabulous.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>asset/user/js/helper.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>asset/user/css/remodal.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>asset/user/css/remodal-default-theme.css">
        <script src="<?php echo base_url() ?>asset/user/js/remodal.js"></script>
        <script>
            var baseurl = "<?php echo base_url() ?>";
            var currenturl = "<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>";
            $(document).ready(function () {

                $("#dropdown_currency").change(function () {
                    $.ajax({
                        type: 'POST',
                        url: baseurl + 'index.php/user/changecurrency',
                        dataType: 'json',
                        data: {
                            currency: $("#dropdown_currency").val(),
                            currenturl: currenturl
                        },
                        success: function (data) {
                            window.location.href = data.url;
                        },
                        error: function (xhr, status, error) {
                            messageerror(xhr.responseText);
                        }
                    });


                })

            })


        </script>
    </head>

    <body>
        <div id="container">

            <div id="header">
                <div id="logo">
                    <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>asset/user/image/logo.png" title="The Paper Stone" alt="The Paper Stone"></a></div>

                <div id="welcome">
                    <?php
                    $objmodel = array();

                    if (GetUserId() > 0) {
                        $objmodel = GetMemberData();
                        ?>

                        Welcome <b><a href="<?php echo base_url() . 'index.php/tools/account' ?>"><?php echo $objmodel->first_name . ' ' . $objmodel->last_name ?></a></b> <a href="<?php echo base_url() . 'index.php/user/logout' ?>" id="btt_log_out">( Log Out )</a>	    		
                        <div style="padding-top: 5px;">
                            <a href="<?php echo base_url() . 'index.php/user/cart' ?>">View Cart</a>&nbsp;&nbsp;&nbsp;<span style="color:#ccc;">|</span>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url() . 'index.php/user/checkout' ?>">Checkout</a> | &nbsp;&nbsp;&nbsp;<a href="<?php echo base_url() . 'index.php/tools/account' ?>">My Account</a>
                        </div> 
                    <?php } else { ?>

                        Welcome visitor you can <a href="<?php echo base_url() . 'index.php/user/login' ?>">login</a> or  <a href="<?php echo base_url() . 'index.php/user/register' ?>">Create an account</a>.	    		
                        <div style="padding-top: 5px;">
                            <a href="<?php echo base_url() . 'index.php/user/cart' ?>">View Cart</a>
                        </div>
                    <?php } ?>

                </div>
                <div id="cart">
                    <?php include APPPATH . 'modules/module/views/vcart_top.php' ?>  
                </div>
                <div id="header_btm">
                    <div id="search">
                        <div class="search_inside">
                            <input type="text" name="search" placeholder="Search" value="">
                            <div class="button-search"></div>
                        </div>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div id="currency">
                            <div id="c_switcher" style="width: 76px;">'
                                <?php $currencydef = SelectedCurrency(); ?>
                                <select name="currency" id="dropdown_currency">

                                    <?php
                                    $listcurrency = GetCurrency();
                                    foreach ($listcurrency as $currency) {
                                        ?>
                                        <option value="<?php echo $currency->id_currency ?>" <?php echo $currencydef == $currency->id_currency ? 'selected="selected"' : "" ?> ><?php echo $currency->currency_code ?></option>

                                    <?php } ?>

                                </select>
                            </div>
                            <input type="hidden" name="currency_code" value="">

                        </div>
                    </form>
                </div>
            </div>
            <div id="menu-holder" class="hidden-phone">
                <div id="menu">
                    <ul>
                        <li class=""><a href="<?php echo base_url() . GetCurrencyPath(true); ?>"><span class="home_icon"></span></a>
                        </li>
                        <?php
                        $listmenu = GetMenu();
                        foreach ($listmenu as $menu) {
                            ?>
                            <li class="">
                                <a href="<?php echo base_url() . 'index.php/user/view_category/' . $menu->cat_id . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $menu->cat_name) . '.html' ?>"><?php echo $menu->cat_name; ?></a>
                                <?php if (count($menu->submenu) > 0) {
                                    ?>
                                    <div style="display: none;">
                                        <ul>
                                            <?php foreach ($menu->submenu as $submenu) { ?>
                                                <li><a href="<?php echo base_url() . 'index.php/user/view_sub_category/' . $submenu->id_sub_category . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $submenu->name_sub_category) . '.html' ?>"><?php echo $submenu->name_sub_category . ' (' . $submenu->countitem . ')'; ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>  
                                <?php }
                                ?>
                            </li>
                            <?php
                        }

                        $listdiscount = GetAllDiscount();
                        foreach ($listdiscount as $discount) {
                            ?>
                            <li class="">
                                <a href="<?php echo base_url() . 'index.php/user/view_category_discount/' . $discount->kode . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $discount->name) . '.html' ?>"><?php echo $discount->name; ?></a>

                            </li>
                            <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
            <div id="menu-phone" class="shown-phone" style="display: none;">
                <div id="menu-phone-button">Menu</div>
                <select id="menu-phone-select" onchange="location = this.value">
                    <option value=""></option>
                    <option value="http://www.thepaperstone.com/index.php?route=product/category&amp;path=20">For Notes</option>
                    <option value="http://www.thepaperstone.com/index.php?route=product/category&amp;path=18">For Scribbles</option>
                    <option value="http://www.thepaperstone.com/index.php?route=product/category&amp;path=25">For Your Desk</option>
                    <option value="http://www.thepaperstone.com/index.php?route=product/category&amp;path=57">For Fun</option>
                    <option value="http://www.thepaperstone.com/index.php?route=product/category&amp;path=17">Cards &amp; Wrap</option>
                    <option value="http://www.thepaperstone.com/index.php?route=product/category&amp;path=24">Bags &amp; Travel</option>
                    <option value="http://www.thepaperstone.com/index.php?route=product/category&amp;path=33">Sale</option>
                    <option value="http://www.thepaperstone.com/index.php?route=product/category&amp;path=93">24hr Special</option>
                </select>
            </div>
            <div id="notification">
            </div>
            <div class="container">
