<?php left_account() ?>


<div id="content">  
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        » <a href="<?php echo base_url() . 'index.php/tools/account' ?>">Account</a>
        » <a href="<?php echo base_url() . 'index.php/user/register' ?>">Register</a>
    </div>
    <h1>Register Account</h1>
    <p>If you already have an account with us, please login at the <i><b><a href="<?php echo base_url() . 'index.php/user/login' ?>">login page</a></b></i>.</p>
    <form id="frmregister" method="post" >
        <h2>Your Personal Details</h2>
        <div class="content">
            <table class="form">
                <tbody><tr>
                        <td><span class="required">*</span> First Name:</td>
                        <td><input type="text" name="firstname" value="">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Last Name:</td>
                        <td><input type="text" name="lastname" value="">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> E-Mail:</td>
                        <td><input type="text" name="email" value="">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Telephone:</td>
                        <td><input type="text" name="telephone" value="">
                        </td>
                    </tr>
                    <tr>
                        <td>Fax:</td>
                        <td><input type="text" name="fax" value=""></td>
                    </tr>
                </tbody></table>
        </div>
        <h2>Your Address</h2>
        <div class="content">
            <table class="form">
                <tbody><tr>
                        <td>Company:</td>
                        <td><input type="text" name="company" value=""></td>
                    </tr>        
                    <tr style="display: none;">
                        <td>Business Type:</td>
                        <td>                        <input type="radio" name="customer_group_id" value="1" id="customer_group_id1" checked="checked">
                            <label for="customer_group_id1">Default</label>
                            <br>
                        </td>
                    </tr>      
                    <tr id="company-id-display">
                        <td><span id="company-id-required" class="required" style="display: none;">*</span> Company ID:</td>
                        <td><input type="text" name="company_id" value="">
                        </td>
                    </tr>
                    <tr id="tax-id-display" style="display: none;">
                        <td><span id="tax-id-required" class="required">*</span> Tax ID:</td>
                        <td><input type="text" name="tax_id" value="">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Address:</td>
                        <td><input type="text" name="address" value="">
                        </td>
                    </tr>

                    <tr>
                        <td><span class="required">*</span> City:</td>
                        <td><input type="text" name="city" value="">
                        </td>
                    </tr>
                    <tr>
                        <td><span id="postcode-required" class="required" style="display: none;">*</span> Post Code:</td>
                        <td><input type="text" name="postcode" value="">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Country:</td>
                        <td><select id="dropdown_country_id" name="country_id">
                                <option value="0"> --- Please Select --- </option>
                                <?php foreach ($listcountry as $country) { ?>
                                    <option value="<?php echo $country->kode ?>"><?php echo $country->name ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Region / State:</td>
                        <td><select id="dropdown_state_id" name="state_id" ><option value="0"> --- Please Select --- </option>
                            </select>
                        </td>
                    </tr>
                </tbody></table>
        </div>
        <h2>Your Password</h2>
        <div class="content">
            <table class="form">
                <tbody><tr>
                        <td><span class="required">*</span> Password:</td>
                        <td><input type="password" name="password" value="">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Password Confirm:</td>
                        <td><input type="password" name="confirm" value="">
                        </td>
                    </tr>
                </tbody></table>
        </div>
        <h2>Newsletter</h2>
        <div class="content">
            <table class="form">
                <tbody><tr>
                        <td>Subscribe:</td>
                        <td>            <input type="radio" name="newsletter" value="1">
                            Yes            <input type="radio" name="newsletter" value="0" checked="checked">
                            No            </td>
                    </tr>
                </tbody></table>
        </div>
        <div class="buttons">
            <div class="right">I have read and agree to the <a class="colorbox cboxElement" href="http://www.thepaperstone.com/index.php?route=information/information/info&amp;information_id=3" alt="Privacy Policy"><b>Privacy Policy</b></a>                <input type="checkbox" name="agree" value="1">
                <input type="submit" value="Continue" class="button">
            </div>
        </div>
    </form>
</div>
<script>
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

    $("form#frmregister").submit(function () {
        LoadBar.show();
        $.ajax(
                {
                    url: baseurl + "/index.php/user/register_action",
                    data: $(this).serialize(),
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        if (data.st)
                        {
                            $('form#frmregister')[0].reset();
                            messagesuccess(data.msg);
                        }
                        else
                        {
                            messageerror(data.msg);
                        }
                    },
                    error: function (xhr, status, error)
                    {
                        messageerror(xhr.responseText);
                    },
                    complete: function () {
                        LoadBar.hide();
                    }
                });
        return false;
    });
</script>    