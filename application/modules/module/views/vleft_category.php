<div class="box">
    <div class="box-heading">Categories</div>
    <div class="box-content">
        <div class="box-category">
            <ul>
                <?php foreach ($listmenu as $menu) { ?>
                    <li>
                        <a 
                        <?php
                        if ($menu->cat_id == @$cat_id)
                            echo ' class="active" ';
                        ?>

                            href="<?php echo base_url() . 'index.php/user/view_category/' . $menu->cat_id . '?'.GetCurrencyPath(false,true).'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $menu->cat_name) . '.html' ?>"><?php echo $menu->cat_name; ?></a>
                            <?php if (count($menu->submenu) > 0) {
                                ?>
                            <ul>
                                        <?php foreach ($menu->submenu as $submenu) {
                                            ?>
                                        
                                            <li><a
                                                <?php
                                                if ($submenu->id_sub_category == @$sub_cat_id)
                                                    echo ' class="active" ';
                                                ?>  
                                                    href="<?php echo base_url() . 'index.php/user/view_sub_category/' . $submenu->id_sub_category . '?'.GetCurrencyPath(false,true).'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $submenu->name_sub_category) . '.html' ?>"><?php echo $submenu->name_sub_category . ' (' . $submenu->countitem . ')'; ?></a></li>
                                        <?php } ?>
                            </ul>

                        <?php }
                        ?>
                    </li>


                <?php } ?>



            </ul>
        </div>
    </div>
</div>