<script>
    var isusenewdelivery = false;
</script>
<form id="frmdeliverydetails">
    <div class="bagdeliverydisplay">
        <input type="radio" name="payment_delivery" value="existing" id="payment_delivery-existing" checked="checked">
        <label for="payment_delivery-existing">I want to use an existing address</label>
        <div id="delivery-existing" >
            <select name="delivery_address_id" id="dropdown_delivery_address_id" style="width: 100%; margin-bottom: 15px;" size="5">

            </select>
        </div>
        <p>
            <input type="radio" name="payment_delivery" value="new" id="payment_delivery-new">
            <label for="payment_delivery-new">I want to use a new address</label>
        </p>
    </div>
    <div id="delivery-new" style="">
        <table class="form">
            <tbody><tr>
                    <td><span class="required">*</span> First Name:</td>
                    <td><input type="text" name="firstname_delivery" id="firstname_delivery" value="" class="large-field"></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> Last Name:</td>
                    <td><input type="text" name="lastname_delivery" id="lastname_delivery" value="" class="large-field"></td>
                </tr>
                <tr>
                    <td>Company:</td>
                    <td><input type="text" name="company_delivery" id="company_delivery" value="" class="large-field"></td>
                </tr>

                <tr>
                    <td><span class="required">*</span> Address:</td>
                    <td><textarea  name="address_delivery" id="address_delivery" value="" class="large-field"></textarea></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> City:</td>
                    <td><input type="text" name="city_delivery" id="city_delivery" value="" class="large-field"></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> Telephone:</td>
                    <td><input type="text" name="telephone_delivery" id="telephone_delivery" value="" class="large-field"></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> Fax:</td>
                    <td><input type="text" name="fax_delivery" id="fax_delivery" value="" class="large-field"></td>
                </tr>
                <tr>
                    <td><span id="payment-postcode-required" class="required" style="display: none;">*</span> Post Code:</td>
                    <td><input type="text" name="postcode_delivery" id="postcode_delivery" value="" class="large-field"></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> Country:</td>
                    <td><select name="country_delivery" id="country_delivery" class="large-field">
                            <option value=""> --- Please Select --- </option>
                            <?php foreach ($listcountry as $country) { ?>
                                <option value="<?php echo $country->kode ?>"><?php echo $country->name ?></option>
                            <?php } ?>
                        </select></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> Region / State:</td>
                    <td>
                        <select name="region_delivery" id="region_delivery" class="large-field">
                            <option value="0"> --- Please Select --- </option>
                        </select>
                    </td>
                </tr>
            </tbody></table>
    </div>
    <br>
    <div class="buttons">
        <div class="right">
            <input type="button" value="Continue" id="btt_delivery" class="button">
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
<?php if (GetUserId() == 0) { ?>
            $("#payment_delivery-new").prop("checked", "checked");
            $(".bagdeliverydisplay").css("display", "none");
<?php } ?>
        RefreshDelivery();
    })
    $("#payment_delivery-existing , #payment_delivery-new").change(function () {

        RefreshDelivery();

    })

    function GetAddressDropDown(id)
    {
        $.ajax(
                {
                    url: baseurl + "/index.php/cart/GetAllAddressFromUser",
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        $("#dropdown_delivery_address_id").empty();
                        $.each(data, function (index, value) {
                            subcat = $('<option />');
                            subcat.val(value.id_address_book);
                            subcat.text(value.first_name + " " + value.last_name + " , " + CleanTulisan(value.address) + ' , ' + value.city + ' , ' + value.state_name + ' , ' + value.country_name);
                            $("#dropdown_delivery_address_id").append(subcat);


                        });
                        if (id != 0)
                        {
                            $("#dropdown_delivery_address_id").val(id);
                        }
                        if (!$("#dropdown_delivery_address_id option:selected").length) {
                            $("#dropdown_delivery_address_id").prop('selectedIndex', 0);
                        }
                    },
                    error: function (xhr, status, error)
                    {

                        messageerror(xhr.responseText);
                    }
                });
    }
    var strhtml = '';
    $("#btt_delivery").click(function () {
        $.ajax(
                {
                    url: baseurl + "/index.php/cart/checkdelivery",
                    data: $("#frmdeliverydetails").serialize() + "&" + $.param({'isusenewdelivery': isusenewdelivery}),
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        if (data.st)
                        {
                            checkoutstepnum = 4;
                            GetAddressDropDown(data.id);
                            RefreshDelivery();
                            checkoutstep();
                            strhtml = '';
                            if(data.shipment.length)
                            {
                                $.each(data.shipment, function (index, value) {
                                    strhtml += "<tr ><td>";
                                    strhtml += "<input type='radio' name='shipping_method' value='" + value.id_shipping + "' id='weight.weight_" + value.id_shipping + "' >";
                                    strhtml += "</td><td><label for='weight.weight_" + value.id_shipping + "'>" + value.name_shipping + "</label>";
                                    strhtml += "</td><td style='text-align: right;'><label for='weight.weight_" + value.id_shipping + "'>"+value.shipprice+"</label>"
                                    strhtml += "</td></tr>";
                                })
                            }
                            else
                            {
                                    strhtml+="No Shipment For your region"
                            }
                            $(".radio").html(strhtml);
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


    function RefreshDelivery() {
        if ($("#payment_delivery-existing").is(":checked"))
        {
            $("#delivery-existing").css("display", "block");
            isusenewdelivery = false;
            AnimationShow("#delivery-existing", "full");
            $("#delivery-new").css("display", "none");
        }
        else
        {
            $("#delivery-existing").css("display", "none");
            isusenewdelivery = true;
            $("#delivery-new").css("display", "block");
            AnimationShow("#delivery-new", "full");

        }
    }
    $("#country_delivery").change(function () {
        RefreshDropDownCountry("#country_delivery", "#region_delivery", 0);

    })

</script>