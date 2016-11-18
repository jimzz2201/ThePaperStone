<?php
$listcart = GetCart();
$config = GetConfig();
$selectcurrency = SelectedCurrency();
$path = GetCurrencyPath(false, true);
?>

<div id="content">  
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        » <a href="<?php echo base_url() . 'index.php/user/cart' ?>">Shopping Cart</a>
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
                                    <input type="text" onkeypress="return isNumberKey(event)"  class="txt_qty" id="txt_qty<?php echo $cartsatuan['id'] ?>"  value="<?php echo $cartsatuan['qty'] ?>" size="1">
                                    &nbsp;
                                    <input type="image" data-id="<?php echo $cartsatuan['id'] ?>" class="btt_update" src="<?php echo base_url() . 'images/update.png' ?>" alt="Update" title="Update">
                                    &nbsp;<img data-id="<?php echo $cartsatuan['id'] ?>" class="btt_remove" src="<?php echo base_url() . 'images/remove.png' ?>" alt="Remove" title="Remove"></td>
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
            </table>
        </div>
    </form>
   
    <?php
    if (count($listcart) > 0) {
        $dataresult = GetCartResult($selectcurrency);
        ?>
    <!--
        <h2>What would you like to do next?</h2>
        <div class = "content">
             
            <p>Choose if you have a discount code you want to use or would like to estimate your delivery cost.</p>
            <table class = "radio">
                <tbody>
                    <tr class = "highlight">
                        <td> 
                            <input type = "radio" class="rd_check" name = "next" value = "coupon" id = "use_coupon">
                        </td>
                        <td><label for = "use_coupon">Use Coupon Code</label></td>
                    </tr>
                    <tr class = "highlight">
                        <td> <input type = "radio" class="rd_check"  name = "next" value = "voucher" id = "use_voucher">
                        </td>
                        <td><label for = "use_voucher">Use Gift Voucher</label></td>
                    </tr>
                    <tr class = "highlight">
                        <td> 
                            <input type = "radio" class="rd_check"  name = "next" value = "shipping" id = "shipping_estimate">
                        </td>
                        <td><label for = "shipping_estimate">Estimate Shipping &amp;
                                Taxes</label></td>
                    </tr>
                </tbody></table>
        </div>
        <div class = "cart-module">
            <div id = "coupon" class = "content" style = "display: none;">
                <form method = "post" enctype = "multipart/form-data">
                    Enter your coupon here:&nbsp;
                    <input type = "text" name = "coupon" value = "">
                    <input type = "hidden" name = "next" value = "coupon">
                    &nbsp;
                    <input type = "submit" value = "Apply Coupon" class = "button">
                </form>
            </div>
            <div id = "voucher" class = "content" style = "display: none;">
                <form method = "post" enctype = "multipart/form-data">
                    Enter your gift voucher code here:&nbsp;
                    <input type = "text" name = "voucher" value = "">
                    <input type = "hidden" name = "next" value = "voucher">
                    &nbsp;
                    <input type = "submit" value = "Apply Voucher" class = "button">
                </form>
            </div>

            <div id = "shipping" class = "content" style = "display: none;">
                <p>Enter your destination to get a shipping estimate.</p>
                <table>
                    <tbody><tr>
                            <td><span class = "required">*</span> Country:</td>
                            <td><select id="dropdown_country_id" name="country_id">
                                    <option value="0"> --- Please Select --- </option>
                                    <?php foreach ($listcountry as $country) { ?>
                                        <option value="<?php echo $country->kode ?>"><?php echo $country->name ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><span class = "required">*</span> Region / State:</td>
                            <td><select id="dropdown_state_id" name="state_id" ><option value="0"> --- Please Select --- </option>
                                </select></td>
                        </tr>
                        <tr>
                            <td><span id = "postcode-required" class = "required" style = "display: none;">*</span> Post Code:</td>
                            <td><input type = "text" name = "postcode" value = ""></td>
                        </tr>
                    </tbody></table>
                <input type = "button" value = "Get Quotes" id = "button-quote" class = "button">
            </div>
        </div>
    -->
        <div class = "cart-total">
            <table id = "total">
                <tbody>

                    <tr>
                        <td class = "right"><b>Total:</b></td>
                        <td class = "right"><?php echo DefaultCurrencyForView(@$dataresult['totalsum'], $selectcurrency) ?></td>
                    </tr>
                </tbody></table>
        </div>
    
        <div class = "buttons">
            <div class = "right"><a href = "<?php echo base_url() . 'index.php/user/checkout' ?>" class = "button">Checkout</a></div>
            <div class = "left"><a href = "<?php echo base_url() . 'index.php/user' ?>" class = "button">Continue Shopping</a></div>
        </div>
        <?php
    } else {
        ?>
        <div class = "buttons">
            <div class = "left"><a href = "<?php echo base_url() . 'index.php/user' ?>" class = "button">Continue Shopping</a></div>
        </div> 
    <?php } ?>
   
</div>
<script>

    $(".btt_update").click(function () {

        $.ajax(
                {
                    url: baseurl + "/index.php/cart/updatecart",
                    data: {
                        product_id: $(this).data("id"),
                        qty: $("#txt_qty" + $(this).data("id")).val()

                    },
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        if (data.st)
                        {
                            window.location.reload();
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
    $(".btt_remove").click(function () {

        $.ajax(
                {
                    url: baseurl + "/index.php/cart/removecart",
                    data: {
                        product_id: $(this).data("id")

                    },
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        if (data.st)
                        {
                            window.location.reload();
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

    function RefreshStatus(str)
    {
        $("#coupon").css("display", "none");
        $("#voucher").css("display", "none");
        $("#shipping").css("display", "none");
        $('#' + str).css("display", "block");
    }

    $(".rd_check").change(function () {
        RefreshStatus($(this).val());
    })
    $("#dropdown_country_id").change(function () {

        $.ajax(
                {
                    url: baseurl + "/index.php/user/getState",
                    data:
                            {
                                id_country: $("#dropdown_country_id").val()
                            },
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        console.log(data);
                        $("#dropdown_state_id").empty();
                        var subcat = $('<option />');
                        subcat.val(0);
                        subcat.text(' --- Please Select --- ');
                        $('#dropdown_state_id').append(subcat);
                        $.each(data, function (index, value) {
                            subcat = $('<option />');
                            subcat.val(value.kode);
                            subcat.text(value.name);
                            $('#dropdown_state_id').append(subcat);

                        });
                    },
                    error: function (xhr, status, error)
                    {

                        messageerror(xhr.responseText);
                    }
                });

    })
</script>