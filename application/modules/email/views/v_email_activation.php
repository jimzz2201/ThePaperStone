<style>
    .areaclick:hover a{
        background-color: #fff !important;;
        color:#FF0097 !Important;

    }

</style>
<div style="max-width:600px;margin:0 auto;overflow:hidden;border:solid 2px #000;font-family: 'Century Gothic', CenturyGothic, arial, sans-serif">
    <div style='text-align:center;padding:10px;'>
        <img src='<?php echo base_url() . 'images/logo.png' ?>' style='margin:0 auto;' />
    </div>
    <div style="padding:16px;background-color:#f2f0f3;border-top-style:none;">
        <p style="font-size:14px;">Hi <?php echo @$email ?>
            <span style="font-weight:bold;font-style:italic">
                <br>
                <br>
            </span>
        </p>
        <p>
            Thank you for creating The Paper Stone account. Please activate your account by click button below
        </p>
        <p>
            <br/>
        </p>
        <div class='areaclick' style="font-size:14px;font-weight:bold;text-align:center">
            <a style='font-size:32px;text-decoration:none;background-color:#FF0097;width:80%;margin:0 auto;display:block;color:#fff; padding:10px;border:solid 1px #000;' href="<?php echo base_url() . 'index.php/tools/activationdirectly?email=' . $model['email'] . '&&activation=' . $model['activation'] ?>">Click Here</a></div><br><div>
        </div>
        <p>
            If you have issue with click link above , you can copy url below and follow the step for activate your account
        </p> 
        <pre style='margin-top:-20px;'>
        <p style='font-size:12px;display:block;'>
URL : <br/> <?php echo base_url() . 'index.php/tools/activate#konfirmation_email' ?> <br/>
Email :<br/> <?php echo $model['email'] ?> <br/>
Activation Code :<br/> <?php echo $model['activation'] ?>
        </p>
        </pre>
        <p>
            For more information about The Paper Stone please  <b><i><a href="<?php echo base_url() ?>">Click Here</a></i></b>
        </p>
        <br>
        <br>
        <p>
            Thanks!
        </p>
        <br>
        <br>

    </div>
    <div style="padding:10px;text-align:center;font-family:helvetica, sans-serif, arial;font-size:11px;color:#999999;" >
        Copyright © 2015,The Paper Stone. To unsubscribe click <a rel="noreferrer" target="_blank" href="<?php echo base_url() . 'index.php/tools/unsuscribe?email=' . $model['email'] . '&&usc=' . $model['activation'] ?>" style="color:#990000;" >here</a>.</div>
</div>