<?php
$config = GetConfig();
$selectcurrency = SelectedCurrency();
if (count(@$listproduct) > 0) {
    ?>
    <h1 class="general_heading">Featured</h1>
    <div class="products_container">
        <?php foreach (@$listproduct as $productsatuan) { ?>
            <div class="product_holder">
                <div class="product_holder_inside">	
                    <div class="image">
                        <a href="<?php echo base_url() . 'index.php/user/view_product/' . $productsatuan->product_id . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $productsatuan->product_name) . '.html' ?>">
                            <img src="<?php echo $config['folderproduct'] . $productsatuan->product_image ?>" alt="<?php echo $productsatuan->product_name ?>"></a></div>
                    <div class="pr_info">
                        <div class="name"><a href="<?php echo base_url() . 'index.php/user/view_product/' . $productsatuan->product_id . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $productsatuan->product_name) . '.html' ?>"><?php echo $productsatuan->product_name ?></a></div>
                        <div class="price">
                            <?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, $productsatuan->product_unit_cost), $selectcurrency) ?>		          		        </div>
                        <div class="cart"><a class="button addcartbtn" onclick="javascript:;" ><span>Add to Cart</span></a></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>