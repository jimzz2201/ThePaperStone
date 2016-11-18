<?php
left_account("info");
$objmodel = array();
if (GetUserId() > 0) {
    $objmodel = GetMemberData();
}
?>
<div id="content">  
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        » <a href="<?php echo base_url() . 'index.php/tools/account' ?>">Account</a>
        » <a href="<?php echo base_url() . 'index.php/tools/account' ?>">Account Information</a>
    </div>
    <h1>My Account Information</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <h2>Your Personal Details</h2>
        <div class="content">
            <table class="form">
                <tbody>

                    <tr>
                        <td><span class="required">*</span> ID Card:</td>
                        <td>
                            <input type="hidden" name="member_id"  value="<?php echo $objmodel->id_customer_ecommerce ?>">

                            <input type="text" name="IC" disabled value="<?php echo $objmodel->IC ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> First Name:</td>
                        <td><input type="text" name="first_name" disabled value="<?php echo $objmodel->first_name ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Last Name:</td>
                        <td><input type="text" name="last_name" disabled value="<?php echo $objmodel->last_name ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> E-Mail:</td>
                        <td><input type="text" name="email" disabled value="<?php echo $objmodel->email ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Telephone:</td>
                        <td><input type="text" name="telephone" disabled value="<?php echo $objmodel->telephone ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Fax:</td>
                        <td><input type="text" name="fax" disabled value="<?php echo $objmodel->fax ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Address:</td>
                        <td><textarea type="text" name="address" disabled value=""><?php echo $objmodel->address ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Post Code:</td>
                        <td><input type="text" name="post_code" disabled value="<?php echo $objmodel->post_code ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Country:</td>
                        <td><input type="text" name="country" disabled value="<?php echo $objmodel->country_name ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> Region:</td>
                        <td><input type="text" name="region" disabled value="<?php echo $objmodel->state_name ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> City:</td>
                        <td><input type="text" name="city" disabled value="<?php echo $objmodel->city ?>">
                        </td>
                    </tr>
                </tbody></table>
        </div>
        <div class="buttons">
            <div class="left">
                <a href="<?php echo base_url() . 'index.php/tools/edit' ?>" class="button">Edit</a>
            </div>

        </div>
    </form>
</div>