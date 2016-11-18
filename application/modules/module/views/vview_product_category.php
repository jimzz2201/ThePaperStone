<?php
$config = GetConfig();
$selectcurrency = SelectedCurrency();
?>
<div class="product-filter">
    <div class="display"><b>Display:</b> &nbsp;&nbsp;<a onclick="display('list');" class="list_view_link_active">List</a>   <a onclick="display('grid');" class="grid_view_link">Grid</a></div>
    <div class="product-compare"><a href="" id="compare-total">Product Compare (0)</a></div>
    <div class="limit"><b>Show:</b>
        <select onchange="location = this.value;">
            <option>16</option>
            <option>32</option>
            <option>64</option>
            <option>100</option>

        </select>
    </div>
    <div class="sort"><b>Sort By:</b>
        <select onchange="location = this.value;">
            <option>Default</option>
            <option>Name (A - Z)</option>
            <option>Name (Z - A)</option>
            <option>Price (Low &gt; High)</option>
            <option>Price (High &gt; Low)</option>
            <option>Rating (Highest)</option>
            <option>Rating (Lowest)</option>
            <option>Model (A - Z)</option>
            <option>Model (Z - A)</option>
        </select>
    </div>
</div>
<?php if (count($listproduct) > 0) {
    ?>
    <div class="product-grid">
        <?php foreach ($listproduct as $productsatuan) {
            ?>
            <div class="product_holder">  
                <div class="product_holder_inside">

                    <?php
                    if (count(@$productsatuan->listprice) > 0) {
                        ?>
                        <?php if (@$productsatuan->listprice['image_header'] != '') { ?>
                            <div class="special_promo" style="background: url('<?php echo $config['tpsinventory'] . 'images/assets/discount/' . @$productsatuan->listprice['image_header'] ?>') left top no-repeat;">
                            </div>
                        <?php } ?>
                        <?php if (CheckEmpty(@$productsatuan->listprice['stock'])) { ?>
                            <div class="outofstock" style="background: url('<?php echo base_url() ?>images/outofstock.png') left top no-repeat;"></div>
                        <?php } ?>

                        <?php
                    }
                    ?>

                    <div class="image">
                        <a href="<?php echo base_url() . 'index.php/user/view_product/' . $productsatuan->product_id . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $productsatuan->product_name) . '.html' ?>">
                            <img src="<?php echo $config['folderproduct'] . (@$productsatuan->product_image != '' ? @$productsatuan->product_image : 'default.jpg') ?>" alt="<?php echo $productsatuan->product_name ?>" ></a></div><div class="name"><a href="<?php echo base_url() . 'index.php/user/view_product/' . $productsatuan->product_id . '?name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $productsatuan->product_name) . '.html' ?>">
                            <?php echo $productsatuan->product_name ?></a></div>
                    <div class="description">
                        <?php
                        $desc = strip_tags($productsatuan->product_description);
                        echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc
                        ?>
                    </div>
                    <div class="price">
                        <?php
                        if (count(@$productsatuan->listprice) > 0) {
                            if (@$productsatuan->listprice['price'] > @$productsatuan->listprice['discountprice']) {
                                ?>
                                <span class="price-old"><?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, @$productsatuan->listprice['price']), $selectcurrency) ?></span>
                                <?php
                            }
                            ?>
                            <span class="price-new"><?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, @$productsatuan->listprice['discountprice']), $selectcurrency) ?></span>  
                        <?php } else {
                            ?>

                            <span class="price-new"><?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, $productsatuan->product_unit_cost), $selectcurrency) ?></span>          

                        <?php } ?>


                    </div>
                    <div class="cart"><a data-id="<?php echo $productsatuan->product_id ?>" class="button addcartbtn" href="javascript:;" ><span>Add to Cart</span></a></div><div class="wishlist"><a onclick="addToWishList('160');">Add to Wish List</a></div><div class="compare"><a onclick="addToCompare('160');">Add to Compare</a></div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<div class="pagination">
    <div class="links">  
        <?php echo $paging ?> 
    </div>
    <div class="results">
        <?php echo $text ?> 
    </div>
</div>

<script>
    $(".addcartbtn").unbind("click").on("click", function () {
        $.ajax(
                {
                    url: baseurl + "/index.php/cart/addtocart",
                    data: {
                        product_id: $(this).data("id")

                    },
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        if (data.st)
                        {
                            modaldialog(data.msg);
                            messagesuccess(data.msg);
                            RefreshCart();
                        }
                        else
                        {
                            messageerror(data.msg);
                        }

                    },
                    error: function (xhr, status, error)
                    {
                        messageerror(xhr.responseText);
                    }
                });
        return false;
    })



</script>    