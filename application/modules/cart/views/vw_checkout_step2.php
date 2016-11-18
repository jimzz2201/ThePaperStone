<script>
    var isusenewaddress = false;
</script>
<form id="frmbillingdetails">
    <div class="bagbillingdisplay">
        <input type="hidden" name="isbillinglogin" value="<?php echo GetUserId() == 0 ? "false" : "true"; ?>" >
        <input type="hidden" id="isguest" name="isguest" value="<?php echo GetUserId() == 0 ? "1" : "0"; ?>" >
        <input type="radio" name="payment_billing" value="existing" id="payment_billing-existing" checked="checked">
        <label for="payment_billing-existing">I want to use an existing address</label>
        <div id="billing-existing" >
            <select id="dropdown_billing_address_id"name="billing_address_id" style="width: 100%; margin-bottom: 15px;" size="5">

            </select>
        </div>
        <p>
            <input type="radio" name="payment_billing" value="new" id="payment_billing-new">
            <label for="payment_billing-new">I want to use a new address</label>
        </p>
    </div>
    <div id="billing-new" >
        <div class="left">
            <h2>Your Personal Details</h2>
            <span class="required">*</span> First Name:<br>
            <input type="text" name="firstname_billing" id="firstname_billing" value="" class="large-field">
            <br>
            <br>
            <span class="required">*</span> Last Name:<br>
            <input type="text" name="lastname_billing" value="" id="lastname_billing" class="large-field">
            <br>
            <br>
            <span class="required">*</span> E-Mail:<br>
            <input type="text" name="email_billing" value="" id="email_billing" class="large-field">
            <br>
            <br>
            <span class="required">*</span> Telephone:<br>
            <input type="text" name="telephone_billing" value="" id="telephone_billing"  class="large-field">
            <br>
            <br>
            Fax:<br>
            <input type="text" name="fax_billing" value=""  id="fax_billing" class="large-field">
            <br>
            <br>
            <div class="divnotguest" style="display: none">
                <h2>Your Password</h2>
                <span class="required">*</span> Password:<br>
                <input type="password" name="password_billing" value="" id="password_billing" class="large-field">
                <br>
                <br>
                <span class="required">*</span> Password Confirm: <br>
                <input type="password" name="confirm_billing" value="" id="confirm_billing" class="large-field">
                <br>
                <br>
            </div>
            <br>
        </div>
        <div class="right textleft">
            <h2>Your Address</h2>
            Company:<br>
            <input type="text" name="company_billing" id="company_billing" value="" class="large-field">
            <br>
            <br>

            <div id="company-id-display">
                <span id="company-id-required" class="required" ></span> Company ID:<br>
                <input type="text" name="company_id_billing" id="company_id_billing" value="" class="large-field">
                <br>
                <br>
            </div>

            <span class="required">*</span> Address:<br>
            <textarea style="width:305px;height:75px;" type="text" name="address_billing" id="address_billing" value="" class="large-field"></textarea>

            <br>
            <br>
            <span class="required">*</span> City:<br>
            <input type="text" name="city_billing" value="" id="city_billing" class="large-field">
            <br>
            <br>
            <span id="payment-postcode-required" class="required">*</span> Post Code:<br>
            <input type="text" name="postcode_billing" value="" id="postcode_billing" class="large-field">
            <br>
            <br>
            <span class="required">*</span> Country:<br>
            <select id="country_billing" style="width:310px" name="country_billing">
                <option value="0"> --- Please Select --- </option>
                <?php foreach ($listcountry as $country) { ?>
                    <option value="<?php echo $country->kode ?>"><?php echo $country->name ?></option>
                <?php } ?>
            </select>
            <br>
            <br>
            <span class="required">*</span> Region / State:<br>
            <select id="region_billing"  style="width:310px" id="region_billing"  name="region_billing" >
                <option value="0"> --- Please Select --- </option>
            </select>


            <br>
            <br>
            <br>
        </div>
        <div style="clear: both; padding-top: 15px; border-top: 1px solid #EEEEEE;">
            <div class="divnotguest" style="display: none">
                <input type="checkbox" name="newsletter" value="1" id="newsletter">
                <label for="newsletter">I wish to subscribe to the The Paper Stone newsletter.</label>
                <br>
            </div>
            <input type="checkbox" name="same_address" value="1" id="shipping" checked="checked">
            <label for="shipping">My delivery and billing addresses are the same.</label>
            <br>
            <br>
            <br>
        </div>

    </div>
    <div class="buttons">
        <div class="right">
            <input type="button" value="Continue" id="btt_billing" class="button">
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
<?php if (GetUserId() == 0) { ?>
            $("#payment_billing-new").prop("checked", "checked");
            $(".bagbillingdisplay").css("display", "none");
<?php } ?>
        RefreshBilling();
    })

    function GetBillingDropDown(id)
    {
        $.ajax(
                {
                    url: baseurl + "/index.php/cart/GetAllAddressFromUser",
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        $("#dropdown_billing_address_id").empty();
                        $.each(data, function (index, value) {
                            subcat = $('<option />');
                            subcat.val(value.id_address_book);
                            subcat.text(value.first_name + " " + value.last_name + " , " + CleanTulisan(value.address) + ' , ' + value.city + ' , ' + value.state_name + ' , ' + value.country_name);
                            $("#dropdown_billing_address_id").append(subcat);


                        });
                        if (id != 0)
                        {
                            $("#dropdown_billing_address_id").val(id);
                        }

                        if (!$("#dropdown_billing_address_id option:selected").length) {
                            $("#dropdown_billing_address_id").prop('selectedIndex', 0);
                        }
                        
                       
                    },
                    error: function (xhr, status, error)
                    {

                        messageerror(xhr.responseText);
                    }
                });
    }
    $("#payment_billing-existing , #payment_billing-new").change(function () {
        RefreshBilling(0);
    })
    $("#country_billing").change(function () {
        RefreshDropDownCountry("#country_billing", "#region_billing", 0);

    })
    $("#btt_billing").click(function () {
        $.ajax(
                {
                    url: baseurl + "/index.php/cart/checkbilling",
                    data: $("#frmbillingdetails").serialize() + "&" + $.param({'isusenewaddress': isusenewaddress}),
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        if (data.st)
                        {

                            if ($("input#shipping").is(":checked") && isusenewaddress) {
                                $("#firstname_delivery").val($("#firstname_billing").val());
                                $("#lastname_delivery").val($("#lastname_billing").val());
                                $("#telephone_delivery").val($("#telephone_billing").val());
                                $("#fax_delivery").val($("#fax_billing").val());
                                $("#company_delivery").val($("#company_billing").val());
                                $("#telephone_delivery").val($("#telephone_billing").val());
                                $("#address_delivery").val($("#address_billing").val());
                                $("#fax_delivery").val($("#fax_billing").val());
                                $("#city_delivery").val($("#city_billing").val());
                                $("#postcode_delivery").val($("#postcode_billing").val());
                                $("#country_delivery").val($("#country_billing").val());
                                RefreshDropDownCountry("#country_delivery", "#region_delivery", $("#region_billing").val());
                                checkoutstepnum = 4;
                                GetBillingDropDown(data.id);
                                $("#payment_delivery-new").prop("checked", "checked");
                            }
                            else
                            {
                                checkoutstepnum = 3;
                            }
                            isusenewdelivery = isusenewaddress;
                            GetAddressDropDown(data.id);
                            RefreshDelivery();
                            strhtml = '';
                        if (data.shipment.length)
                        {
                            $.each(data.shipment, function (index, value) {
                                strhtml += "<tr ><td>";
                                strhtml += "<input type='radio' name='shipping_method' value='" + value.id_shipping + "' id='weight.weight_" + value.id_shipping + "' >";
                                strhtml += "</td><td><label for='weight.weight_" + value.id_shipping + "'>" + value.name_shipping + " ("+value.totalweight + " kg)</label>";
                                strhtml += "</td><td style='text-align: right;'><label for='weight.weight_" + value.id_shipping + "'>" + value.shipprice + "</label>"
                                strhtml += "</td></tr>";
                            })

                        }
                        else
                        {
                            strhtml += "No Shipment For your region"
                        }
                        $(".radio").html(strhtml);
                            checkoutstep();
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



    });
    $(document).ready(function () {
        GetBillingDropDown();

    })
    function RefreshBilling() {
        if ($("#payment_billing-existing").is(":checked"))
        {
            isusenewaddress = false;
            $("#billing-existing").css("display", "block");
            AnimationShow("#billing-existing", "full");
            $("#billing-new").css("display", "none");
        }
        else
        {
            isusenewaddress = true;
            $("#billing-existing").css("display", "none");
            $("#billing-new").css("display", "block");
            AnimationShow("#billing-new", "full");

        }
    }
</script>


