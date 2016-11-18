<?php
$listcart = GetCart();
$selectcurrency = SelectedCurrency();
$dataresult = GetCartResult($selectcurrency);
?>
<div class="checkout-product">
    <table>
        <thead>
            <tr>
                <td class="name">Name</td>
                <td class="model">Model</td>
                <td class="quantity">Qty</td>
                <td class="price">Price</td>
                <td class="total">Total</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($listcart) > 0) {
                foreach ($listcart as $cartsatuan) {
                    ?>

                    <tr>
                        <td class="name"><a href="<?php echo base_url() . 'index.php/user/view_product/' . $cartsatuan['id'] . '?' . $path . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $cartsatuan['name']) . '.html' ?>"><?php echo $cartsatuan['name'] ?></a>
                        </td>
                        <td class="model"><?php echo @$cartsatuan['products_code'] ?>
                        </td>
                        <td class="quantity"><?php echo @$cartsatuan['qty'] ?>
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
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td class="image" colspan="5"> 
                        Your shopping cart is empty!
                    </td>
                </tr>

            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="price"><b>Sub-Total:</b></td>
                <td class="total"><?php echo DefaultCurrencyForView(@$dataresult['totalsum'], $selectcurrency) ?></td>
            </tr>
            <tr>
                <td colspan="4" class="price"><b><?php echo @$name_shipping ?>:</b></td>
                <td class="total"><?php echo @$shipprice ?></td>
            </tr>
            <tr>
                <td colspan="4" class="price"><b>Total:</b></td>
                <td class="total"><?php echo DefaultCurrencyForView(@$dataresult['totalsum'] + ConvertCurrency($selectcurrency, $nominalprice), $selectcurrency); ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="payment"><div class="buttons">

        <div class="right">
            I have read and agree to the <a class="colorbox cboxElement" href="javascript:;" alt="Terms of Service"><b>Terms of Service</b></a>        <input type="checkbox" name="agree" value="1">      
              <input type="button" value="Continue" id="btt_checkout" class="button">
        </div>
    </div>
</div>

<script>
    $("#btt_checkout").click(function(){
        
        alert("Your Cart has been saved");
        window.location.href="<?php echo base_url()?>";
        
        
    })
</script>