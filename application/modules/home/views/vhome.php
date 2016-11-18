<link href="<?php echo base_url() ?>asset/user/css/nivo-slider.css" rel="stylesheet" type="text/css">
<?php if (count(@$slider) > 0) { ?>

    <div class="slideshow">
        <div id="slideimage" class="nivoSlider" style="height:400px;">
            <?php foreach (@$slider as $slide) { ?>
                <a href="<?php echo CheckEmpty($slide->link) ? 'javascript:;' : $slide->link ?>"><img src="<?php echo base_url() . 'images/slider/' . $slide->filename ?>" alt="" title="<?php echo $slide->name ?>" /></a>     
            <?php } ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <script>
        $(document).ready(function () {
            $("#slideimage").nivoSlider({
                effect: 'random',
                controlNav: false
            });
        });
    </script>
<?php } ?>
<div class="welcome_text">
    <?php if (count(@$banner) > 0) { ?>
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tbody>
                <tr>
                    <?php foreach (@$banner as $bannersatuan) { ?>
                        <td style="width: 310px; vertical-align: top;"><a href="<?php echo CheckEmpty($bannersatuan->link) ? 'javascript:;' : $bannersatuan->link ?>"><img alt="" src="<?php echo base_url() . 'images/banner/' . $bannersatuan->filename ?>" style="width: 310px; height: 170px;"></a></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    <?php } ?>
</div>
<?php featured_product(5);?>