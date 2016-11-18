<?php
left_account('');
$objmodel = array();
if (GetUserId() > 0) {
    $objmodel = GetMemberData();
}
?>
<div id="content">  
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        » <a href="<?php echo base_url() . 'index.php/tools/account' ?>">Account</a>
        » Set Up Password
    </div>
    <h1>Set Up Password</h1>
    <form id="frmupdateprofile" method="post" enctype="multipart/form-data">
        <h2>Your Personal Details</h2>
        <div class="content">
            <table class="form">
                <tbody>

                    <tr>
                        <td><span class="required">*</span> Password:</td>
                        <td>
                            <input type="hidden" name="member_id"  value="<?php echo $objmodel->id_customer_ecommerce ?>">

                            <input type="password" name="password"  value="">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Confirm Password:</td>
                        <td><input type="password" name="confirm"  value="">
                        </td>
                    </tr>
                    

                </tbody></table>
        </div>
        <div class="buttons">
            <div class="left"> <input type="submit" value="Save" class="button"></div>
            <div class="right">
                <input type="submit" value="Save" class="button">
            </div>
        </div>
    </form>
</div>

<script>
    


    $("#frmupdateprofile").submit(function () {
        $.ajax({
            type: 'POST',
            url: baseurl + 'index.php/tools/new_password_action',
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



