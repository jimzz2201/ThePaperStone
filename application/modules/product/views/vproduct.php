<?php
$config = GetConfig();
$selectcurrency = SelectedCurrency();
?>
<div id="column-left">
    <?php left_category(@$cat_id, @$sub_cat_id); ?>
    <div id="banner0" class="banner">
        <div style="display: block;"><img src="http://www.thepaperstone.com/image/cache/data/180x180px free shipping-180x180.jpg" alt="HP Banner" title="HP Banner"></div>
    </div> 
</div>


<div id="content" class="inside_page">  
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        <?php if (!CheckEmpty(@$model)) { ?>
            »<a href="<?php echo base_url() . 'index.php/user/view_category/' . $model->product_category . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $model->parentname) . '.html' ?>"><?php echo @$model->parentname ?></a>

            »<a href="<?php echo base_url() . 'index.php/user/view_sub_category/' . $model->product_sub_category_id . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $model->subname) . '.html' ?>"><?php echo @$model->subname ?></a>
            »<a href="javascript:;"><?php echo @$model->product_name ?></a>
        <?php } ?>
    </div>

    <div class="product-info">

        <div class="left">
            <div class="image">
                 <?php if (CheckEmpty(@$model->listprice['stock'])) { ?>
                    <div class="outofstockbig" style="background: url('<?php echo base_url() ?>images/outofstockbig.png') left top no-repeat;"></div>
                <?php } ?>
                <div class="image_inside">
                    <div id="wrap" style="top:0px;z-index:1000;position:relative;">
                        <div class="zoom-section">    	  
                            <div class="zoom-small-image">
                                <a href="<?php echo $config['folderproduct'] . (@$model->product_image != '' ? @$model->product_image : 'default.jpg') ?>" title="<?php echo @$model->product_name ?>" class="cloud-zoom" id="zoom1" rel="adjustX:10, adjustY:-4" >
                                    <img style="width:310px;" src="<?php echo $config['folderproduct'] . (@$model->product_image != '' ? @$model->product_image : 'default.jpg') ?>" title="<?php echo @$model->product_name ?>" alt="<?php echo @$model->product_name ?>" id="image" ></a>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="zoom_btn">
                    <a id="zoomer" class="colorbox cboxElement" href="<?php echo $config['folderproduct'] . (@$model->product_image != '' ? @$model->product_image : 'default.jpg') ?>" style="display: inline;">Zoom</a>        
                </div></div>
            <div class="image-additional">
            </div>
        </div>
        <script>
            $('a#zoomer').colorbox({rel: 'gal'});
        </script>
        <div class="right"> 
            <h1 class="pr_name"><?php echo @$model->product_name ?></h1>

            <div class="price">
                
                <span class="txt_price">Price:&nbsp;&nbsp;&nbsp;</span>

                <?php
                if (count(@$model->listprice) > 0) {
                    if (@$model->listprice['price'] > @$model->listprice['discountprice']) {
                        ?>
                        <span class="price-old"><?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, @$model->listprice['price']), $selectcurrency) ?></span>&nbsp;
                        <?php
                    }
                    ?>
                    <span class="price-new"><?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, @$model->listprice['discountprice']), $selectcurrency) ?></span>  
                <?php } else {
                    ?>

                    <span class="price-new"><?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, @$model->product_unit_cost), $selectcurrency) ?></span>          

                <?php } ?>
                    <div class="clear"></div>
                <span class="price-tax">GST Incl.</span><br>
            </div>


            <div class="description">
                <span>Product Code:</span>&nbsp;<?php echo @$model->code_prefix ?><br>
                <span>Availability:</span>&nbsp;
                <?php if (CheckEmpty(@$productsatuan->listprice['stock'])) { ?>
                Out Stock
                <?php } else { ?>
                In Stock
                <?php } ?>
                </div>
            <div class="cart">
                <div>Qty:          <input type="text" name="quantity" class="qty_input" size="2" value="1">
                    <input type="hidden" name="product_id" size="2" value="1037">
                    &nbsp;<input type="button" value="Add to Cart" id="button-cart" class="button">
                </div>
                <span class="cart_clearer"></span>
                &nbsp;<a onclick="addToWishList('1037');" class="icon_plus wishlist_link">Add to Wish List</a> &nbsp;&nbsp;
                <a onclick="addToCompare('1037');" class="icon_plus compare_link">Add to Compare</a>
            </div>
            <div class="review">
                <div><img src="<?php echo base_url() ?>images/stars-0.png" alt="0 reviews">&nbsp;&nbsp;(<a onclick="$('a[href=\'#tab-review\']').trigger('click');" class="rev_count">0 reviews</a>)&nbsp;&nbsp;&nbsp;<span class="divider">|</span>&nbsp;&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');" class="icon_plus">Write a review</a></div>
                <div class="share"><!-- AddThis Button BEGIN -->
                    <div class="addthis_default_style"><a class="addthis_button_compact at300m" href="#"><span class="at-icon-wrapper" style="background-color: rgb(255, 101, 80); line-height: 16px; height: 16px; width: 16px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="More" alt="More" style="width: 16px; height: 16px;" class="at-icon at-icon-addthis"><g><path d="M18 14V8h-4v6H8v4h6v6h4v-6h6v-4h-6z" fill-rule="evenodd"></path></g></svg></span>Share</a> <a class="addthis_button_email at300b" target="_blank" title="Email" href="#"><span class="at-icon-wrapper" style="background-color: rgb(132, 132, 132); line-height: 16px; height: 16px; width: 16px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Email" alt="Email" style="width: 16px; height: 16px;" class="at-icon at-icon-email"><g><g fill-rule="evenodd"></g><path d="M27 22.757c0 1.24-.988 2.243-2.19 2.243H7.19C5.98 25 5 23.994 5 22.757V13.67c0-.556.39-.773.855-.496l8.78 5.238c.782.467 1.95.467 2.73 0l8.78-5.238c.472-.28.855-.063.855.495v9.087z"></path><path d="M27 9.243C27 8.006 26.02 7 24.81 7H7.19C5.988 7 5 8.004 5 9.243v.465c0 .554.385 1.232.857 1.514l9.61 5.733c.267.16.8.16 1.067 0l9.61-5.733c.473-.283.856-.96.856-1.514v-.465z"></path></g></svg></span></a><a class="addthis_button_print at300b" title="Print" href="#"><span class="at-icon-wrapper" style="background-color: rgb(115, 138, 141); line-height: 16px; height: 16px; width: 16px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Print" alt="Print" style="width: 16px; height: 16px;" class="at-icon at-icon-print"><g><path d="M24.67 10.62h-2.86V7.49H10.82v3.12H7.95c-.5 0-.9.4-.9.9v7.66h3.77v1.31L15 24.66h6.81v-5.44h3.77v-7.7c-.01-.5-.41-.9-.91-.9zM11.88 8.56h8.86v2.06h-8.86V8.56zm10.98 9.18h-1.05v-2.1h-1.06v7.96H16.4c-1.58 0-.82-3.74-.82-3.74s-3.65.89-3.69-.78v-3.43h-1.06v2.06H9.77v-3.58h13.09v3.61zm.75-4.91c-.4 0-.72-.32-.72-.72s.32-.72.72-.72c.4 0 .72.32.72.72s-.32.72-.72.72zm-4.12 2.96h-6.1v1.06h6.1v-1.06zm-6.11 3.15h6.1v-1.06h-6.1v1.06z"></path></g></svg></span></a> <a class="addthis_button_facebook at300b" title="Facebook" href="#"><span class="at-icon-wrapper" style="background-color: rgb(59, 89, 152); line-height: 16px; height: 16px; width: 16px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Facebook" alt="Facebook" style="width: 16px; height: 16px;" class="at-icon at-icon-facebook"><g><path d="M22 5.16c-.406-.054-1.806-.16-3.43-.16-3.4 0-5.733 1.825-5.733 5.17v2.882H9v3.913h3.837V27h4.604V16.965h3.823l.587-3.913h-4.41v-2.5c0-1.123.347-1.903 2.198-1.903H22V5.16z" fill-rule="evenodd"></path></g></svg></span></a> <a class="addthis_button_twitter at300b" title="Tweet" href="#"><span class="at-icon-wrapper" style="background-color: rgb(29, 161, 242); line-height: 16px; height: 16px; width: 16px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Twitter" alt="Twitter" style="width: 16px; height: 16px;" class="at-icon at-icon-twitter"><g><path d="M27.996 10.116c-.81.36-1.68.602-2.592.71a4.526 4.526 0 0 0 1.984-2.496 9.037 9.037 0 0 1-2.866 1.095 4.513 4.513 0 0 0-7.69 4.116 12.81 12.81 0 0 1-9.3-4.715 4.49 4.49 0 0 0-.612 2.27 4.51 4.51 0 0 0 2.008 3.755 4.495 4.495 0 0 1-2.044-.564v.057a4.515 4.515 0 0 0 3.62 4.425 4.52 4.52 0 0 1-2.04.077 4.517 4.517 0 0 0 4.217 3.134 9.055 9.055 0 0 1-5.604 1.93A9.18 9.18 0 0 1 6 23.85a12.773 12.773 0 0 0 6.918 2.027c8.3 0 12.84-6.876 12.84-12.84 0-.195-.005-.39-.014-.583a9.172 9.172 0 0 0 2.252-2.336" fill-rule="evenodd"></path></g></svg></span></a></div>
                    <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
                    <!-- AddThis Button END --> 
                </div>
            </div>
        </div>
    </div>

    <div id="tabs" class="htabs"><a href="#tab-description" class="selected" style="display: inline;">Description</a>
        <a href="#tab-review" class="" style="display: inline;">Reviews (0)</a>
    </div>
    <div id="tab-description" class="tab-content" style="display: block;">
        <?php echo @$model->product_description ?>
    </div>
    <div id="tab-review" class="tab-content" style="display: none;">
        <div id="review"><div class="content">There are no reviews for this product.</div>
        </div>
        <h2 id="review-title">Write a review</h2>
        <div class="r_label">Your Name:</div>
        <input type="text" name="name" value="" class="ie_left">
        <div class="r_label">Your Review:</div>
        <textarea name="text" cols="40" rows="8" style="width: 98%;" class="ie_left"></textarea>
        <span style="font-size: 11px;"><span style="color: #FF0000;">Note:</span> HTML is not translated!</span><br>
        <br>
        <b class="r_label">Rating:</b> <span>Bad</span>&nbsp;
        <input type="radio" name="rating" value="1">
        &nbsp;
        <input type="radio" name="rating" value="2">
        &nbsp;
        <input type="radio" name="rating" value="3">
        &nbsp;
        <input type="radio" name="rating" value="4">
        &nbsp;
        <input type="radio" name="rating" value="5">
        &nbsp; <span>Good</span><br>
        <br>
        <div class="r_label">Enter the code in the box below:</div>
        <input type="text" name="captcha" value="" class="ie_left">
        <br>
        <img src="index.php?route=product/product/captcha" alt="" id="captcha"><br>
        <br>
        <div class="buttons">
            <div class="right"><a id="button-review" class="button">Continue</a></div>
        </div>
    </div>





</div>