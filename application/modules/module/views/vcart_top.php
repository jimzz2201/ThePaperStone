
<?php
$listcart = GetCart();
$config = GetConfig();
$selectcurrency = SelectedCurrency();
$path = GetCurrencyPath(false, true);
if (count($listcart) > 0) {

    $dataresult = GetCartResult($selectcurrency);
    ?>
    <div class="heading" style="cursor:pointer;">
        <h4>Shopping Cart</h4>
        <?php if (CheckEmpty(@$isshowcart)) { ?><a>
            <?php } ?>

            <span id="cart-total">
                <?php echo $dataresult['totalitem'] ?> item(s) - <?php echo DefaultCurrencyForView(@$dataresult['totalsum'], $selectcurrency) ?> </span>

            <?php if (CheckEmpty(@$isshowcart)) { ?></a>
        <?php } ?>
    </div><div class="content" style="display: none;">

        <?php if (CheckEmpty(@$isshowcart)) { ?>
            <div class="mini-cart-info">
                <table>
                    <tbody>
                        <?php foreach ($listcart as $cartsatuan) { ?>
                            <tr>
                                <td class="image"><a href="<?php echo base_url() . 'index.php/user/view_product/' . $cartsatuan['id'] . '?' . $path . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $cartsatuan['name']) . '.html' ?>">
                                        <img style="height:30px;width:inherit !Important;" src="<?php echo $config['folderproduct'] . (@$cartsatuan['product_image'] != '' ? $cartsatuan['product_image'] : 'default.jpg') ?>" alt="<?php echo $cartsatuan['name'] ?>" title="<?php echo $cartsatuan['name'] ?>"></a>
                                </td>
                                <td class="name"><a href="<?php echo base_url() . 'index.php/user/view_product/' . $cartsatuan['id'] . '?' . $path . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $cartsatuan['name']) . '.html' ?>"><?php echo $cartsatuan['name'] ?></a>
                                    <div>
                                    </div></td>
                                <td class="quantity">x&nbsp;<?php echo $cartsatuan['qty'] ?></td>
                                <td class="total"><?php echo DefaultCurrencyForView(ConvertCurrency($selectcurrency, $cartsatuan['price']), $selectcurrency) ?> </td>
                                <td class="remove"><img src="<?php echo base_url() ?>images/remove-small.png" alt="Remove" title="Remove" data-icheckout-contentd="<?php $cartsatuan['id'] ?>" ></td>
                            </tr>
                        <?php } ?>

                    </tbody></table>
            </div>

            <div class="mini-cart-total">
                <table>
                    <tbody>

                        <tr>
                            <td align="right"><b>Total:</b></td>
                            <td align="right"><?php echo DefaultCurrencyForView(@$dataresult['totalsum'], $selectcurrency) ?></td>
                        </tr>
                    </tbody></table>
            </div>
            <div class="checkout"><a class="button" href="<?php echo base_url() . 'index.php/user/cart' ?>">View Cart</a> &nbsp; <a class="button button_accent" href="<?php echo base_url() . 'index.php/user/checkout' ?>">Checkout</a></div>

            <div class="cart-arrow"></div>
        <?php } ?>
    </div>

<?php } else { ?>

    <div class="heading">
        <h4>Shopping Cart</h4>
        <a><span id="cart-total">0 item(s) - $0.00SGD</span></a></div>
    <div class="content">
        <div class="empty">Your shopping cart is empty!</div>

        <div class="cart-arrow"></div>
    </div>

<?php } ?>