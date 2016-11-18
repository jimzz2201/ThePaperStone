
</div>

<div id="footer">
    <div class="column">
        <h3>Information</h3>
        <ul>
            <li><a href="http://www.thepaperstone.com/index.php?route=information/information&amp;information_id=4">About Us</a></li>
            <li><a href="/index.php?route=information/tpsmembership">TPS Membership Card</a></li>     	 <li><a href="http://www.thepaperstone.com/index.php?route=information/information&amp;information_id=8">Careers</a></li>
            <li><a href="http://www.thepaperstone.com/index.php?route=information/information&amp;information_id=3">Privacy Policy</a></li>
            <li><a href="http://www.thepaperstone.com/index.php?route=information/contact">Contact Us</a></li>
        </ul>
    </div>

    <div class="column">
        <h3>SHOPPING</h3>
        <ul>
            <li><a href="http://www.thepaperstone.com/index.php?route=information/information&amp;information_id=6">Shipping &amp; Delivery</a></li>
            <li><a href="http://www.thepaperstone.com/index.php?route=information/information&amp;information_id=9">Exchanges &amp; Refunds</a></li>
            <li><a href="http://www.thepaperstone.com/index.php?route=information/information&amp;information_id=10">FAQ</a></li>
            <li><a href="http://www.thepaperstone.com/index.php?route=information/information&amp;information_id=5">Terms of Service</a></li>
        </ul>
    </div>
    <div class="column">

        <h3>STORE LOCATIONS</h3>
        <ul>
            <li><a href="http://www.thepaperstone.com/index.php?route=information/information&amp;information_id=12">Store Listing</a></li>
        </ul>
    </div>
    <div class="column">
        <h3>My Account</h3>
        <ul>
            <li><a href="http://www.thepaperstone.com/index.php?route=account/account">My Account</a></li>
            <li><a href="http://www.thepaperstone.com/index.php?route=account/order">Order History</a></li>
            <li><a href="http://www.thepaperstone.com/index.php?route=account/wishlist">Wish List</a></li>
            <!--<li><a href="http://www.thepaperstone.com/index.php?route=account/newsletter">Newsletter</a></li>-->
        </ul>
    </div>
    <div class="big_column">
        <a href="http://www.facebook.com/ThePaperStone" class="icon_facebook" title="Facebook">Facebook</a>
        <a href="http://www.twitter.com/ThePaperStone" class="icon_tweet" title="Twitter">Twitter</a>
        <a href="http://www.instagram.com/ThePaperStoneSG" class="icon_instagram" title="Instagram">Instagram</a>
        <a href="http://www.pinterest.com/ThePaperStone" class="icon_pinterest" title="Pinterest">Pinterest</a>

        <div class="clear"></div>
        <div class="h20"></div>
        <div class="h20"></div>
        <div class="h20"></div>
        <div class="h10"></div>
        <!-- Begin MailChimp Signup Form -->
        <link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
        <style type="text/css">
            #mc_embed_signup{margin:0;padding:0;background:none;width:100%; clear:left; font:9px Helvetica,Arial,sans-serif;color:#fff;margin-top:-75px; }


            #mc_embed_signup .button{
                margin-top:15px;
            }
        </style>
        <div id="mc_embed_signup">
            <form accept-charset="UTF-8" method="post" target="_blank" id="fromsubscribe">
                <h2>NEWS, OFFERS, &amp; MORE!</h2>
                <div style="margin:0;padding:0;display:inline">
                    <input name="utf8" type="hidden" value="✓">
                </div>
                <div style="padding-bottom: 5px;">
                    <input id="salutation" name="salutation" type="text" placeholder="Mr">
                </div>
                <div style="padding-bottom: 5px;">
                    <input id="name" name="name" type="text" placeholder="John Doe">
                </div>
                <div style="padding-bottom: 5px;">
                    <input id="email" name="email" type="text" placeholder="you@example.com">
                </div>
                <div style="width:auto;float:left;">
                    <input type="submit" value="Subscribe" name="subscribe" id="webform_submit_button" class="button" data-default-text="Subscribe" data-submitting-text="Sending..." data-invalid-text="↑ You forgot some required fields" data-choose-list="↑ Choose a list" data-thanks="Thank you!">
                </div>
            </form>





        </div>

        <img src="<?php echo base_url() ?>images/paypal.jpg" alt="paypal" style="width:100%">

    </div>  
    <div class="clear"></div>
    <div class="footer_btm">
        <div id="powered"> © 2016  &nbsp; |  &nbsp;  Copyright of TPS Central Pte Ltd (trading under the brand The Paper Stone)</div>
    </div>
</div>

<div data-remodal-id="mymodal" role="dialog" aria-labelledby="modal2Title" aria-describedby="modal2Desc">
    <div>
        <p id="modaldesc">
        </p>
    </div>
</div>

</div>
<?php
foreach (@$javascript as $item) {
    ?> 
    <script type="text/javascript" src="<?php echo base_url() . $item ?>" ></script>
<?php }
?>

<script>

    $("#fromsubscribe").submit(function () {
        $.ajax({
            type: 'POST',
            url: baseurl + 'index.php/user/subscribe',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                if (data.st)
                {
                    messagesuccess(data.msg);
                    $("#name").val("");
                    $("#email").val("");
                    $("#salutation").val("");
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
    
    
    <?php 
    
    $st=  GetMessageStatus();
    $msg=  GetMessage();
    if($st!=5&&@$msg!='')
    {
        if($st=='0')
        {
            echo 'messageerror("'.$msg.'");';
        }
        else
        {
            echo 'messagesuccess("'.$msg.'");'; 
        }
        SetMessageSession(5, '');
    }
    ?>
    
    
</script>

<div class="loadbar hide" style="width:100%;position:fixed;top:0;height:100%;z-index: 9998">
    <div style="width:100%;background-color: #000;height:100%;opacity:0.4;">
        
    </div>
    <div style="position:absolute;top:10%;margin: 0 auto;text-align: center;width:100%;">
        <img src='<?php echo base_url().'images/loading.gif'?>' /> 
    </div>
</div>
</body>
</html>