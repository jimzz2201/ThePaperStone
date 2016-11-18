


<div id="column-left">
    <div class="box">
        <div class="box-heading">Account</div>
        <div class="box-content">
            <ul>
                <?php if (GetUserId() == '0') { ?>
                    <li><a href="<?php echo base_url() . 'index.php/user/login' ?>">Login</a> / <a href="<?php echo base_url() . 'index.php/user/register' ?>">Register</a></li>
                    <li><a href="<?php echo base_url() . 'index.php/user/forgot' ?>">Forgotten Password</a></li>
                     <li><a href="<?php echo base_url() . 'index.php/tools/activate' ?>">Activate  Account</a></li>
                <?php } else { ?>
                    <li <?php echo $acc=="info"?'class="active"':''?>><a href="<?php echo base_url() . 'index.php/tools/account' ?>">My Account</a></li>
                      <li <?php echo $acc=="edit"?'class="active"':''?>><a href="<?php echo base_url() . 'index.php/tools/edit' ?>">Edit Account</a></li>
                    <li><a href="http://www.thepaperstone.com/index.php?route=account/account">Change Password</a></li>
                    <li><a href="http://www.thepaperstone.com/index.php?route=account/address">Address Books</a></li>
                    <li><a href="http://www.thepaperstone.com/index.php?route=account/wishlist">Wish List</a></li>
                    <li><a href="http://www.thepaperstone.com/index.php?route=account/order">Order History</a></li>
                    <li><a href="http://www.thepaperstone.com/index.php?route=account/transaction">Transactions</a></li>
                    <li><a href="http://www.thepaperstone.com/index.php?route=account/newsletter">Newsletter</a></li>
                    <li><a href="http://www.thepaperstone.com/index.php?route=account/recurring">Recurring payments</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>