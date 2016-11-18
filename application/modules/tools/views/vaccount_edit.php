<?php
left_account("edit");
$objmodel = array();
if (GetUserId() > 0) {
    $objmodel = GetMemberData();
}
?>
<div id="content">  
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        » <a href="<?php echo base_url() . 'index.php/tools/account' ?>">Account</a>
        » <a href="<?php echo base_url() . 'index.php/tools/edit' ?>">Edit Account</a>
    </div>
    <h1>EDIT ACCOUNT</h1>
    <form id="frmupdateprofile" method="post" enctype="multipart/form-data">
        <h2>Your Personal Details</h2>
        <div class="content">
            <table class="form">
                <tbody>

                    <tr>
                        <td><span class="required">*</span> ID Card:</td>
                        <td>
                            <input type="hidden" name="member_id"  value="<?php echo $objmodel->id_customer_ecommerce ?>">

                            <input type="text" name="IC" disabled  value="<?php echo $objmodel->IC ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> First Name:</td>
                        <td><input type="text" name="first_name"  value="<?php echo $objmodel->first_name ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Last Name:</td>
                        <td><input type="text" name="last_name"  value="<?php echo $objmodel->last_name ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> E-Mail:</td>
                        <td><input disabled type="text" name="email"  value="<?php echo $objmodel->email ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Telephone:</td>
                        <td><input type="text" name="telephone"  value="<?php echo $objmodel->telephone ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Fax:</td>
                        <td><input type="text" name="fax"  value="<?php echo $objmodel->fax ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Address:</td>
                        <td><textarea type="text" name="address"  value=""><?php echo $objmodel->address ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Post Code:</td>
                        <td><input type="text" name="post_code"  value="<?php echo $objmodel->post_code ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Country:</td>
                        <td><select id="dropdown_country_id" name="country_id" style="width:160px;">
                                <option value="0"> --- Please Select --- </option>
                                <?php foreach ($listcountry as $country) { ?>
                                    <option value="<?php echo $country->kode ?>"><?php echo $country->name ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Region / State:</td>
                        <td><select id="dropdown_state_id" name="state_id" style="width:160px;" ><option value="0"> --- Please Select --- </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> City:</td>
                        <td><input type="text" name="city"  value="<?php echo $objmodel->city ?>">
                        </td>
                    </tr>

                </tbody></table>
        </div>
        <div class="buttons">
            <div class="left"><a href="<?php echo base_url() . 'index.php/tools/account' ?>" class="button">Back</a></div>
            <div class="right">
                <input type="submit" value="Save" class="button">
            </div>
        </div>
    </form>
</div>

<script>
    function RefreshCountry(state_id)
    {
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
                            if(state_id!=0)
                            {
                                 $('#dropdown_state_id').val(state_id);
                            }
                        });
                    },
                    error: function (xhr, status, error)
                    {

                        messageerror(xhr.responseText);
                    }
                });
    }
    $(document).ready(function(){
         $("#dropdown_country_id").val('<?php echo CheckEmpty(@$objmodel->country)?'0':@$objmodel->country?>');
          RefreshCountry(<?php echo CheckEmpty(@$objmodel->region)?'0':@$objmodel->region?>);
    })
    $("#dropdown_country_id").change(function () {
        RefreshCountry(0);
    })


    $("#frmupdateprofile").submit(function () {
        $.ajax({
            type: 'POST',
            url: baseurl + 'index.php/user/edit_info',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                if (data.st)
                {
                    window.location.href = baseurl + "index.php/tools/account";
                }
                else
                {
                    messageerror(data.msg);
                }
            },
            error: function (xhr, status, error) {
                messageerror(xhr.responseText);
            }
        });

        return false;


    })

</script>



