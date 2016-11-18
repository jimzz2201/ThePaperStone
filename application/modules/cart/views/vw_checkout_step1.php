<?php if (GetUserId() == 0) { ?>
    <div class="left">
        <h2>New Customer</h2>
        <p>Checkout Options:</p>
        <label for="register">
            <input type="radio" name="account" value="register" id="register" checked="checked">
            <b>Register Account</b></label>
        <br>
        <label for="guest">
            <input type="radio" name="account" value="guest" id="guest">
            <b>Guest Checkout</b></label>
        <br>
        <br>
        <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
        <input type="button" value="Continue" id="button-account" class="button">
        <br>
        <br>
    </div>
    <div class="right textleft">
        <h2>Returning Customer</h2>
        <form  method="post" id="frmlogin" enctype="multipart/form-data">
            <div class="content" >
                <p>I am a returning customer</p>
                <b>E-Mail Address:</b><br>
                <input type="hidden" name="isremove" value="1">
                <input type="text" name="email" value="">
                <br>
                <br>
                <b>Password:</b><br>
                <input type="password" name="password" value="">
                <br>
                <a href="<?php echo base_url() . 'index.php/user/forgot' ?>">Forgotten Password</a><br>
                <br>
                <div style="text-align:left">
                    <input type="submit" value="Login" class="button" >
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            
            refreshisguest();
        })
        function refreshisguest(){
             if ($("#register").is(":checked")) {
                $("#step2 .checkout-headingunclick span").html("Step 2: Account & Billing Details");
                $(".divnotguest").css("display", "block");
                $("#isguest").val(0);
            } else
            {
                $(".divnotguest").css("display", "none");
                $("#step2 .checkout-headingunclick span").html("Step 2: Billing Details");
                $("#isguest").val(1);
            }
        }
        $("#register , #guest").change(function () {
           refreshisguest();
        })
        $("#button-account").click(function () {
            checkoutstepnum = 2;
            checkoutstep();
        })
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
<?php } ?>