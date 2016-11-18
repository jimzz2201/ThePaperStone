<?php
$listcart = GetCart();
$config = GetConfig();
$selectcurrency = SelectedCurrency();
$path = GetCurrencyPath(false, true);
if (count($listcart) == 0) {
    redirect(base_url() . 'index.php/user/cart');
}
?>
<script>
    var id_country = 0;
    var id_state = 0;
</script>
<div id="content" style='min-height:initial;'>  
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        » <a href="<?php echo base_url() . 'index.php/user/cart' ?>">CheckOut Cart</a>
    </div>
    <h1>Shopping Cart
    </h1>
    <form  method="post" enctype="multipart/form-data">
        <div class="cart-info">
            <table>
                <thead>
                    <tr>
                        <td class="image">Image</td>
                        <td class="name">Name / Model</td>
                        <td class="quantity">Qty</td>
                        <td class="price">Price</td>
                        <td class="total">Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($listcart) > 0) {
                        $dataresult = GetCartResult($selectcurrency);

                        foreach ($listcart as $cartsatuan) {
                            ?>

                            <tr>
                                <td class="image">              
                                    <a href="<?php echo base_url() . 'index.php/user/view_product/' . $cartsatuan['id'] . '?' . $path . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $cartsatuan['name']) . '.html' ?>">
                                        <img style="height:50px;" src="<?php echo $config['folderproduct'] . (@$cartsatuan['product_image'] != '' ? $cartsatuan['product_image'] : 'default.jpg') ?>" alt="London Bus Money Bank" title="<?php echo $cartsatuan['name'] ?>"></a>
                                </td>
                                <td class="name"><a href="<?php echo base_url() . 'index.php/user/view_product/' . $cartsatuan['id'] . '?' . $path . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $cartsatuan['name']) . '.html' ?>"><?php echo $cartsatuan['name'] ?></a>
                                    <div>
                                    </div>
                                </td>
                                <td class="quantity">
                                    <?php echo $cartsatuan['qty'] ?>
                                    &nbsp;
                                </td>
                                <td class="price">
                                    <?php if ($cartsatuan['normal_price'] > $cartsatuan['price']) { ?>
                                        <span class="price-old">
                                            <?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, $cartsatuan['normal_price']), $selectcurrency) ?>
                                        </span>
                                    <?php } ?>
                                    <span class="price-new">
                                        <?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, $cartsatuan['price']), $selectcurrency) ?>
                                    </span>

                                </td>
                                <td class="total"><?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, $cartsatuan['subtotal']), $selectcurrency) ?></td>
                            </tr>
                        <?php }
                        ?>
                        <tr>
                            <td class = "right" colspan="3"></td>
                            <td class = "right"><b>Total:</b></td>
                            <td class = "right"><?php echo DefaultCurrencyForView(@$dataresult['totalsum'], $selectcurrency) ?></td>
                        </tr>

                    <?php } else {
                        ?>
                        <tr>
                            <td class="image" colspan="5"> 
                                Your shopping cart is empty!
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </form>
    <?php
    if (count($listcart) > 0) {
        $dataresult = GetCartResult($selectcurrency);
        ?>



        <?php
    } else {
        ?>
        <div class = "buttons">
            <div class = "left"><a href = "<?php echo base_url() . 'index.php/user' ?>" class = "button">Continue Shopping</a></div>
        </div> 
    <?php } ?>
</div>


<div id="content"> 

    <div class="checkout">
        <div id="step1">
            <div class="checkout-headingunclick">Step 1: Checkout Options <?php if (GetUserId() == 0) { ?><a class="modify" href="javsacript:;" data-id='1' style="display:none">Modify »</a><?php } ?></div>
            <div class="checkout-content hide" >
                <?php include APPPATH . 'modules/cart/views/vw_checkout_step1.php' ?>   
            </div>
        </div>
        <div id="step2">
            <div class="checkout-headingunclick"><span>Step 2: Account &amp; Billing Details</span><a href="javsacript:;" data-id='2' class="modify" style="display:none">Modify »</a></div>
            <div class="checkout-content hide" >
                <?php include APPPATH . 'modules/cart/views/vw_checkout_step2.php' ?> 


            </div>
        </div>
        <div id="step3">
            <div class="checkout-headingunclick">Step 3: Delivery Details<a class="modify" style="display:none" href="javsacript:;" data-id="3">Modify »</a></div>
            <div class="checkout-content hide">
                <?php include APPPATH . 'modules/cart/views/vw_checkout_step3.php' ?> 
            </div>
        </div>
        <div id="step4">
            <div class="checkout-headingunclick">Step 4: Delivery Method<a class="modify" style="display:none" href="javsacript:;" data-id="4">Modify »</a></div>
            <div class="checkout-content hide">
                <?php include APPPATH . 'modules/cart/views/vw_checkout_step4.php' ?> 

            </div>
        </div>
        <div id="step5">
            <div class="checkout-headingunclick">Step 5: Payment Method<a class="modify" style="display:none" href="javsacript:;" data-id="5">Modify »</a></div>
            <div class="checkout-content hide">
                <?php include APPPATH . 'modules/cart/views/vw_checkout_step5.php' ?> 

            </div>
        </div>
        <div id="step6">
            <div class="checkout-headingunclick">Step 6: Confirm Order<a class="modify" style="display:none" href="javsacript:;" data-id="6">Modify »</a></div>
            <div class="checkout-content hide"></div>
        </div>
    </div>
</div>
<div class = "buttons">
    <div class = "left"><a href = "<?php echo base_url() . 'index.php/user' ?>" class = "button">Continue Shopping</a></div>
</div>
<script>


<?php if (GetUserId() == 0) { ?>
        var checkoutstepnum = 1;
<?php } else { ?>
        var checkoutstepnum = 2;
        $("#step2 .checkout-headingunclick span").html("Step 2: Billing Details");
<?php } ?>
    var billingdetails = 1;

    function checkoutstep()
    {
        $(".checkout-content.block").each(function (index, value) {

            $(this).animate({height: 0}, 1000);
            $(this).addClass("hide");
            $(this).removeClass("block");
        });
        $(".modify").css("display", "none");
        for (var i = 1; i < checkoutstepnum; i++) {
            $("#step" + i + " .modify").css("display", "block");
        }
        $("#step" + checkoutstepnum + " .checkout-content").removeClass("hide");
        $("#step" + checkoutstepnum + " .checkout-content").addClass("block");
        AnimationShow("#step" + checkoutstepnum + " .checkout-content", "full");


    }
    $(".modify").click(function () {
        checkoutstepnum = $(this).data("id");
        checkoutstep();

    })
    $(document).ready(function () {
        checkoutstep();
    })


</script>