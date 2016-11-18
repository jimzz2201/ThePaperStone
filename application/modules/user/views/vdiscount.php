<div id="column-left">
    <?php left_category(@$cat_id); ?>
    <div id="banner0" class="banner">
        <div style="display: block;"><img src="http://www.thepaperstone.com/image/cache/data/180x180px free shipping-180x180.jpg" alt="HP Banner" title="HP Banner"></div>
    </div> 
</div>
<div id="content" class="inside_page">
    <div class="breadcrumb">
        <a href="<?php echo base_url() ?>">Home</a>

    </div>

    <div class="category-info">
        <?php if (!CheckEmpty(@$model)) { ?>
            <h1><?php echo @$model->nama_discount ?></h1>
        <?php } else { ?>
            <h1>Category not Found</h1>
        <?php } ?>
    </div>

    <?php include APPPATH . 'modules/module/views/vview_product_category.php' ?>   
</div>
