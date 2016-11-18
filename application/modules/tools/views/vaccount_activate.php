<?php left_account('');?>
<div id="content">  
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        » <a href="<?php echo base_url() . 'index.php/tools/account' ?>">Account</a>
        » <a href="<?php echo base_url() . 'index.php/tools/activate' ?>">Activate Account</a>
    </div>
    <h1>Activate ACCOUNT</h1>

    <div id="send_email">
        <div class="checkout-heading"><span>Send Activation Code</span></div>
        <div class="checkout-content" style="display: none;">
            <div class="left">
                <h2>Your Email</h2>
                <span class="required">*</span> Email:<br>
                <input type="text" name="email" id='txt_email_sent' value="" class="large-field">
            </div>

            <div style="clear: both; padding-top: 15px;">

            </div>
            <div class="buttons">
                <div class="left">
                    <input type="button" value="Continue" id="button-sendemailactivation" class="button">
                </div>
            </div>


        </div>
    </div>
    <div id="konfirmation_email">
        <div class="checkout-heading"><span>Complete your activation</span></div>
        <div class="checkout-content" style="display: none;">
            <div class="left">
                <h2>Your Email</h2>
                <span class="required">*</span> Email:<br>
                <input type="text" id='txt_email_complete' name="txt_email_complete" value="" class="large-field"><br/><br/>
                <span class="required">*</span> Activation Code:<br>
                <input type="text" id='txt_activation_code' name="txt_activation_code" value="" class="large-field">

            </div>

            <div style="clear: both; padding-top: 15px; ">

            </div>
            <div class="buttons">
                <div class="left">
                    <input type="button" value="Continue" id="button-activ" class="button">
                </div>
            </div>


        </div>
    </div>
</div>
<script>
    var hash = window.location.hash;
    if (hash)
    {
        $(hash + " .checkout-content").css("display", "block");
    }
    else
    {
        $("#send_email .checkout-content").css("display", "block");
    }
    $("#button-sendemailactivation").click(function () {
        LoadBar.show();
        $.ajax(
                {
                    url: baseurl + "index.php/tools/activate_sent",
                    data: {
                        email:$("#txt_email_sent").val()
                        
                    },
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        if (data.st)
                        {
                            $("#txt_email_sent").val('');
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
                    complete:function(){
                         LoadBar.hide();
                        
                    }
                });


    })
    $("#button-activ").click(function () {
        LoadBar.show();
        $.ajax(
                {
                    url: baseurl + "index.php/tools/activate_process",
                    data: {
                        email:$("#txt_email_complete").val(),
                        activationcode:$("#txt_activation_code").val()
     
                    },
                    dataType: "json",
                    type: "post",
                    success: function (data)
                    {
                        if (data.st)
                        {
                            window.location.href=data.url;
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
                    complete:function(){
                         LoadBar.hide();          
                    }
                });


    })
</script>