<div id="column-left">
    <?php left_category(@$cat_id); ?>
    <div id="banner0" class="banner">
        <div style="display: block;"><img src="http://www.thepaperstone.com/image/cache/data/180x180px free shipping-180x180.jpg" alt="HP Banner" title="HP Banner"></div>
    </div> 
</div>
<div id="content" class="inside_page">
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>
        <?php if (!CheckEmpty(@$model)) { ?>
            »<a href="<?php echo base_url() . 'index.php/user/view_category/' . $model->cat_id . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $model->cat_name) . '.html' ?>"><?php echo @$model->cat_name ?></a>
        <?php } ?>
    </div>

    <div class="category-info">
        <?php if (!CheckEmpty(@$model)) { ?>
            <h1><?php echo @$model->cat_name ?></h1>
        <?php } else { ?>
            <h1>Category not Found</h1>
        <?php } ?>
    </div>
    <?php if (count(@$model->submenu) > 1) { ?>
        <h2 >Refine Search</h2>
        <div class="category-list">
            <ul>
                <?php foreach (@$model->submenu as $submenu) { ?>
                    <li><a href="<?php echo base_url() . 'index.php/user/view_sub_category/' . $submenu->id_sub_category . '?' . GetCurrencyPath(false, true) . 'name=' . preg_replace("/[^a-zA-Z0-9]+/", "-", $submenu->name_sub_category) . '.html' ?>"><?php echo $submenu->name_sub_category . ' (' . $submenu->countitem . ')'; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <?php include APPPATH . 'modules/module/views/vview_product_category.php' ?>   
    <?php featured_product(4); ?></div>
