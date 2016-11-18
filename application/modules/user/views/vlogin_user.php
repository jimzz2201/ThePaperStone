<?php left_account() ?>
<div id="content">  
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        » <a href="<?php echo base_url() . 'index.php/tools/account' ?>">Account</a>
        » <a href="<?php echo base_url() . 'index.php/user/login' ?>">Login</a>
    </div>

    <div class="login-content">
        <div class="left">
            <h2>New Customer</h2>
            <div class="content" style="min-height:initial">
                <p><b>Register Account</b></p>
                <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                <a href="<?php echo base_url() . 'index.php/user/register' ?>" class="button">Continue</a></div>
             <h2>Activate / link your Account</h2>
            <div class="content"  style="min-height:initial">
                <p>For activating your account. And start for shopping in The Paper Stone </p>
                <a href="<?php echo base_url() . 'index.php/tools/activate' ?>" class="button">Continue</a></div>
        </div>
        <div class="right">
            <h2>Returning Customer</h2>
            <form  method="post" id="frmlogin" enctype="multipart/form-data">
                <div class="content" >
                    <p>I am a returning customer</p>
                    <b>E-Mail Address:</b><br>
                    <input type="text" name="email" value="">
                    <br>
                    <br>
                    <b>Password:</b><br>
                    <input type="password" name="password" value="">
                    <br>
                    <a href="<?php echo base_url().'index.php/user/forgot'?>">Forgotten Password</a><br>
                    <br>
                    <div style="width:100%;text-align:center">
                        <input type="submit" value="Login" class="button" style="width:100%">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#frmlogin").submit(function () {
        $.ajax({
            type: 'POST',
            url: baseurl + 'index.php/user/login_validation',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                if (data.st)
                {
                    window.location.reload();
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
    });
</script>